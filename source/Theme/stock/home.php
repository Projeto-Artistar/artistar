<?= $this->layout("base", $layout); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/stock/home.css") ?>">
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="section-banner avoid-navbar p-5">
    <div class="container">
        <div class="row">
            <div class="bg-klikit-5 rounded-4 p-5">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-12">
                        <h2 class="h1 mb-3">Inventário</h2>
                        <p class="fs-4">Últimas informações de estoque</p>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="dot bg-success me-2 rounded-5" style="height:10px; width:10px;"></span> Estoque bom
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="dot bg-warning me-2 rounded-5" style="height:10px; width:10px;"></span> Estoque baixo
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="dot bg-danger me-2 rounded-5" style="height:10px; width:10px;"></span> Sem estoque
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="dot bg-secondary me-2 rounded-5" style="height:10px; width:10px;"></span> Estoque morto
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-6 col-12 text-center">
                        <canvas id="myChart" class="w-100 h-100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</section>
<section class="section-filter">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <form id="search-form" class="d-flex align-items-center mb-4">
                    <!-- Input de pesquisa com ícone de lupa -->
                    <div class="input-group me-3">
                        <input type="search" class="form-control input-kiklit-2" placeholder="Pesquisar produtos..." name="search" value="<?= $get['search'] ?? '' ?>">
                        <!-- <button class="btn btn-outline-kiklit-2" type="submit">
                            <i class="fas fa-search"></i> 
                        </button> -->
                    </div>
                    <a class="btn btn-outline-kiklit-2 btn-md" id="filter-button" data-bs-toggle="modal" data-bs-target="#filterModal">
                        Filtros
                    </a>
                </form>
            </div>
        </div>
        <div class="row" id="filters">
            <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <span class="badge bg-light text-dark me-1">X Badge 1</span>
                    <span class="badge bg-light text-dark me-1">X Badge 1</span>
                    <span class="badge bg-light text-dark me-1">X Badge 1</span>
                </div>
                <div class="d-flex align-items-center">
                    <select class="form-select form-select-sm input-kiklit-2 me-2" id="sort-options">
                        <option value="name_asc">Nome (A-Z)</option>
                        <option value="name_desc">Nome (Z-A)</option>
                        <option value="price_asc">Preço (Menor para Maior)</option>
                        <option value="price_desc">Preço (Maior para Menor)</option>
                        <option value="discount_asc">Desconto (Menor para Maior)</option>
                        <option value="discount_desc">Desconto (Maior para Menor)</option>
                        <option value="date_asc">Data (Mais Antigo)</option>
                        <option value="date_desc">Data (Mais Recente)</option>
                        <option value="stock_asc">Estoque (Menor para Maior)</option>
                        <option value="stock_desc">Estoque (Maior para Menor)</option>
                        <option value="status_asc">Status (Ativo para Inativo)</option>
                        <option value="status_desc">Status (Inativo para Ativo)</option>
                    </select>
                    <a class="btn btn-outline-kiklit-2 btn-md" id="newProduct" data-bs-toggle="modal" data-bs-target="#newModal">
                        Novo
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-products">
    <div class="container">
        <div class="row align-items-stretch" id="produtos">
            <?php foreach($products as $product): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 evento">
    <div class="card h-100 d-flex flex-column">
        <div class="card-img-top position-relative pt-2 px-2">
            <img src="<?= empty($product['thumbnail']) ? url('assets/image/200x300.png') : $product['thumbnail'] ?>" class="img-fluid rounded thumbnail-product" alt="Evento">
            <?php if ($product['estoque'] <= 0): ?>
            <span class="badge bg-danger position-absolute top-0 end-0 m-3">Sem Estoque</span>
            <?php elseif ($product['estoque'] < $product['estoque_minimo']): ?>
            <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3"><?= $product['estoque'] ?> uni</span>
            <?php else: ?>
            <span class="badge bg-white text-dark position-absolute top-0 end-0 m-3"><?= $product['estoque'] ?> uni</span>
            <?php endif; ?>
        </div>
        <div class="card-body d-flex flex-column">
            <h5 class="card-title d-flex justify-content-between align-items-center">
                <a href="/" class="link-kitlit-1 nome-produto"><?= $product['nome'] ?></a>
                <?= $product['ativo'] ? '<span class="badge bg-success">Ativo</span>' : '<span class="badge bg-secondary">Inativo</span>' ?>
            </h5> 
            <p class="card-text mt-auto">
                <?php
                    $productKeywords = explode('|', $product['palavras_chave']);
                    foreach ($productKeywords as $keyword) {
                        echo '<span class="badge bg-light text-dark me-1">' . htmlspecialchars($keyword) . '</span>';
                    }
                ?>
            </p>
            <div class="card-text">
                <div class="d-flex justify-content-between align-items-center">
                    <div>Preço Base:<br>
                        <?php if ($product['valor_desconto'] > 0): ?>
                            <span class="badge bg-light text-dark me-1 text-decoration-line-through">R$ <?= number_format($product['valor'], 2, ',', '.') ?></span>
                        <?php else: ?>
                            <span class="badge bg-light text-dark me-1">R$ <?= number_format($product['valor'], 2, ',', '.') ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        Preço Atual: <br>
                        <div class="text-end">
                            <span class="badge bg-light text-dark me-1">R$ <?= number_format($product['valor']-$product['valor_desconto'], 2, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="section-pagination">
    <div class="container">
        <div class="row justify-content-between align-items-center" id="pagination-controls">
            <div class="col-md-6 col-12 d-flex justify-content-md-start justify-content-center mb-2 mb-md-0">
                <p class="text-muted">Mostrando <span id="result-count"><?= count($products)?></span> resultados de <span id="total-count"><?= $stocks['totalProducts'] ?></span></p>
            </div>
            <div class="col-md-6 col-12 d-flex justify-content-md-end justify-content-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php if ($pages['current'] > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagination[offset]=<?= ($pages['current'] - 2) * $pagination['limit'] ?>&search=<?= $get['search'] ?? '' ?>">Anterior</a>
                        </li>
                        <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link">Anterior</span>
                        </li>
                        <?php endif; ?>
                        <!-- Max of 4 pages before and 4 after -->
                        <?php
                        $start = max(1, $pages['current'] - 4);
                        $end = min($pages['total'], $pages['current'] + 4);
                        for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?= $i == $pages['current'] ? 'active' : 'd-none d-md-flex' ?>" >
                                <a class="page-link" href="?pagination[offset]=<?= ($i - 1) * $pagination['limit'] ?>&search=<?= $get['search'] ?? '' ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($pages['current'] < $pages['total']): ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagination[offset]=<?= $pages['current'] * $pagination['limit'] ?>&search=<?= $get['search'] ?? '' ?>">Próxima</a>
                        </li>
                        <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link">Próxima</span>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="modal-form">
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Opções de Filtros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filter-form">
                    <div class="mb-3">
                        <label for="filter-category" class="form-label">Categoria</label>
                        <select class="form-select" id="filter-category" name="category">
                            <option value="">Selecione</option>
                            <option value="categoria1">Categoria 1</option>
                            <option value="categoria2">Categoria 2</option>
                            <option value="categoria3">Categoria 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="filter-price" class="form-label">Preço</label>
                        <input type="number" class="form-control" id="filter-price" name="price" placeholder="Digite o preço máximo">
                    </div>
                    <div class="mb-3">
                        <label for="filter-status" class="form-label">Status</label>
                        <select class="form-select" id="filter-status" name="status">
                            <option value="">Selecione</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" form="filter-form">Aplicar Filtros</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Novo Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-new-product" method="post" action="<?= url("stock") ?>">

                    
                    <div class="form-check form-switch form-switch-sm">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="active" checked>
                        <label class="form-check-label" for="flexSwitchCheckDefault" value="1">Produto Ativo</label>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Imagem do Produto</label>
                        <div id="image-drop-area" class="image-drop-area d-flex align-items-center justify-content-center">
                            <span id="image-drop-text">Clique ou arraste uma imagem aqui</span>
                        </div>
                    </div>
                    <input type="file" id="new-image" name="thumbnail" accept="image/*" style="display:none;">

                    
                    <div class="mb-3">
                        <label for="filter-name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="filter-name" name="name" placeholder="Digite o nome do produto">
                    </div>

                    <div class="mb-3">
                        <label for="filter-insideId" class="form-label">Identificação Interna</label>
                        <input type="text" class="form-control" id="filter-insideId" name="insideId" placeholder="Digite a identificação interna">
                    </div>

                    <div class="mb-3">
                        <label for="new-category" class="form-label">Categorias</label>
                        <select class="form-select select2" id="new-category" name="category[]" multiple="multiple">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>"><?= $category['nome'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="new-keywords" class="form-label">Palavras-Chave</label>
                        <select class="form-select select2" id="new-keywords" name="keywords[]" multiple="multiple">
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="filter-name" class="form-label">Descrição</label>
                        <textarea class="form-control" id="filter-description" name="description" rows="3" placeholder="Digite a descrição do produto"></textarea>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="new-price" class="form-label">Preço</label>
                            <input type="text" class="form-control moedaReal" id="new-price" name="price" value="0,00">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="new-cost" class="form-label">Custo</label>
                            <input type="text" class="form-control moedaReal" id="new-cost" name="cost" value="0,00">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="new-discount" class="form-label">Desconto</label>
                            <input type="text" class="form-control moedaReal" id="new-discount" name="discount" value="0,00">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="new-profit" class="form-label">Lucro</label>
                            <input type="text" disabled class="form-control" id="new-profit" name="profit" value="0,00">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="new-stock" class="form-label">Estoque</label>
                            <input type="number" class="form-control" id="new-stock" name="stock" value="0" min="0">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="new-min-stock" class="form-label">Estoque mín.</label>
                            <input type="number" class="form-control" id="new-min-stock" name="min_stock" value="0" min="0">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" id="create-product-btn" form="new-product-form">Inserir</button>
            </div>
        </div>
    </div>
</div>
</section>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/vendors/chart.js/Chart.min.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
<script>
    const goodStock = <?= $stocks['goodStock']?>;
    const lowStock = <?= $stocks['lowStock']?>;
    const outOfStock = <?= $stocks['outOfStock']?>;
    const deadStock = <?= $stocks['deadStock']?>;
</script>
<script src="<?= url("assets/js/stock/home.js") ?>"></script>

<?= $this->stop() ?>