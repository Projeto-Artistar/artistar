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
</section>
<section class="container mt-3">
    <div class="row align-items-center">
        <div class="col-md-6" id="eventTitle" style="display:none">
        </div>
        <div class="col-md-6 d-md-flex d-block justify-content-end" id="column-buttons" style="display: none !important;">
        </div>
    </div>
    <div class="row my-2">
        <div class="col-md-6">
            <span class="color-klikit-2" id="eventAddress"></span>
        </div>
        <div class="col-md-6 d-md-flex d-block justify-content-end" id="column-productor" style="display :none !important;">
            <span>Produtor: <a class="link-kitlit-1" href="#" id="eventProductor"></a></span>
        </div>
    </div>
    <!-- <div class="row my-2">
        <div class="col-md-12" id="eventSubtitle">
        </div>
    </div> -->
    <div class="row mt-3" id="row-dpi" style="display:none;">
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
    </div>
    <div class="row">
        <div class="col-md-6" style="display: none;" id="contactsColumn">
            <h4 class="my-3">Contatos</h4>
            <ul class="list-unstyled" id="contactsList"></ul>
        </div>
        <div class="col-md-6" style="display: none;"id="socialMediaColumn">
            <h4 class="my-3">Redes Sociais</h4>
            <ul class="list-unstyled" id="socialMediaList"></ul>
        </div>
    </div>
</section>
<section class="bg-klikit-5 py-3">
    <div class="container">
        <div class="row mb-3" id="row-map" style="display: none;">
            <h4 class="mb-3">Local</h4>
            <div id="mapa"></div>
        </div>
    </div>
</section>

<?= $this->stop() ?>

<?= $this->start("js") ?>
<script>const eventId = <?= $evento['id'] ?>;</script>
<script src="<?= url("assets/js/events/details.js") ?>"></script>
<?= $this->stop() ?>