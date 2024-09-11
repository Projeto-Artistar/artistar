
<?= $this->layout("base", [
    'title' => $title, 
    'header' => $header,
    'footer' => $footer
    ]
); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/home.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<?= $banner ?>
<section class="section-eventos">
    <div class="container">
        <div class="py-3 d-flex justify-content-between align-items-center">
            <span class="h2">Eventos</span>
            <a href="#" class="link-kitlit-2">Ver mais eventos</a>
        </div>
        <div class="row" id="eventos"></div>
    </div>
</section>
<section class="section-parceiros bg-klikit-2 py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-white">
                <h2 class="h1">Parceiros</h2>
                <p class="lead">Conheça nossos parceiros e patrocinadores, sem eles nada disso seria possível!</p>
                <a href="#" class="btn btn-outline-light">Ver mais</a>
            </div>
            <div class="col-md-6 img-parceiros">
                <div class="row">
                    <div class="col-sm-6 mb-4 img-parceiro-container">
                        <img class="img-parceiro" src="https://yt3.googleusercontent.com/QhYUIKQAjc1oEGnJnMaJ1mUBp_JhOIU_MSFF3cvakkM2uhiese0DVZEZAwoggDkebJOGi4g0Pw=s900-c-k-c0x00ffffff-no-rj" alt="Parceiro 1">
                    </div>
                    <div class="col-sm-6 mb-4 img-parceiro-container">
                        <img class="img-parceiro" src="https://media.glassdoor.com/sqll/2493337/backsite-servi%C3%A7os-online-squarelogo-1555042110500.png" alt="Parceiro 3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/js/home.js") ?>"></script>
<?= $this->stop() ?>
