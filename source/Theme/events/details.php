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
    <section class="section-slide">
        <?php if (!empty($photos)) {?>
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
        <?php } ?>
    </section>
    <section class="container mt-3">
        <div class="row align-items-center">
            <div class="col-md-6" id="eventTitle"><h1><?= $event['title']?></h1></div>
            <div class="col-md-6 d-md-flex d-block justify-content-end" id="column-buttons">
                <div class="event-buttons">
                    <button class="btn btn-favorite shadow-none btn-event-action"><span class="iconify btn-icon" data-icon="<?= $event['favorite'] == 1 ? 'mdi:heart' : 'mdi:heart-outline' ?>" data-inline="false"></span></button>
                    <button class="btn btn-share shadow-none btn-event-action" id="btn-share"><span class="iconify btn-icon" data-icon="mdi:share-variant" data-inline="false"></span></button>
                </div>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-md-6" id="eventAddress">
                <b class="color-klikit-2"><span class="iconify" data-icon="mdi:map-marker" data-inline="false"></span> <?= !empty($event['address']) ? $event['address'] : 'Local não definido'?></b>
            </div>
            <?php if (!empty($event['production'])) {?>
                <div class="col-md-6 d-md-flex d-block justify-content-end" id="column-productor">
                    <span>Produtor: <a class="link-kitlit-1" href="#" id="eventProductor"><?= $event['production'] ?></a></span>
                </div>
            <?php } ?>
        </div>
        <div class="row mt-3" id="row-dpi" >
            <?php $column = (empty($event['description']) || (empty($days) && empty($prices))) ? 12 : 6 ;?>
            <?php if (!empty($event['description'])) {?>
                <div class="col-md-<?=$column?>" id="column-description">
                    <h4>Descrição</h4>
                    <section id="eventDescription"><?= $event['description']?></section>
                </div>
            <?php } ?>
            <?php if (!empty($days) || !empty($prices)) { ?>
                <div class="col-md-<?=$column?>" id="column-pi">
                    <?php if (!empty($days)) {?>
                        <div class="row" id="daysRow">
                            <h4 class="mb-3">Dias</h4>
                            <?php foreach($days as $day) {?>
                                <div class="col-xxl-4 col-md-6 col-sm-4 col-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $day['date']?></h5>
                                            <h6 class="card-subtitle mb-2 text-muted color-klikit-2"><?= $day['start_time'].'-'.$day['end_time'] ?></h6>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if (!empty($prices)) {?>
                        <div class="row" id="pricesRow">
                            <h4 class="my-3">Inscrições</h4>
                            <?php foreach ($prices as $price) { ?>
                                <div class="col-xxl-4 col-md-6 col-sm-4 col-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $price['name'] ?></h5>
                                            <h6 class="card-subtitle mb-2 text-muted color-klikit-2"><?= $price['price']?> </h6>
                                            <span class="card-subtitle mb-2 text-muted">Até <?= $price['end_date'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <?php if (!empty($event['contacts'])) {?>
                <div class="col-md-6" id="contactsColumn">
                    <h4 class="my-3">Contatos</h4>
                    <ul class="list-unstyled" id="contactsList">
                        <?php foreach($event['contacts'] as $contact) {?>
                            <li>
                                <i class="<?= $contact['icon'] ?>"></i> <span class="color-klikit-2 mx-2"><?= $contact['value']?></span>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <?php if (!empty($event['socialMedia'])) {?>
                <div class="col-md-6" id="socialMediaColumn">
                    <h4 class="my-3">Redes Sociais</h4>
                    <ul class="list-unstyled" id="socialMediaList">
                        <?php foreach($event['socialMedia'] as $socialMedia) {?>
                            <li class="d-flex align-items-center mb-2">
                                <i class="<?= $socialMedia['icon']?>"></i> <a class="link-kitlit-1 mx-2" href="<?= $socialMedia['url']?>" target="_blank"><?= $socialMedia['name']?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </section>
    <?php if (!empty($event['address'])) {?>
    <section id="section-map" class="bg-klikit-5 py-3">
        <div class="container">
            <div class="row mb-3" id="row-map">
                <h4 class="mb-3">Local</h4>
                <div id="mapa">
                    <iframe frameborder='0' title="Google Maps do local do evento" style='border:0; width: 100%; min-height: 500px;' src='https://www.google.com/maps?q=<?= urlencode($event['address'])?>&output=embed' allowfullscreen></iframe>
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
<script defer>const eventId = <?= $event['id'] ?>;</script>
<script src="<?= url("assets/js/events/details.js") ?>" defer></script>
<script>
    $('.slide-item').on('click', async function() {
        $('#imageModal').find('img').attr('src', $(this).attr('src'));
        $('#imageModal').modal('show');
    });
</script>
<?= $this->stop() ?>