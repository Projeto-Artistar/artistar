$(document).ready(function() {
    $('#category').select2({
        tags: true,
        placeholder: "Selecione ou adicione uma nova categoria",
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return "Adicione uma nova categoria";
            }
        }
    });
    $('#keywords').select2({
        tags: true,
        placeholder: "Selecione ou adicione uma nova palavra-chave",
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return "Adicione uma nova palavra-chave";
            }
        }
    });
});

$(function() {
    const $area = $('#image-drop-area');
    const $input = $('#image');
    const $text = $('#image-drop-text');

    $area.on('click', function(e) {
        e.stopPropagation();
        $input.trigger('click');
    });

    $area.on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $area.addClass('dragover');
    });

    $area.on('dragleave dragend', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $area.removeClass('dragover');
    });

    $area.on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $area.removeClass('dragover');
        if (e.originalEvent.dataTransfer.files.length) {
            $input[0].files = e.originalEvent.dataTransfer.files;
            showPreview($input[0].files[0]);
        }
    });

    $input.on('change', function() {
        if (this.files && this.files[0]) {
            showPreview(this.files[0]);
        }
    });

    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $area.find('img').remove();
            $area.append('<img src="' + e.target.result + '" alt="Preview">');
            $text.hide();
        };
        reader.readAsDataURL(file);
    }

     $('.moedaReal').inputmask({
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

    // $(".moedaReal").inputmask('000.000.000.000.000,00', {reverse: true});

    function calcularLucro() {
        let preco = $('#price').val();
        let desconto = $('#discount').val();
        let custo = $('#cost').val();

        // Remove apenas pontos de milhares e troca vírgula por ponto
        preco = preco ? parseFloat(preco.replace(/\./g, '').replace(',', '.')) : 0;
        desconto = desconto ? parseFloat(desconto.replace(/\./g, '').replace(',', '.')) : 0;
        custo = custo ? parseFloat(custo.replace(/\./g, '').replace(',', '.')) : 0;

        let lucro = preco - (custo + desconto);
        let precoAtual = preco - desconto;
        let descontoPercentual = (desconto * 100) / preco;

        let lucroFormatado = lucro.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        let precoAtualFormatado = precoAtual.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        let descontoPercentualFormatado = descontoPercentual.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});

        $('#real_price').val(precoAtualFormatado);
        $('#discount_percentage').val(descontoPercentualFormatado);
        $('#margin').val(lucroFormatado);
    }

    $('#price, #discount, #cost').on('input keyup change', calcularLucro);

    function calculaCaracteres(input, help, count) {
        $(count).text($(input).val().length);
        if ($(input).val().length > 50) {
            $(input).addClass('is-invalid');
            $(help).addClass('text-danger');
        } else {
            $(input).removeClass('is-invalid');
            $(help).removeClass('text-danger');
        }
    }

    $('#name').on('input keyup change', function() {
        calculaCaracteres(this, '#nameHelp', '#nameCount');
    });

    calculaCaracteres($('#name'), '#nameHelp', '#nameCount');
});

$(document).on('click', '#create-product-btn', function() {

    var form = $('#form-new-product')[0];
    var formData = new FormData(form);

    //Verifica se o campo de nome e preço estão preenchidos
    if (!formData.get('name')) {
        alert('Por favor, preencha os campo de nome');
        return;
    }

    $.ajax({
        url: '/stock/newProduct',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false
    }).done(function (response) {
        response = JSON.parse(response);
        if (response.code == 200) {
            location.href = $('#form-new-product').attr('action'); // Redireciona para a ação do formulário
        } else {
            console.error('Erro ao criar produto:', response.message);
        }
    }).fail(function (error) {
        console.error('An error occurred:', error);
    });
});
    