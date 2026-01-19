<?= $this->layout("base", [
    'title' => $title, 
    'logado' => $logado,
    'header' => true,
    'footer' => true
]); ?>

<?= $this->start("css") ?>
<link type="text/css" href="<?= url("assets/vendors/slick-1.8.1/slick/slick.css") ?>"/>
<link type="text/css" href="<?= url("assets/vendors/slick-1.8.1/slick/slick-theme.css") ?>"/>
<link rel="stylesheet" rel="preload" href="<?= url("assets/css/events/details.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="content avoid-navbar">
    <?php if (!empty($photos)) {?>
    <section class="section-slide">
        <div id="photosCarousel" class="col-12 carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators" id="photo-carousel-indicators">
                <?php 
                    foreach($photos as $photoKey => $photo) {
                        $current = $photoKey == 0 ? 'class="active"' : '';
                ?>
                    <button type="button" data-bs-target="#photosCarousel" data-bs-slide-to="<?= $photoKey ?>" <?= $current ?> aria-label="<?= $photo['label']?>"></button>
                <?php } ?>
            </div>
            <div class="carousel-inner" id="carousel-items">
                <?php 
                    foreach($photos as $photoKey => $photo) {
                        $active = $photoKey == 0 ? 'active' : '';
                ?>
                    <div class="carousel-item <?= $active?>">
                        <div class="slide d-flex justify-content-center">
                            <div class="slide-background" data-bg="<?= $photo['url'] ?>"></div>
                            <?php if ($photoKey == 0) { ?>
                                <!-- Preload the first image -->
                                <link rel="preload" href="<?= $photo['url'] ?>" as="image">
                                <img class="slide-item" src="<?= $photo['url'] ?>" alt="<?= $photo['label'] ?>" loading="eager">
                            <?php } else { ?>
                                <img class="slide-item" src="<?= $photo['url'] ?>" alt="<?= $photo['label'] ?>" loading="lazy">
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <button id="slide-btn-previous" class="carousel-control-prev" type="button" data-bs-target="#photosCarousel" data-bs-slide="prev" <?php if (count($photos) == 1) echo 'style="display: none;"'?>>
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button id="slide-btn-next" class="carousel-control-next" type="button" data-bs-target="#photosCarousel" data-bs-slide="next" <?php if (count($photos) == 1) echo 'style="display: none;"'?>>
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </section>
    <?php } ?>
    <section class="container pt-4 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6" id="eventTitle"><h1><?= $event['evento_nome']?></h1></div>
            <div class="col-md-6 d-md-flex d-block justify-content-end" id="column-buttons">
                <div class="event-buttons">
                    <button class="btn btn-favorite shadow-none btn-event-action"><span class="iconify btn-icon" data-icon="<?= $event['inscrito'] == 1 ? 'mdi:heart' : 'mdi:heart-outline' ?>" data-inline="false"></span></button>
                    <button class="btn btn-share shadow-none btn-event-action" id="btn-share"><span class="iconify btn-icon" data-icon="mdi:share-variant" data-inline="false"></span></button>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-md-6" id="eventAddress">
                <b class="color-stellar-blue"><span class="iconify" data-icon="mdi:map-marker" data-inline="false"></span> <?= !empty($event['endereco_completo']) ? $event['endereco_completo'] : 'Local não definido'?></b>
            </div>
            <?php if (!empty($event['evento_produtor'])) {?>
                <div class="col-md-6 d-md-flex d-block justify-content-end" id="column-productor">
                    <p>Produtor: <span class="color-stellar-blue" id="eventProductor"><?= $event['evento_produtor'] ?></span></p>
                </div>
            <?php } ?>
        </div>
        <div class="row mt-3">
            <?php if (!empty($event['evento_descricao'])) {?>
                <div class="col-md-6 col-12" id="column-description">
                    <h4 class="mb-3">Descrição</h4>
                    <section><?= nl2br($event['evento_descricao']) ?></section>
                </div>
            <?php } ?>
            <?php if (!empty($days)): ?>
                <div class="col-md-6 col-12">
                    <div class="row" id="daysRow">
                        <h4 class="mb-3">Datas</h4>
                        <?php foreach($days as $day) {?>
                            <div class="col-xxl-4 col-xl-6 col-12 mb-3 date-card">
                                <div class="card h-100 flex-column position-relative">
                                    <div class="p-3 pb-2">
                                        <h5 class="mb-0"><?= formatWeekDateToPortuguese($day['evento_data_dia']) ?></h5>
                                    </div>
                                    <div class="card-body pt-0">
                                        <h5 class="card-title"><?= date('d/m/Y', strtotime($day['evento_data_dia']))?></h5>
                                        <span class="card-subtitle mb-2 text-muted"><?= date('H:i', strtotime($day['evento_data_hora_inicial'])).(!empty($day['evento_data_hora_final']) ? ' - '.date('H:i', strtotime($day['evento_data_hora_final'])) : '') ?></span>
                                        <?php if (!empty($day['evento_data_observacao'])) { ?>
                                            <span class="btn btn-stellar-blue d-flex align-items-center mt-3 edit-date">
                                                <i class="fa-solid fa-eye ms-1 me-2" style="text-align: center;"></i> Observações
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($advantages)): ?>
                <div class="col-md-6 col-12">
                    <h4 class="my-3">Vantagens</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($advantages as $advantage) { ?>
                            <span class="badge bg-nocturne-purple"><?= $advantage['nome'] ?></span>
                        <?php } ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($prices)): ?>
                <div class="col-md-6 col-12">
                    <div class="row" id="pricesRow">
                        <h4 class="my-3">Taxas e Custos</h4>
                        <?php foreach ($prices as $price) { ?>
                            <div class="col-xxl-4 col-xl-6 col-12 mb-3">
                                <div class="card h-100 flex-column position-relative">
                                    <div class="card-body d-flex flex-column">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title"><?= $price['evento_taxa_titulo'] ?></h5>
                                        </div>
                                        <h6 class="card-subtitle mb-2 text-muted">R$ <?= moedaReal($price['evento_taxa_valor']) ?></h6>
                                        <?php if (!empty($price['evento_taxa_observacao'])) { ?>
                                            <span class="btn btn-stellar-blue d-flex align-items-center mt-3 edit-date" data-bs-toggle="popover" data-bs-content="<?= nl2br(str_replace("\n", "<br>", $price['evento_taxa_observacao'])) ?>">
                                                <i class="fa-solid fa-eye ms-1 me-2" style="text-align: center;"></i> Observações
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php if (!empty($event['endereco_completo'])) {?>
    <section id="section-map" class="bg-nocturne-purple py-3">
        <div class="container">
            <div class="row mb-3" id="row-map">
                <h4 class="mb-3 color-snow-white">Local</h4>
                <div id="mapa">
                    <iframe frameborder='0' title="Google Maps do local do evento" style='border:0; width: 100%; min-height: 500px;' src='https://www.google.com/maps?q=<?= urlencode($event['endereco_completo'])?>&output=embed' allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
    <section id="slide-item-modal">
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered slide-dialog">
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <img  class="img-fluid img-modal" alt="Imagem">
                </div>
            </div>
        </div>
    </section>
    <section id="share-modal">
        <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shareModalLabel">Compartilhar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="flex-grow-1 text-start p-2 border rounded overflow-hidden text-nowrap" id="linkToCopy">
                                <?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>
                            </div>
                            <button class="btn btn-kiklit-2 ms-2" id="copyUrl">
                                <i class="fas fa-link"></i> Copiar
                            </button>
                        </div>
                        <div class="wrap-modal-slider">
                            <div class="your-class">
                                <div class="share-button d-flex flex-column align-items-center">
                                    <button class="btn btn-primary mb-2" id="shareFacebook">
                                        <i class="fab fa-facebook-f fa-2x"></i>
                                    </button>
                                    <div>Facebook</div>
                                </div>
                                <div class="share-button d-flex flex-column align-items-center">
                                    <button class="btn btn-success mb-2" id="shareWhatsApp">
                                        <i class="fab fa-whatsapp fa-2x"></i>
                                    </button>
                                    <div>WhatsApp</div>
                                </div>
                                <div class="share-button d-flex flex-column align-items-center">
                                    <button class="btn btn-danger mb-2" id="sharePinterest">
                                        <i class="fab fa-pinterest fa-2x"></i>
                                    </button>
                                    <div>Pinterest</div>
                                </div>
                                <div class="share-button d-flex flex-column align-items-center">
                                    <button class="btn btn-info mb-2" id="shareLinkedIn">
                                        <i class="fab fa-linkedin-in fa-2x"></i>
                                    </button>
                                    <div>LinkedIn</div>
                                </div>
                                <div class="share-button d-flex flex-column align-items-center">
                                    <button class="btn btn-primary mb-2" id="shareTelegram">
                                        <i class="fab fa-telegram-plane fa-2x"></i>
                                    </button>
                                    <div>Telegram</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="copyToast" class="toast bg-klikit-1" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-light">
                URL copiada para a área de transferência!
            </div>
        </div>
    </div>
</section>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<!-- Outros scripts -->
<script src="<?= url("assets/vendors/slick-1.8.1/slick/slick.min.js") ?>" defer></script>
<script defer>const eventId = <?= $event['evento_id'] ?>;</script>
<script src="<?= url("assets/js/events/details.js") ?>" defer></script>
<script>
    $('.slide-item').on('click', async function() {
        $('#imageModal').find('img').attr('src', $(this).attr('src'));
        $('#imageModal').modal('show');
    });
</script>
<?= $this->stop() ?>