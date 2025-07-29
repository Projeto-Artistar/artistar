const selecionados = new Set(); // <- Aqui guardamos os IDs dos produtos selecionados

$(document).ready(function () {
    $('#search').on('input', function () {
    const termo = $(this).val().toLowerCase();
    $('#suggestions').empty();

    if (termo.length === 0) return;

    const resultados = produtos.filter(p =>
        p.nome.toLowerCase().includes(termo) && !selecionados.has(p.id)
    );

    resultados.forEach(prod => {
        const item = $(`
        <div class="suggestion-item">
            <img src="${prod.imagem}" alt="${prod.nome}">
            <div>
            <strong>${prod.nome}</strong><br>
            <small>${prod.subtitulo} - ${prod.preco}</small>
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
    });

    function adicionarProduto(prod) {
    if (selecionados.has(prod.id)) return;

    selecionados.add(prod.id); // Adiciona o ID à lista de selecionados

    const card = $(`
        <div class="product-card" data-id="${prod.id}">
        <img src="${prod.imagem}" alt="${prod.nome}">
        <div class="product-info">
            <h4>${prod.nome}</h4>
            <p>${prod.subtitulo}</p>
            <p><strong>${prod.preco}</strong></p>
        </div>
        <button class="remove-btn" title="Remover">❌</button>
        </div>
    `);

    card.find('.remove-btn').on('click', function () {
        selecionados.delete(prod.id);
        card.remove();
        atualizarSugestoes(); // Reexibe na lista se fizer sentido
    });

    $('#selected').append(card);
    }
});