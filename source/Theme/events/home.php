<?= $this->layout("base", [
    'title' => $title, 
    'header' => $header,
    'footer' => $footer
    ]
); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/events/home.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>

<section class="avoid-navbar minimum-height container">
<section id="search-bar">
        <!-- Barra de pesquisa e filtros -->
        <form id="searchForm" method="GET" action="<?= url('events')?>" class="pt-3">
            <div class="row position-relative">
                <div class="col-12 d-flex align-items-center">
                    <div class="search-wrapper flex-grow-1 position-relative px-1">
                        <input name="s" id="searchInput" type="search" class="form-control input-kiklit-2" placeholder="Pesquisar eventos..." value="<?php if (isset($_GET['s'])) echo urldecode($_GET['s']); ?>">
                        <i class="fas fa-search link-kitlit-2 position-absolute" id="searchIcon"></i>
                    </div>
                    <i class="fas fa-sliders-h link-kitlit-2 m-3 icon-filter" id="filterIcon"></i>
                </div>
            </div>
            <div class="offcanvas-filter w-100 show " id="filterRow">
                <div class="row px-1">
                    <div class="col-md-6 col-12 py-1">
                        <div class="form-group">
                            <label for="filterRegion">Região</label>
                            <select id="filterRegion" class="form-control input-kiklit-2 my-1" name="r">
                                <option value="">Selecione uma região</option>
                                <?php foreach($estados as $estado) {?>
                                    <option <?php if($estado['uf'] == $get['r']) echo 'selected'; ?> value="<?= $estado['uf'] ?>"><?= $estado['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12  py-1">
                        <div class="form-group">
                            <label for="filterCity">Cidade</label>
                            <select id="filterCity" class="form-control input-kiklit-2 my-1" name="c">
                                <option value="<?php if (!empty($get['c'])) echo $get['c']; ?>"><?= empty($get['c']) ? 'Selecione uma cidade' : $get['c']; ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row px-1">
                    <div class="col-xl-3 col-md-4 col-sm-6 col-12 py-1">
                        <div class="form-group">
                            <label for="filterDate">Data Inicial</label>
                            <input type="date" id="filterDate" class="form-control input-kiklit-2 my-1" name="sd" value="<?= $get['sd']?>">
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 col-sm-6 col-12 py-1">
                        <div class="form-group">
                            <label for="filterDate">Data Final</label>
                            <input type="date" id="filterDate" class="form-control input-kiklit-2 my-1" name="fd" value="<?= $get['fd']?>">
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-4 col-12 d-flex justify-content-end align-items-end py-1">
                        <button type="submit" class="btn btn-kiklit-2">Pesquisar</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <hr>
    <section id="events" class="row">
        <?php 
            for ($i = 1; $i < 4; $i++) {
                foreach($events as $event) {
        ?>
        <a class="col-lg-3 col-md-4 col-sm-6 mb-4 evento" href="/events/<?= $event['id'] ?>/<?= $event['url']?>">
            <div class="card">
                <img class="card-img-top" src="<?= $event['image']?>" alt="Card image cap">
                <span class="image-overlay"><?= $event['start_date']?> - <?= $event['start_date']?></span>
                <div class="card-body">
                    <h5 class="card-title"><?= $event['title']?></h5>
                    <p class="card-text descricao-evento"><?= $event['subtitle']?></p>
                </div>
            </div>
        </a>
        <?php 
                } 
            }
        ?>
    </section>
    <section>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($currentPage <= 1) echo 'disabled'; ?>">
                    <a class="page-link link-kitlit-2" href="<?= url('events?page='.($currentPage-1).'&'.$queryString) ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Anterior</span>
                    </a>
                </li>
                <?php foreach($pages as $page) { ?>
                    <li class="page-item <?= $page['class'] ?>"><a class="page-link link-kitlit-2" href="<?= url($page['url'])?>"><?= $page['pagina']?></a></li>
                <?php } ?>
                <li class="page-item <?php if ($currentPage >= 10) echo 'disabled'; ?>">
                    <a class="page-link link-kitlit-2" href="<?= url('events?page='.($currentPage+1).'&'.$queryString) ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Próximo</span>
                    </a>
                </li>
            </ul>
        </nav>
    </section>
</section>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url('assets/js/events/home.js') ?>"></script>
<script>
    const defaultCity = '<?= empty($get['c']) ? 'Carregando...' : $get['c']; ?>';
    searchCities('<?= empty($get['r']) ? '' : $get['r']; ?>');
</script>
<?= $this->stop() ?>