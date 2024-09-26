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
<section class="container minimum-height">
 
    <section id="photo-slide">
        <div class="row" id="eventos"></div>
    </section>
</section>

<?= $this->stop() ?>

<?= $this->start("js") ?>
<script>
    const eventId = <?= $evento['id'] ?>;
</script>
<script src="<?= url("assets/js/events/details.js") ?>"></script>
<?= $this->stop() ?>