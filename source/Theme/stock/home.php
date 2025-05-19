<?= $this->layout("base", [
    'title' => $title, 
    'logado' => $logado,
    'header' => true,
    'footer' => true
]); ?>

<?= $this->start("css") ?>
<!-- <link rel="stylesheet" href="<?= url("assets/css/home.css") ?>"> -->
<style>
    .menu-produto.dropdown-toggle::after {
        display: none; /* Remove a seta padrão */
    }

</style>
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
                        <input type="text" class="form-control input-kiklit-2" placeholder="Pesquisar eventos..." name="search" value="<?= $get['search'] ?? '' ?>">
                        <button class="btn btn-outline-kiklit-2" type="submit">
                            <i class="fas fa-search"></i> <!-- Ícone de lupa -->
                        </button>
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
                    <select class="form-select form-select-sm input-kiklit-2" id="sort-options">
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
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-products">
    <div class="container">
        <div class="row" id="produtos">
            <?php for ($i = 0; $i < 12; $i++): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 evento">
                <div class="card">
                    <div class="card-img-top position-relative pt-2 px-2">
                        <img src="https://placehold.in/300x200@2x.png/dark" class="img-fluid rounded" alt="Evento">
                        <span class="badge bg-white text-dark position-absolute top-0 end-0 m-3" style="border: 1px solid #ccc;">10 uni</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            <a href="/" class="link-kitlit-1 nome-produto">Produto</a>
                            <span class="badge bg-success">Ativo</span>
                        </h5> 
                        <p class="card-text">
                            <span class="badge bg-light text-dark me-1">Badge 1</span>
                            <span class="badge bg-light text-dark me-1">Badge 2</span>
                            <span class="badge bg-light text-dark me-1">Badge 3</span>
                        </p>
                        <div class="card-text">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>Preço: <span class="badge bg-light text-dark me-1">R$ 10</span></div>
                                <div>Desconto: <span class="badge bg-light text-dark me-1">R$ 5</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>
<section class="section-pagination">
    <div class="container">
        <div class="row justify-content-between align-items-center" id="pagination-controls">
            <div class="col-md-6 col-12 d-flex justify-content-md-start justify-content-center mb-2 mb-md-0">
                <p class="text-muted">Mostrando <span id="result-count">12</span> resultados de <span id="total-count">100</span></p>
            </div>
            <div class="col-md-6 col-12 d-flex justify-content-md-end justify-content-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
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
</section>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/js/stock/home.js") ?>"></script>
<script src="<?= url("assets/vendors/chart.js/Chart.min.js") ?>"></script>
<?= $this->stop() ?>