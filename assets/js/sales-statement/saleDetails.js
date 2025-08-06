function atualizarToast(toast, title, body, isSuccess = true) {
    $('#toastTitle').text(title);
    $('#toastBody').text(body);
    //remove class bg-success
    if (isSuccess) {
        $('#'+toast).removeClass('bg-danger');
        $('#'+toast).addClass('bg-success');
    } else {
        $('#'+toast).removeClass('bg-success');
        $('#'+toast).addClass('bg-danger');
    }
    var myToast = new bootstrap.Toast(document.getElementById(toast));
    myToast.show();
}

function atualizarValorTotal() {
    let total = 0;
    $('#selected .card-product').each(function () {
        let id = $(this).data('id');
        let valor = parseFloat($(this).find('#total-price-' + id).val().replace(/\./g, '').replace(',', '.'));
        if (!isNaN(valor)) {
            total += valor;
        }
    });
    $('#total-price').text(total.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    $('#total-input').val(total.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    $('#total-price-modal').text(total.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
}

function adicionarProduto(prod) {
    if (selecionados.has(prod.id)) return;

    selecionados.add(prod.id);

    if (prod.quantidade == undefined || prod.quantidade <= 0)
        prod.quantidade = 1;

    if (prod.item == undefined)
        prod.item = false;

    const card = $(`
        <div class="col-12 mb-3">
            <div class="card card-product shadow-sm p-0" data-id="${prod.id}">
                <input type="hidden" name="items[${prod.id}][id]" value="${prod.id}">
                <input type="hidden" name="items[${prod.id}][item]" value="${prod.item}">
                <div class="row g-0 align-items-center">
                    <div class="col-md-2 col-12">
                        <img src="${prod.imagem}" class="product-img m-3" alt="${prod.nome}">
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="card-body py-3">
                            <h5 class="card-title mb-1">${prod.nome}</h5>
                            <p class="card-text mb-1"><small class="text-muted">${prod.subtitulo}</small></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="card-body py-3">
                            <span class="card-text fw-bold text-success">R$${prod.preco}</span>
                            <p class="card-text mb-1"><small class="text-muted">${prod.estoque} uni</small></p>
                        </div>
                    </div>
                    <div class="col-md-1 col-12 text-end">
                        <button type="button" class="btn-close btn-remove" aria-label="Remover"></button>
                    </div>
                </div>
                <div class="row g-0 align-items-center mb-3">
                    <div class="col-md-4 col-12 align-items-center px-3">
                        <label for="qtd-items-${prod.id}" class="">Quantidade</label>
                        <div class="d-flex align-items-center justify-content-between">
                            <button type="button" class="btn btn-sm btn-danger qtd" data-id="${prod.id}" data-action="decrement">
                                <i class="fa fa-minus"></i>
                            </button>
                            <input id="stock-${prod.id}" type="hidden" value="${prod.estoque}">
                            <input id="qtd-items-${prod.id}" name="items[${prod.id}][qtd]" type="text" class="form-control mx-2" value="${prod.quantidade}" min="1" readonly>
                            <button type="button" class="btn btn-sm btn-success qtd" data-id="${prod.id}" data-action="increment">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 my-md-0 my-3 align-items-center px-3">
                        <label for="discount-${prod.id}" class="">Desconto (R$)</label>
                        <div class="text-end">
                            <input id="discount-${prod.id}" name="items[${prod.id}][discount]" type="text" class="form-control moedaReal" value="${prod.desconto}">
                        </div>
                    </div>
                    <div class="col-md-4 col-12 align-items-center px-3">
                        <label for="total-price-${prod.id}" class="">Valor (R$)</label>
                        <div class="text-end">
                            <input id="base-price-${prod.id}" type="hidden" value="${prod.preco}">
                            <input id="total-price-${prod.id}" name="items[${prod.id}][total_price]" type="text" class="form-control moedaReal" value="${prod.total}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);

    card.find('.btn-remove').on('click', function () {
        selecionados.delete(prod.id);
        card.remove();
        atualizarSugestoes();
        atualizarValorTotal();
    });

    card.find('.qtd').on('click', function () {
        const action = $(this).data('action');
        const id = $(this).data('id');
        const input = $(`#qtd-items-${id}`);
        let currentValue = parseInt(input.val());
        let previousValue = currentValue;
        if (action === 'increment') {
            currentValue += 1;
        } else if (action === 'decrement' && currentValue > 1) {
            currentValue -= 1;
        }
        input.val(currentValue);
        verificarEstoque(id);
        atualizarDesconto(id, previousValue, currentValue);
        atualizarTotal(id);
        atualizarValorTotal();
    });

    function verificarEstoque(id) {
        const estoque = parseInt($(`#stock-${id}`).val());
        const quantidade = parseInt($(`#qtd-items-${id}`).val());
        if (quantidade > estoque) {
            $(`#qtd-items-${id}`).addClass('is-invalid');
        } else {
            $(`#qtd-items-${id}`).removeClass('is-invalid');
        }
    }

    function atualizarDesconto(id, previousValue, currentValue) {

        let desconto = $(`#discount-${id}`).val();
        desconto = desconto ? parseFloat(desconto.replace(/\./g, '').replace(',', '.')) : 0;

        let descontoTotal = (desconto / previousValue) * currentValue;
        $(`#discount-${id}`).val(descontoTotal.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    }


    function atualizarTotal(id) {
        const quantidade = parseInt($(`#qtd-items-${id}`).val());

        let precoUnitario = $(`#base-price-${id}`).val();
        precoUnitario = precoUnitario ? parseFloat(precoUnitario.replace(/\./g, '').replace(',', '.')) : 0;

        let desconto = $(`#discount-${id}`).val();
        desconto = desconto ? parseFloat(desconto.replace(/\./g, '').replace(',', '.')) : 0;

        const total = ((precoUnitario * quantidade) - desconto).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});

        $(`#total-price-${id}`).val(total);
    }

    // Keep adding continuously on mousedown
    card.find('.qtd').on('mousedown', function () {
        const id = $(this).data('id');
        const input = $(`#qtd-items-${id}`);
        let previousValue = parseInt(input.val());
        let currentValue = parseInt(input.val());
        const action = $(this).data('action');

        const interval = setInterval(function () {
            previousValue = currentValue;
            if (action === 'increment') {
                currentValue += 1;
            } else if (action === 'decrement' && currentValue > 1) {
                currentValue -= 1;
            }
            input.val(currentValue);
            verificarEstoque(id);
            atualizarDesconto(id, previousValue, currentValue);
            atualizarTotal(id);
            atualizarValorTotal();
        }, 100);

        $(document).on('mouseup', function () {
            clearInterval(interval);
        });
    });

    card.find('#discount-' + prod.id).on('input', function () {
        const id = prod.id;
        let desconto = $(this).val();
        desconto = desconto ? parseFloat(desconto.replace(/\./g, '').replace(',', '.')) : 0; 
        atualizarTotal(id);
        atualizarValorTotal();
    });

    card.find('#total-price-' + prod.id).on('input', function () {
        const id = prod.id;
        let total = $(this).val();
        total = total ? parseFloat(total.replace(/\./g, '').replace(',', '.')) : 0;
        const precoUnitario = parseFloat($(`#base-price-${id}`).val().replace(/\./g, '').replace(',', '.'));
        const quantidade = parseInt($(`#qtd-items-${id}`).val());
        const desconto = (precoUnitario * quantidade) - total;
        $(`#discount-${id}`).val(desconto.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        atualizarValorTotal();
    });

    card.find('.moedaReal').inputmask({
        alias: 'numeric',
        groupSeparator: '.',
        radixPoint: ',',
        autoGroup: true,
        digits: 2,
        digitsOptional: false,
        placeholder: '0',
        rightAlign: false,
        removeMaskOnSubmit: true // remove a máscara ao submeter o form
    });

    $('#selected').append(card);
    verificarEstoque(prod.id);
    atualizarValorTotal();
}

function atualizarSugestoes() {
    const termo = $('#search').val().toLowerCase();
    $('#suggestions').empty();

    if (termo.length === 0) return;

    const resultados = produtos.filter(p =>
        (
            p.nome.toLowerCase().includes(termo) || 
            p.subtitulo.toLowerCase().includes(termo) ||
            p.palavra_chave.toLowerCase().includes(termo) ||
            p.descricao.toLowerCase().includes(termo)
        ) && !selecionados.has(p.id)
    );

    resultados.forEach(prod => {
        const item = $(`
        <div class="row suggestion-item">
            <div class="col-3">
                <img src="${prod.imagem}" alt="${prod.nome}">
            </div>
            <div class="col-6 card-body py-3">
                <span class="mb-1">${prod.nome}</span>
                <p class="card-text mb-1"><small class="text-muted">${prod.subtitulo}</small></p>
            </div>
            <div class="col-3 text-end">
                <span class="card-text fw-bold text-success">R$${prod.total}</span>
                <p class="card-text mb-1"><small class="text-muted">${prod.estoque} uni</small></p>
            </div>
        </div>
        `);

        item.on('click', function () {
            adicionarProduto(prod);
            $('#search').val('');
            $('#suggestions').empty();
        });

        $('#suggestions').append(item);
    });
}

$(document).on('click', '#finalizar-venda', function () {
    if ($('#selected .card-product').length === 0) {
        alert('Adicione pelo menos um produto ao carrinho antes de finalizar a venda.');
        return;
    }

    $('#insertModal').modal('show');
});

$(document).on('click', '#accept-insert', function () {

    const formData = new FormData($('#new-sale-form')[0]);

    $.ajax({
        url: '/sales/insert',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false
    }).done(function (response) {
        response = JSON.parse(response);
        if (response.code == 200) {
            $('#insertModal').modal('hide');
            $('#saleInsertedModal').modal('show');
        } else {
            console.error('Erro ao criar produto:', response.message);
        }
    }).fail(function (error) {
        atualizarToast('myToast', 'Erro ao registrar venda', 'Ocorreu um erro ao tentar registrar a venda. Por favor, tente novamente.', false);
        // Update toast content for error

    });
});

function adicionarProdutosEmLote(existingProducts) {
    existingProducts.forEach(prod => {
        let productInfo = {
            "id": prod.id_produto,
            "nome": prod.nome,
            "subtitulo": prod.codigo_interno,
            "preco": prod.preco,
            "desconto": prod.desconto,
            "quantidade": prod.qtd,
            "estoque": prod.estoque,
            "imagem": prod.thumbnail,
            "total": prod.valor,
            "item": prod.id,
        };
        adicionarProduto(productInfo);
        //update the item in produtos with the same id
        const index = produtos.findIndex(p => p.id === prod.id_produto);
        if (index !== -1) {
            produtos[index].estoque = prod.estoque;
            produtos[index].item = prod.id;
        }
    });
}

$(document).ready(function () {
    $('#search').on('input', atualizarSugestoes);
});


        
