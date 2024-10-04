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

<section id="search-bar" class="avoid-navbar minimum-height container">
    <section id="search-bar" class="py-3">
        <!-- Barra de pesquisa e filtros -->
        <form id="searchForm" method="GET" action="<?= url('events')?>">
            <div class="row">
                <div class="col-12 col-md-10">
                    <input id="searchInput" type="text" class="form-control input-kiklit-2" placeholder="Pesquisar eventos..." value="<?php if (isset($_GET['s'])) echo urldecode($_GET['s']); ?>">
                </div>
                <div class="col-12 col-md-2">  
                    <button class="btn btn-kiklit-2 w-100">Pesquisar</button>
                </div>
            </div>
        </form>
    </section>
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
                    <span class="sr-only">Previous</span>
                </a>
                </li>
                <li class="page-item active"><a class="page-link link-kitlit-2" href="#">1</a></li>
                <li class="page-item"><a class="page-link link-kitlit-2" href="#">2</a></li>
                <li class="page-item"><a class="page-link link-kitlit-2" href="#">3</a></li>
                <li class="page-item disabled"><a class="page-link link-kitlit-2" href="#">...</a></li>
                <li class="page-item"><a class="page-link link-kitlit-2" href="#">10</a></li>
                <li class="page-item">
                <a class="page-link link-kitlit-2" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
                </li>
            </ul>
        </nav>
    </section>
</section>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir o envio padrão do formulário
        var searchInput = document.getElementById('searchInput');
        var encodedValue = encodeURIComponent(searchInput.value);

        // Criar um campo oculto com o valor codificado
        var hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 's';
        hiddenInput.value = encodedValue;

        // Adicionar o campo oculto ao formulário e enviar
        this.appendChild(hiddenInput);
        this.submit();
    });
</script>
<?= $this->stop() ?>