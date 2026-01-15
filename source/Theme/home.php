<?= $this->layout("base", [
    'title' => $title, 
    'logado' => $logado,
    'header' => true,
    'footer' => true
]); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/vendors/slick-1.8.1/slick/slick.css") ?>">
<link rel="stylesheet" href="<?= url("assets/vendors/slick-1.8.1/slick/slick-theme.css") ?>">
<link rel="stylesheet" href="<?= url("assets/css/home.css") ?>">
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
<section class="section-beneficios avoid-navbar">
    <div class="container">
        <div class="row py-5">
            <div class="col-md-6">
                <h2 class="h1">Melhore suas vendas com Artistar!</h2>
                <p class="lead mt-3">Descubra como nossa plataforma pode ajudar você a gerenciar suas vendas, organizar seus produtos e alcançar mais clientes de forma eficiente.</p>
                <a href="<?= url('register') ?>" class="btn btn-kiklit-2 btn-lg mt-4">Comece Agora</a>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://codescandy.com/geeks-bootstrap-5/assets/images/education/course.png" alt="learning" class="img-fluid">
            </div>
        </div>
        <div class="row text-center mt-5 py-5">
            <div class="col-md-4 mb-4">
                <img style="width: 200px;" src="https://dcdn-us.mitiendanube.com/stores/002/915/628/themes/common/logo-108771010-1740163103-604f805e8e907da15fa73c01e1d92cbb1740163104.png?0" alt="Benefício 1" class="img-fluid mb-3">
                <h5 class="fw-bold">Fácil de Usar</h5>
                <p class="text-muted">Nossa plataforma é intuitiva e simples de navegar.</p>
            </div>
            <div class="col-md-4 mb-4">
                <img style="width: 200px;" src="https://dcdn-us.mitiendanube.com/stores/002/915/628/themes/common/logo-108771010-1740163103-604f805e8e907da15fa73c01e1d92cbb1740163104.png?0" alt="Benefício 2" class="img-fluid mb-3">
                <h5 class="fw-bold">Resultados Rápidos</h5>
                <p class="text-muted">Obtenha insights e resultados em tempo real.</p>
            </div>
            <div class="col-md-4 mb-4">
                <img style="width: 200px;" src="https://dcdn-us.mitiendanube.com/stores/002/915/628/themes/common/logo-108771010-1740163103-604f805e8e907da15fa73c01e1d92cbb1740163104.png?0" alt="Benefício 3" class="img-fluid mb-3">
                <h5 class="fw-bold">Suporte 24/7</h5>
                <p class="text-muted">Estamos sempre disponíveis para ajudar você.</p>
            </div>
        </div>
    </div>
</section>
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
<section class="section-parceiros section-dark p-4">
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
        <div class="pb-3 d-flex justify-content-between align-items-center">
            <span class="h2">Depoimentos de Artistas e Lojas</span>
            <a href="<?= url('stores')?>" class="link-kitlit-2">Ver mais</a>
        </div>
        <div id="carrossel-lojas">
            <?php for($i=0; $i<=7; $i++):?>
                <div>
                    <div class="card text-center p-3">
                        <img class="card-img-top rounded-circle mx-auto mt-3" src="https://dcdn-us.mitiendanube.com/stores/002/915/628/themes/common/logo-108771010-1740163103-604f805e8e907da15fa73c01e1d92cbb1740163104.png?0" alt="Depoimento de Artista <?= $i + 1 ?>">
                        <div class="card-body">
                            <h5 class="card-title">Artista <?= $i + 1 ?></h5>
                            <span class="card-text">
                                "Este é um depoimento incrível sobre a plataforma. Adorei a experiência!"
                                <div class="stars d-flex justify-content-center mt-2">
                                    <?php for ($star = 1; $star <= 5; $star++): ?>
                                        <i class="fa fa-star text-warning"></i>
                                    <?php endfor; ?>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endfor;?>
        </div>
    </div>
</section>
<?php if (!$logado) :?>
<section class="section-faq section-dark py-5">
    <div class="container">
        <div class="pb-3">
            <span class="h2">Perguntas Frequentes</span>
            <p class="lead mt-3">Descubra como nossa plataforma pode ajudar você a gerenciar suas vendas, organizar seus produtos e alcançar mais clientes de forma eficiente.</p>
        </div>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item rounded mb-3">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button rounded bg-klikit-2 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Como começar?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
            <div class="accordion-item rounded mb-3">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button rounded collapsed bg-klikit-2 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Como isso me beneficia?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
            <div class="accordion-item rounded mb-3">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button rounded collapsed bg-klikit-2 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Quais são os custos?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-lastcta bg-nocturne-purple-stellar-blue-gradient text-white d-flex align-items-center justify-content-center">
    <div class="container text-center">
        <h2 class="h1">Descubra como nossa plataforma pode ajudar você a gerenciar suas vendas, organizar seus produtos e alcançar mais clientes de forma eficiente.</h2>
        <a href="<?= url('register') ?>" class="btn btn-outline-kiklit-5 btn-lg mt-4">Comece Agora</a>
    </div>
</section>
<?php endif; ?>
<?= $this->stop() ?>
<?= $this->start("js") ?>
<script src="<?= url("assets/vendors/slick-1.8.1/slick/slick.min.js") ?>" defer></script>
<script src="<?= url("assets/js/home.js") ?>"></script>
<?= $this->stop() ?>
