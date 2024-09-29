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
    <div id="photosCarousel" class="col-12 carousel slide" data-bs-ride="carousel" style="display:none;">
        <div class="carousel-indicators" id="photo-carousel-indicators"></div>
        <div class="carousel-inner" id="carousel-items"></div>
        <button id="slide-btn-previous" class="carousel-control-prev" type="button" data-bs-target="#photosCarousel" data-bs-slide="prev" style="display: none;">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button id="slide-btn-next" class="carousel-control-next" type="button" data-bs-target="#photosCarousel" data-bs-slide="next" style="display: none;">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
    <div id="carouselSkeleton" class="carousel-skeleton">
        <div class="skeleton-item"></div>
    </div>
</section>
<section class="container mt-3">
    <div class="row align-items-center">
        <div class="col-md-6" id="eventTitle-skeleton">
            <div class="skeleton-title"></div>
        </div>
        <div class="col-md-6 justify-content-end" id="column-buttons-skeleton">
            <div class="skeleton-button"></div>
            <div class="skeleton-button"></div>
        </div>
        <div class="col-md-6" id="eventTitle" style="display:none"></div>
        <div class="col-md-6 d-md-flex d-block justify-content-end" id="column-buttons" style="display: none !important;"></div>
    </div>
    <div class="row my-2">
        <div class="col-md-6" id="eventAddress-skeleton">
            <div class="skeleton-text"></div>
        </div>
        <div class="col-md-6 justify-content-end" id="column-productor-skeleton">
            <div class="skeleton-text"></div>
        </div>
        <div class="col-md-6" id="eventAddress" style="display:none">
        </div>
        <div class="col-md-6 d-md-flex d-block justify-content-end" id="column-productor" style="display :none !important;">
            <span>Produtor: <a class="link-kitlit-1" href="#" id="eventProductor"></a></span>
        </div>
    </div>
    <!-- <div class="row my-2">
        <div class="col-md-12" id="eventSubtitle">
        </div>
    </div> -->
    <div class="row mt-3" id="row-dpi" >
        <div class="col-md-6" id="column-description-skeleton">
            <div class="skeleton-title"></div>
            <div class="skeleton-text"></div>
            <div class="skeleton-text"></div>
            <div class="skeleton-text"></div>
        </div>
        <div class="col-md-6" id="column-description" style="display:none;">
            <h4>Descrição</h4>
            <section id="eventDescription"></section>
        </div>
        <div class="col-md-6" id="column-pi" style="display:none;">
            <div class="row" id="daysRow" style="display:none;">
                <h4 class="mb-3">Dias</h4>
            </div>
            <div class="row" id="pricesRow" style="display:none;">
                <h4 class="my-3">Inscrições</h4>
            </div>
        </div>
        <div class="col-md-6" id="column-pi-skeleton">
            <div class="row">
                <div class="col-xxl-4 col-md-6 col-sm-4 col-6 mb-3 mr-3"><div class="card skeleton-card"></div></div>
                <div class="col-xxl-4 col-md-6 col-sm-4 col-6 mb-3"><div class="card skeleton-card"></div></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" id="contactsColumn-skeleton">
            <div class="skeleton-title w-25"></div>
            <ul class="list-unstyled">
                <li class="skeleton-text"></li>
                <li class="skeleton-text"></li>
                <li class="skeleton-text"></li>
            </ul>
        </div>
        <div class="col-md-6" id="contactsColumn" style="display: none;">
            <h4 class="my-3">Contatos</h4>
            <ul class="list-unstyled" id="contactsList"></ul>
        </div>
        <div class="col-md-6" id="socialMediaColumn-skeleton">
            <div class="skeleton-title w-25"></div>
            <ul class="list-unstyled">
                <li class="skeleton-text"></li>
                <li class="skeleton-text"></li>
                <li class="skeleton-text"></li>
            </ul>
        </div>
        <div class="col-md-6" style="display: none;"id="socialMediaColumn">
            <h4 class="my-3">Redes Sociais</h4>
            <ul class="list-unstyled" id="socialMediaList"></ul>
        </div>
    </div>
</section>
<section id="section-map" class="bg-klikit-5 py-3" style="display: none;">
    <div class="container">
        <div class="row mb-3" id="row-map">
            <h4 class="mb-3">Local</h4>
            <div id="mapa"></div>
        </div>
    </div>
</section>
<section id="slide-item-modal"></section>

<?= $this->stop() ?>

<?= $this->start("js") ?>
<script>const eventId = <?= $evento['id'] ?>;</script>
<script src="<?= url("assets/js/events/details.js") ?>"></script>
<?= $this->stop() ?>