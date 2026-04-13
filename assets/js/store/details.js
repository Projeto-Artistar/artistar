(function () {
    var productsList = document.getElementById('storeProductsList');
    var searchInput = document.getElementById('storeSearchInput');

    if (!productsList) return;

    var storeId = parseInt(productsList.dataset.storeId || '0', 10);
    var searchTimeout = null;
    var activeRequest = null;

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function buildPlaceholderCards(total) {
        var html = '';
        for (var i = 0; i < total; i++) {
            html += '<div class="col-md-6 col-xl-2">';
            html += '  <div class="store-product-card is-placeholder h-100">';
            html += '      <div class="store-product-media" style="position:relative; overflow:hidden;">';
            html += '          <button type="button" class="store-product-favorite" aria-label="Favoritar produto" tabindex="-1" style="position:absolute; top:8px; right:8px; z-index:3;">';
            html += '              <i class="fa-regular fa-heart"></i>';
            html += '          </button>';
            html += '          <div class="store-product-image placeholder-glow" style="display:block; width:100%; aspect-ratio:1 / 1;">';
            html += '              <span class="placeholder w-100 h-100 d-block"></span>';
            html += '          </div>';
            html += '      </div>';
            html += '      <div class="store-product-info">';
            html += '          <p class="store-product-name mb-1">Carregando...</p>';
            html += '          <p class="store-product-price mb-0">R$ 0,00</p>';
            html += '      </div>';
            html += '  </div>';
            html += '</div>';
        }
        return html;
    }

    function renderProducts(products) {
        if (!Array.isArray(products) || products.length === 0) {
            productsList.innerHTML = [
                '<div class="col-12">',
                '   <div class="alert alert-light border text-center mb-0">',
                '       Nenhum produto encontrado para esta loja.',
                '   </div>',
                '</div>'
            ].join('');
            return;
        }

        var html = '';
        products.forEach(function (product) {
            var productId = parseInt(product.id || 0, 10);
            var name = escapeHtml(product.nome || 'Produto sem nome');
            var price = escapeHtml(product.price || 'R$ 0,00');
            var thumbnail = escapeHtml(product.thumbnail || '/assets/image/200x300.png');
            var productUrl = '/store/product/' + productId;

            html += '<div class="col-md-6 col-xl-2">';
            html += '  <div class="store-product-card h-100">';
            html += '      <div class="store-product-media" style="position:relative; overflow:hidden;">';
            html += '          <button type="button" class="store-product-favorite" aria-label="Favoritar ' + name + '" style="position:absolute; top:8px; right:8px; z-index:3; border-radius: 100%;">';
            html += '              <i class="fa-regular fa-heart"></i>';
            html += '          </button>';
            html += '          <a href="' + productUrl + '" class="store-product-link" style="display:block; line-height:0;">';
            html += '              <img src="' + thumbnail + '" alt="' + name + '" class="store-product-image" style="display:block; width:100%; aspect-ratio:1 / 1; object-fit:cover;">';
            html += '          </a>';
            html += '      </div>';
            html += '      <div class="store-product-info">';
            html += '          <p class="store-product-name mb-1">' + name + '</p>';
            html += '          <p class="store-product-price mb-0">' + price + '</p>';
            html += '      </div>';
            html += '  </div>';
            html += '</div>';
        });

        productsList.innerHTML = html;
    }

    function loadProducts(searchTerm) {
        if (!storeId) {
            productsList.innerHTML = [
                '<div class="col-12">',
                '   <div class="alert alert-warning text-center mb-0">',
                '       Loja inválida para carregar produtos.',
                '   </div>',
                '</div>'
            ].join('');
            return;
        }

        if (activeRequest && activeRequest.readyState !== 4) {
            activeRequest.abort();
        }

        productsList.innerHTML = buildPlaceholderCards(6);

        activeRequest = $.ajax({
            url: '/apis/store/products',
            type: 'POST',
            data: {
                storeId: storeId,
                search: searchTerm || ''
            },
            success: function (response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    productsList.innerHTML = '<div class="col-12"><div class="alert alert-danger text-center mb-0">Erro ao processar resposta da API.</div></div>';
                    return;
                }

                if (response.code !== 200 || !response.data) {
                    productsList.innerHTML = '<div class="col-12"><div class="alert alert-danger text-center mb-0">Não foi possível carregar os produtos.</div></div>';
                    return;
                }

                renderProducts(response.data.products || []);
            },
            error: function () {
                if (activeRequest && activeRequest.readyState === 0) {
                    return;
                }
                productsList.innerHTML = '<div class="col-12"><div class="alert alert-danger text-center mb-0">Falha ao buscar produtos da loja.</div></div>';
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            var value = this.value;
            searchTimeout = setTimeout(function () {
                loadProducts(value);
            }, 30);
        });
    }

    loadProducts('');
})();
