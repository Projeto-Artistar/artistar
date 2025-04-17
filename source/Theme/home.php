<?= $this->layout("base", [
    'title' => $title, 
    'logado' => $logado,
    'header' => true,
    'footer' => true
]); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/home.css") ?>">
<link rel="preload" type="text/css" href="<?= url("assets/vendors/slick-1.8.1/slick/slick.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<link rel="preload" type="text/css" href="<?= url("assets/vendors/slick-1.8.1/slick/slick-theme.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<?php if($logado) : ?>
    <section class="section-slide avoid-navbar">
    <div class="col-12">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container pt-3">
                        <div class="row">
                            <div class="bg-rockme-2 py-6 px-6 px-xl-0 rounded-4 ">
                                <div class="row align-items-center">
                                    <div class="offset-xl-1 col-xl-5 col-md-6 col-12 p-5">
                                    <div>
                                        <h2 class="h1 text-white mb-3">Vamos tornar suas vendas mais fáceis!</h2>
                                        <p class="text-white fs-4">Registre sua atividade e analise seus resultados de forma rápida e eficiente...</p>
                                        <a class="btn btn-outline-light" href="<?=url('login')?>">Começar</a>
                                    </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-12">
                                    <div class="text-center">
                                        <img src="https://codescandy.com/geeks-bootstrap-5/assets/images/education/course.png" alt="learning" class="img-fluid">
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="<?= url("assets/image/800x400.png") ?>" class="d-block w-100" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="<?= url("assets/image/800x400.png") ?>" class="d-block w-100" alt="Slide 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
<?php else: ?>

<?php endif; ?>
<section class="section-eventos">
    <div class="container">
        <div class="py-3 d-flex justify-content-between align-items-center">
            <span class="h2">Eventos</span>
            <a href="<?= url('events')?>" class="link-kitlit-2">Ver mais</a>
        </div>
        <div class="row" id="eventos"></div>
    </div>
</section>
<section class="section-parceiros section-dark p-4 avoid-navbar">
    <div class="container">
        <div class="pb-3">
            <span class="h2">Parceiros</span>
        </div>
        <div class="row bg-danger rounded-4 align-items-center p-4">
            <div class="col-lg-4 img-parceiros order-lg-1 text-center text-lg-start">
                <img class="img-parceiro" src="https://dcdn-us.mitiendanube.com/stores/002/915/628/themes/common/logo-108771010-1740163103-604f805e8e907da15fa73c01e1d92cbb1740163104.png?0" alt="Parceiro 1">
            </div>
            <div class="col-lg-8 text-white text-lg-end order-lg-2">
                <h2 class="h1">Deartcass</h2>
                <p class="lead">Conheça nossos parceiros e patrocinadores, sem eles nada disso seria possível!</p>
                <a href="https://www.deartcass.com.br" target="_blank" class="btn btn-outline-light">Acessar</a>
            </div>
        </div>
        <div class="row bg-primary rounded-4 align-items-center p-4 mt-4">
            <div class="col-lg-4 img-parceiros order-1 order-lg-2 text-center text-lg-end">
                <img class="img-parceiro" src="https://media.glassdoor.com/sqll/2493337/backsite-servi%C3%A7os-online-squarelogo-1555042110500.png" alt="Parceiro 2">
            </div>
            <div class="col-lg-8 text-white order-2 order-lg-1">
                <h2 class="h1">Backsite</h2>
                <p class="lead">Conheça nossos parceiros e patrocinadores, sem eles nada disso seria possível!</p>
                <a href="https://www.backsite.com.br" target="_blank" class="btn btn-outline-light">Acessar</a>
            </div>
        </div>
    </div>
</section>
<section class="section-artistas p-4">
    <div class="container">
        <div class="py-3 d-flex justify-content-between align-items-center">
            <span class="h2">Artistas e Lojas</span>
            <a href="<?= url('stores')?>" class="link-kitlit-2">Ver mais</a>
        </div>
        <div id="carrossel-lojas">
            <?php for($i=0; $i<=7; $i++):?>
                <div>
                    <div class="card text-center">
                        <img class="card-img-top" src="https://dcdn-us.mitiendanube.com/stores/002/915/628/themes/common/logo-108771010-1740163103-604f805e8e907da15fa73c01e1d92cbb1740163104.png?0" alt="Artista <?= $i + 1 ?>">
                        <div class="card-body">
                            <h5 class="card-title">Artista <?= $i + 1 ?></h5>
                        </div>
                    </div>
                </div>
            <?php endfor;?>
        </div>
    </div>
</section>
<?= $this->stop() ?>
<?= $this->start("js") ?>
<script src="<?= url("assets/vendors/slick-1.8.1/slick/slick.min.js") ?>" defer></script>
<script src="<?= url("assets/js/home.js") ?>"></script>
<?= $this->stop() ?>
