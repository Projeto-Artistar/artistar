<?= $this->layout("base", [
    'title' => $title, 
    'header' => $header,
    'footer' => $footer
    ]
); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/events/details.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="section-slide avoid-navbar">
    <div class="col-12">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <!-- <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button> -->
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?= url("assets/image/800x400.png") ?>" class="d-block w-100" alt="Slide 1">
                </div>
                <!-- <div class="carousel-item">
                    <img src="<?= url("assets/image/800x400.png") ?>" class="d-block w-100" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="<?= url("assets/image/800x400.png") ?>" class="d-block w-100" alt="Slide 3">
                </div> -->
            </div>
            <button id="slide-btn-previous" class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev" style="display: none;">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button id="slide-btn-next" class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next" style="display: none;">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
<section class="container mt-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1><?= $evento['title'] ?></h1>
        </div>
        <div class="col-md-6 d-md-flex d-block justify-content-end">
            <div>
                <button class="btn btn-kiklit-2"><i class="fas fa-heart"></i></button>
                <button class="btn btn-kiklit-4"><i class="fas fa-share"></i></button>
            </div>
        </div>
    </div>
    <div class="row my-2">
        <div class="col-md-6">
            <span class="color-klikit-2" id="endereco">R. Evaristo da Veiga, 79 - Campo Grande, Santos - SP, 11075-660</span>
        </div>
        <div class="col-md-6 d-md-flex d-block justify-content-end">
            <span>Produtor: <a class="link-kitlit-1" href="#">Parker Produções</a></span>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <h4>Descrição</h4>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam in consequat ipsum. Donec sem elit, ullamcorper quis tempor a, porta ultricies mi. Morbi tempus ligula at ipsum pellentesque bibendum sit amet vel ex. Sed efficitur, neque eu pretium lacinia, est magna feugiat nisi, at pulvinar erat lacus id ante. Sed ut enim convallis, tincidunt libero quis, varius leo. Cras auctor accumsan lacus. Vestibulum tincidunt cursus nisl congue placerat. In hac habitasse platea dictumst. Sed bibendum dolor vitae massa sodales, sollicitudin porta lectus molestie. Praesent tincidunt, nisl sed porttitor volutpat, dolor turpis blandit eros, eget facilisis urna leo quis velit. Proin ac justo vel enim pellentesque iaculis eu nec nunc. Integer sit amet odio velit. Sed eget tempor ex. Morbi consequat lectus vel ornare sagittis. Fusce laoreet vel metus ut feugiat. Donec dapibus egestas sem, a tempus nisi.
            <br>
            <br>
            Ut vel mattis augue. Nullam sollicitudin, mi a mattis pellentesque, sem erat porta est, a tempus dui sem nec mauris. Donec dapibus gravida semper. Vestibulum lectus sem, semper sed enim et, aliquam suscipit est. Cras nibh risus, ullamcorper ut tortor ac, porta tristique erat. Morbi lacus risus, semper a egestas et, pellentesque quis justo. Fusce imperdiet nibh ut justo euismod maximus. Integer mollis vel velit sed bibendum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi facilisis nisl ut leo porta, quis gravida erat vehicula.
        </div>
        <div class="col-md-6">
            <div class="row" id="days">
                <h4 class="mb-3">Dias</h4>
                <div class="col-4">
                    <div class="card min-vw-25">
                        <div class="card-body">
                            <h5 class="card-title">14/12/2024</h5>
                            <h6 class="card-subtitle mb-2 text-muted">12:00 - 19:00</h6>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">15/12/2024</h5>
                            <h6 class="card-subtitle mb-2 text-muted">12:00 - 19:00</h6>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">16/12/2024</h5>
                            <h6 class="card-subtitle mb-2 text-muted">12:00 - 19:00</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <h4 class="my-3">Inscrições</h4>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Artist Alley</h5>
                            <h6 class="card-subtitle mb-2 text-muted">R$180</h6>
                            <span class="card-subtitle mb-2 text-muted">Até 20/11</span>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Loja</h5>
                            <h6 class="card-subtitle mb-2 text-muted">R$1800</h6>
                            <span class="card-subtitle mb-2 text-muted">Até 20/11</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h4 class="my-3">Contatos</h4>
            <ul class="list-unstyled">
                <li><i class="fas fa-phone-alt"></i> <span class="color-klikit-2">(11) 1234-5678</span></li>
                <li><i class="fas fa-envelope"></i> <span class="color-klikit-2">contato@evento.com</span></li>
                <li><i class="fas fa-map-marker-alt"></i> <span class="color-klikit-2">Rua Exemplo, 123, São Paulo, SP</span></li>
            </ul>
        </div>
        <div class="col-md-6">
            <h4 class="my-3">Redes Sociais</h4>
            <ul class="list-unstyled">
                <li class="d-flex align-items-center mb-2">
                    <i class="fab fa-facebook-f me-2"></i> <a class="link-kitlit-1" href="https://facebook.com" target="_blank">Facebook</a>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <i class="fab fa-instagram me-2"></i> <a class="link-kitlit-1" href="https://instagram.com" target="_blank">Instagram</a>
                </li>
                <li class="d-flex align-items-center mb-2">
                    <i class="fab fa-plus me-2"></i> <a class="link-kitlit-1" href="https://www.sympla.com.br/evento/anime-santos-geek-fest-x-mas-edition/2500268" target="_blank">Sympla</a>
                </li>

            </ul>
        </div>
    </div>
    <div class="row mb-3">
        <h4 class="my-3">Local</h4>
        <div id="mapa"></div>
    </div>
</section>

<div id="mapa"></div>

<?= $this->stop() ?>

<?= $this->start("js") ?>
<script>
    const eventId = <?= $evento['id'] ?>;
    function gerarMapa() {
        // Pegar o valor do endereço do input
        var endereco = "R. Evaristo da Veiga, 79 - Campo Grande, Santos - SP, 11075-660";
        
        // Criar a URL do Google Maps com o endereço
        var url = "https://www.google.com/maps?q=" + encodeURIComponent(endereco) + "&output=embed";
        
        // Gerar o código do iframe
        var iframe = "<iframe frameborder='0' style='border:0; width: 100%; min-height: 500px;' src='" + url + "' allowfullscreen></iframe>";
        
        // Inserir o iframe na div
        document.getElementById('mapa').innerHTML = iframe;
    }
    gerarMapa()
</script>
<script src="<?= url("assets/js/events/details.js") ?>"></script>
<?= $this->stop() ?>