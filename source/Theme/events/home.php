<?= $this->layout("base", [
    'title' => $title, 
    'header' => $header,
    'footer' => $footer
    ]
); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/events/home.css") ?>">
<style>
    .search-wrapper {
        position: relative;
    }
    .search-wrapper input {
        padding-right: 2.5rem; /* Espaço para o ícone */
    }
    .search-wrapper .fa-search {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        cursor: pointer;
    }

    .icon-filter {
        cursor: pointer;
    }
    .offcanvas-filter {
        transition: max-height .4s ease-in-out;
        overflow: hidden;
        max-height: 0;
    }
    .offcanvas-filter.show {
        max-height: 500px; /* Ajuste conforme necessário */
    }
</style>
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>

<section id="search-bar" class="avoid-navbar minimum-height container">
<section id="search-bar">
        <!-- Barra de pesquisa e filtros -->
        <form id="searchForm" method="GET" action="<?= url('events')?>" class="pt-3">
            <div class="row position-relative">
                <div class="col-12 d-flex align-items-center">
                    <div class="search-wrapper flex-grow-1 position-relative px-1">
                        <input id="searchInput" type="text" class="form-control input-kiklit-2" placeholder="Pesquisar eventos..." value="<?php if (isset($_GET['s'])) echo urldecode($_GET['s']); ?>">
                        <i class="fas fa-search link-kitlit-2 position-absolute" id="searchIcon"></i>
                    </div>
                    <i class="fas fa-sliders-h link-kitlit-2 m-3 icon-filter" id="filterIcon"></i>
                </div>
            </div>
            <div class="offcanvas-filter w-100 show " id="filterRow">
                <div class="row px-1">
                    <div class="col-xl-3 col-md-4 col-sm-6 col-12 py-1">
                        <div class="form-group">
                            <label for="filterRegion">Região</label>
                            <select id="filterRegion" class="form-control input-kiklit-2" name="r">
                                <option value="">Selecione uma região</option>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 col-sm-6 col-12 py-1">
                        <div class="form-group">
                            <label for="filterDate">Data Inicial</label>
                            <input type="date" id="filterDate" class="form-control input-kiklit-2" name="sd">
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 col-sm-6 col-12 py-1">
                        <div class="form-group">
                            <label for="filterDate">Data Final</label>
                            <input type="date" id="filterDate" class="form-control input-kiklit-2" name="fd">
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 col-sm-6 col-12 d-flex justify-content-end align-items-end py-1">
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
                <li class="page-item disabled">
                    <a class="page-link link-kitlit-2" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Anterior</span>
                    </a>
                </li>
                <li class="page-item active"><a class="page-link link-kitlit-2" href="<?= url('events?' . $queryString)?>">1</a></li>
                <li class="page-item"><a class="page-link link-kitlit-2" href="<?= url('events?' . $queryString . '&page=2')?>">2</a></li>
                <li class="page-item"><a class="page-link link-kitlit-2" href="<?= url('events?' . $queryString . '&page=3')?>">3</a></li>
                <li class="page-item disabled"><a class="page-link link-kitlit-2" href="#">...</a></li>
                <li class="page-item"><a class="page-link link-kitlit-2" href="<?= url('events?' . $queryString . '&page=10')?>">10</a></li>
                <li class="page-item">
                    <a class="page-link link-kitlit-2" href="#" aria-label="Next">
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
<script>
    function search() {
        event.preventDefault(); // Prevenir o envio padrão do formulário
        var searchInput = document.getElementById('searchInput');
        var encodedValue = encodeURIComponent(searchInput.value);

        // Criar um campo oculto com o valor codificado
        var hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 's';
        hiddenInput.value = encodedValue;

        var form = document.getElementById('searchForm');
        form.appendChild(hiddenInput);
        form.submit();
    }

    document.getElementById('searchIcon').addEventListener('click', function() {
        search();
    });
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        search();
    });
    document.getElementById('filterIcon').addEventListener('click', function() {
        var filterRow = document.getElementById('filterRow');
        filterRow.classList.toggle('show');
    });
</script>
<?= $this->stop() ?>