<?= $this->layout("base") ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/vendors/slick-1.8.1/slick/slick.css") ?>">
<link rel="stylesheet" href="<?= url("assets/vendors/slick-1.8.1/slick/slick-theme.css") ?>">
<link rel="stylesheet" href="<?= url("assets/css/home.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<?php if(!$logado) : ?>
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
                                        <h2 class="h1 text-white mb-3">Viver da sua arte não precisa ser um caos! <br>Pode ser mais <span class="text-typeEffect" data-palavras='<?= json_encode(["organizado", "leve", "tranquilo", "do seu jeito", "estruturado", "descomplicado", "profissional", "rentável"]) ?>'></span>|</h2>
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
        <div class="row" style="padding-top: 100px;">
            <div class="col-lg-8 d-flex flex-column justify-content-center">
                <div>
                    <h1 class="display-5 text-white">
                        <span class="fw-bold"><?= $translator->translate('Viver da sua arte') ?><br><?= $translator->translate('não precisa ser um caos!') ?></span><br>
                        <span class="fw-bold"><?= $translator->translate('Pode ser mais') ?></span> <span class="text-typeEffect" data-palavras='<?= json_encode([
                            $translator->translate("organizado"),
                            $translator->translate("leve"),
                            $translator->translate("tranquilo"),
                            $translator->translate("do seu jeito"),
                            $translator->translate("estruturado"),
                            $translator->translate("descomplicado"),
                            $translator->translate("profissional"),
                            $translator->translate("rentável")
                        ]) ?>'></span><span class="pipe-typeEffect">|</span>
                    </h1>
                    <p class="text-white fs-4"><?= $translator->translate('A gente simplifica o lado profissional da sua arte pra você focar no que mais ama fazer: criar!') ?></p>
                    <a href="<?= url('register') ?>" class="btn btn-lg btn-stellar-blue inverted-version mt-3"><?= $translator->translate('Comece Agora') ?></a>
                </div>
            </div>
            <div class="col-lg-4 text-center mt-5 mt-lg-0">
                <img src="<?= url('assets/image/luna.svg') ?>" alt="learning" class="img-fluid">
            </div>
        </div>
        <div class="row text-center mt-5 py-5">
            <div class="col-12 mb-5">
                <h2 class="h1 text-white"><?= $translator->translate('Faça as suas vendas, do seu jeito') ?></h2>
            </div>
            <div class="col-md-4 mb-4">
                <img style="width: 200px;" src="<?= url('assets/image/home/beneficio1.svg') ?>" alt="Benefício 1" class="img-fluid mb-3">
                <h5 class="fw-bold color-nocturne-purple"><?= $translator->translate('Tudo em um só lugar') ?></h5>
                <p class="text-muted"><?= $translator->translate('Eventos, estoque, vendas e comunidade em um só lugar, sem precisar se perder entre mil ferramentas.') ?></p>
            </div>
            <div class="col-md-4 mb-4">
                <img style="width: 200px;" src="<?= url('assets/image/home/beneficio2.svg') ?>" alt="Benefício 2" class="img-fluid mb-3">
                <h5 class="fw-bold color-nocturne-purple"><?= $translator->translate('Venda em tempo real') ?></h5>
                <p class="text-muted"><?= $translator->translate('Registre suas vendas na hora, com tudo calculado, do seu faturamento à reposição dos produtos.') ?></p>
            </div>
            <div class="col-md-4 mb-4">
                <img style="width: 200px;" src="<?= url('assets/image/home/beneficio3.svg') ?>" alt="Benefício 3" class="img-fluid mb-3">
                <h5 class="fw-bold color-nocturne-purple"><?= $translator->translate('Seu catálogo sempre com você') ?></h5>
                <p class="text-muted"><?= $translator->translate('Compartilhe seus produtos de forma digital com seus clientes, até no meio do evento.') ?></p>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<section class="section-vendas bg-stellar-blue py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12 px-3 text-white">
                <h1 class="display-5 fw-bold"><?= $translator->translate('Faça as suas vendas,') ?><br><?= $translator->translate('do seu jeito') ?></h1>
                <table class="mt-4">
                    <tbody>
                        <tr>
                            <td><i class="fa-solid fa-arrow-right me-3"></i></td>
                            <td class="h4 fw-bold"><?= $translator->translate('Encontre seus produtos na hora') ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><p class="h5 my-3"><?= $translator->translate('Busque seus produtos em segundos e registre a venda sem interromper nada.') ?></p></td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-arrow-right me-3"></i></td>
                            <td class="h4 fw-bold"><?= $translator->translate('Cadastre novos produtos ali mesmo') ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><p class="h5 my-3"><?= $translator->translate('Criou algo novo ou levou um item diferente? Dá pra adicionar durante a venda e seguir sem perder tempo.') ?></p></td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-arrow-right me-3"></i></td>
                            <td class="h4 fw-bold"><?= $translator->translate('Saiba exatamente como foi o evento') ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><p class="h5 my-3"><?= $translator->translate('Acompanhe seu faturamento por evento e saiba o que precisa repor para o próximo, sem precisar contar tudo depois.') ?></p></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><a href="<?= url('register') ?>" class="btn btn-lg btn-stellar-blue inverted-version mt-3"><?= $translator->translate('Comece Agora') ?></a></td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
            <div class="col-md-6 col-12 mt-4 mt-md-0 d-flex align-items-center justify-content-center ps-3 ps-md-5">
                <div style="overflow: hidden; border-radius: 20px;">
                    <lottie-player 
                        src="<?= url("assets/lottie/animacao_vendas.json") ?>"
                        background="transparent" 
                        speed="1" 
                        loop 
                        autoplay>
                    </lottie-player>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-phrase bg-white py-5 my-5">
    <div class="container">
        <h2 class="h1 color-nocturne-purple"><?= $translator->translate('"Descubra como nossa plataforma pode ajudar você a gerenciar suas vendas, organizar seus produtos e alcançar mais clientes de forma eficiente."') ?></h2>
        <p class="mt-3 h5 color-gray">Thuanny Oliveira, Deartcass</p> 
        <a href="<?= url('register') ?>" class="btn btn-lg btn-outline-nocturne-purple mt-3"><?= $translator->translate('Comece Agora') ?></a>
    </div>
