<?= $this->layout("base", [
    'title' => $title, 
    'header' => $header,
    'footer' => $footer
    ]
); ?>

<?= $this->start("css") ?>
<link rel="preload" type="text/css" href="<?= url("assets/vendors/slick-1.8.1/slick/slick.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<link rel="preload" type="text/css" href="<?= url("assets/vendors/slick-1.8.1/slick/slick-theme.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<link rel="stylesheet" href="<?= url("assets/css/begin.css") ?>">

<style>
    .min-height-card {
        min-height: 200px; /* Defina a altura mínima desejada */
    }
    .slick-prev, .slick-next {
        background-color: #000; /* Cor de fundo das setas */
        color: #fff; /* Cor do ícone das setas */
        border-radius: 50%; /* Tornar as setas circulares */
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
        margin-top: -20px; /* Centralizar verticalmente */
    }
    .slick-prev {
        left: -50px; /* Ajuste a posição da seta esquerda */
    }
    .slick-next {
        right: -50px; /* Ajuste a posição da seta direita */
    }
    .slick-prev:hover, .slick-next:hover {
        background-color: #555; /* Cor de fundo das setas ao passar o mouse */
    }

    /* Ajustes para telas menores */
    @media (max-width: 768px) {
        .slick-prev, .slick-next {
            width: 30px;
            height: 30px;
        }
        .slick-prev {
            left: -35px;
        }
        .slick-next {
            right: -35px;
        }
    }

    @media (max-width: 576px) {
        .slick-prev, .slick-next {
            width: 25px;
            height: 25px;
        }
        .slick-prev {
            left: -30px;
        }
        .slick-next {
            right: -30px;
        }
    }
</style>
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>

<section class="section-banner section-dark p-4 avoid-navbar">
    <div class="container">
        <div class="row">
            <div>
                <div class="bg-rockme-2 py-6 px-6 px-xl-0 rounded-4 ">
                <div class="row align-items-center">
                    <div class="offset-xl-1 col-xl-5 col-md-6 col-12 p-5">
                    <div>
                        <h2 class="h1 text-white mb-3">R$ 100</h2>
                        <p class="text-white fs-4">Você vendeu 50 unidades no evento ativo!</p>
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
</section>
<section id="produtos">
    <div class="container">
        <div class="py-3 align-items-center">
            <span class="h2">Alerta de Estoque</span>
        </div>
        <div id="produtosCarousel" class="carousel">
            <?php
            // Exemplo de array de produtos
            $estoque = [
                "Em falta" => [
                    "Adesivo Foxy",
                    "Adesivo Opereta"
                ],
                "1 Unidade" => [
                    "Cartela JoJo",
                    "Cartela Pânico",
                    "Caderno Pânico"
                ],
                "2 Unidades" => [
                    "Botton Monster High",
                    "Botton Pânico"
                ],
                "3 Unidades" => [
                    "A4 Junji Ito",
                ]
            ];

            foreach ($estoque as $quantidade => $produtos) {
                echo '<div class="p-2">'; // Adiciona padding ao redor do card
                echo '<div class="card min-height-card">';
                echo '<div class="card-header">' . $quantidade . '</div>';
                echo '<div class="card-body">';
                echo '<ul>';
                foreach ($produtos as $produto) {
                    echo '<li>' . $produto . '</li>';
                }
                echo '</ul>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>
<section id="vendas">
    <div class="container">
        <div class="py-3 align-items-center">
            <span class="h2">Vendas</span>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Venda #1
                    </div>
                    <div class="card-body">
                        <h5 class="card-title
                        ">R$ 100,00</h5>
                        <p class="card-text">
                            <ul>
                                <li>1x Botton Monster High - R$10,00</li>
                                <li>2x Cadernos Pânico - R$80,00</li>
                                <li>1x Cartela JoJo - R$10,00</li>
                            </ul>
                        </p>
                        <p class="card-text">Data: 01/01/2022 12:00</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Venda #1
                    </div>
                    <div class="card-body">
                        <h5 class="card-title
                        ">R$ 100,00</h5>
                        <p class="card-text">
                            <ul>
                                <li>1x Botton Monster High - R$10,00</li>
                                <li>2x Cadernos Pânico - R$80,00</li>
                                <li>1x Cartela JoJo - R$10,00</li>
                            </ul>
                        </p>
                        <p class="card-text">Data: 01/01/2022 12:00</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Venda #1
                    </div>
                    <div class="card-body">
                        <h5 class="card-title
                        ">R$ 100,00</h5>
                        <p class="card-text">
                            <ul>
                                <li>1x Botton Monster High - R$10,00</li>
                                <li>2x Cadernos Pânico - R$80,00</li>
                                <li>1x Cartela JoJo - R$10,00</li>
                            </ul>
                        </p>
                        <p class="card-text">Data: 01/01/2022 12:00</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Venda #1
                    </div>
                    <div class="card-body">
                        <h5 class="card-title
                        ">R$ 100,00</h5>
                        <p class="card-text">
                            <ul>
                                <li>1x Botton Monster High - R$10,00</li>
                                <li>2x Cadernos Pânico - R$80,00</li>
                                <li>1x Cartela JoJo - R$10,00</li>
                            </ul>
                        </p>
                        <p class="card-text">Data: 01/01/2022 12:00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/vendors/slick-1.8.1/slick/slick.min.js") ?>" defer></script>
<script src="<?= url("assets/js/begin.js") ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#produtosCarousel').slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            infinite: true,
            arrows: true,
            prevArrow: '<button type="button" class="slick-prev">&larr;</button>',
            nextArrow: '<button type="button" class="slick-next">&rarr;</button>',
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });
    });
</script>
<?= $this->stop() ?>