</section>
<section class="section-vendas bg-cotton-candy py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12 mt-4 mt-md-0 d-flex flex-column justify-content-center">
                <h1 class="h1 text-white"><?= $translator->translate('Comece a organizar sua arte!') ?></h1>
                <p class="h4 text-white my-5"><?= $translator->translate('Do seu estoque até a primeira venda, sem complicar a sua vida') ?></p>
                <div>
                    <a href="<?= url('register') ?>" class="btn btn-lg btn-cotton-candy inverted-version mt-3"><?= $translator->translate('Comece Agora') ?></a>
                </div>
            </div>
            <div class="col-md-6 col-12 px-3 text-white">
                <div class="row">
                    <div class="col-1">01</div>
                    <div class="col-11">
                        <h4 class="font-weight-bold"><?= $translator->translate('Organize seu estoque do seu jeito.') ?></h4>
                        <p><?= $translator->translate('Cadastre seus produto do seu jeito e que faz sentido pra você e pra sua rotina.') ?></p>
                    </div>
                    <hr>
                    <div class="col-1">02</div>
                    <div class="col-11">
                        <h4 class="font-weight-bold"><?= $translator->translate('Planeje seus eventos') ?></h4>
                        <p><?= $translator->translate('Encontre, registre e organize sua agenda de eventos em um só lugar.') ?></p>
                    </div>
                    <hr>
                    <div class="col-1">03</div>
                    <div class="col-11">
                        <h4 class="font-weight-bold"><?= $translator->translate('Monte seu catálogo de produtos') ?></h4>
                        <p><?= $translator->translate('Personalize seu catálogo com a sua cara e deixe tudo pronto pra mostrar pros seus clientes, até durante o evento.') ?></p>
                    </div>
                    <hr>
                    <div class="col-1">04</div>
                    <div class="col-11">
                        <h4 class="font-weight-bold"><?= $translator->translate('Comece a vender de verdade') ?></h4>
                        <p><?= $translator->translate('Registre suas vendas na hora, sem ser tudo um caos, e acompanhe tudo enquanto acontece.') ?></p>
                    </div>
                    <hr>
                    <div class="col-1">05</div>
                    <div class="col-11">
                        <h4 class="font-weight-bold"><?= $translator->translate('Entenda o que funciona pra você') ?></h4>
                        <p><?= $translator->translate('Veja os produtos que mais vende e o que precisa repor rápido.') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-parceiros section-dark p-4">
    <div class="container">
        <div class="pb-3">
            <span class="h2"><?= $translator->translate('Parceiros') ?></span>
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
<?php if ($logado) :?>
<section class="section-faq section-dark py-5">
    <div class="container">
        <div class="pb-3">
            <span class="h1"><?= $translator->translate('Ficou com alguma dúvida?') ?></span><br><br>
            <span class="h4 lead mt-3"><?= $translator->translate('Vem que a gente responde!') ?></span>
        </div>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1-collapse" aria-expanded="false" aria-controls="faq1-collapse">
                        <?= $translator->translate('O que é o Artistar?') ?>
                    </button>
                </h2>
                <div id="faq1-collapse" class="accordion-collapse collapse" aria-labelledby="faq1" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?= $translator->translate('O Artistar é uma plataforma feita de artista para artistas, que te ajuda a organizar o lado profissional da sua arte, desde suas vendas ao seu estoque, dos eventos que vai participar até o catálogo que seus clientes vão ver, tudo em um só lugar.') ?>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-collapse" aria-expanded="false" aria-controls="faq2-collapse">
                        <?= $translator->translate('Posso usar o Artistar durante eventos?') ?>
                    </button>
                </h2>
                <div id="faq2-collapse" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?= $translator->translate('Pode sim e deve! O Artistar foi projetado para você conseguir registrar suas vendas na hora, da forma mais rápida e sem perder venda, mesmo no meio do movimento.') ?>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3-collapse" aria-expanded="false" aria-controls="faq3-collapse">
                        <?= $translator->translate('O Artistar é uma plataforma de loja virtual?') ?>
                    </button>
                </h2>
                <div id="faq3-collapse" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?= $translator->translate('Ele não é uma loja virtual. O Artistar cuida da organização do seu negócio como um todo, inclusive ajudando você a vender melhor, dentro dos eventos que você participa.') ?>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4-collapse" aria-expanded="false" aria-controls="faq4-collapse">
                        <?= $translator->translate('Funciona para quem está começando agora?') ?>
                    </button>
                </h2>
                <div id="faq4-collapse" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?= $translator->translate('Óbvio! Inclusive, é uma ótima forma de você começar já com tudo organizadinho, desde o início!') ?>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq5">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5-collapse" aria-expanded="false" aria-controls="faq5-collapse">
                        <?= $translator->translate('E se eu já vendo há um tempo?') ?>
                    </button>
                </h2>
                <div id="faq5-collapse" class="accordion-collapse collapse" aria-labelledby="faq5" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?= $translator->translate('Melhor ainda! O Artistar te ajuda a sair do improviso e ter mais controle e profissionalismo sobre o que você já faz ; )') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-lastcta bg-nocturne-purple-stellar-blue-gradient text-white d-flex align-items-center justify-content-center" style="background-attachment: fixed;">
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
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<?= $this->stop() ?>
