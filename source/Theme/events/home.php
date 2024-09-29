<?= $this->layout("base", [
    'title' => $title, 
    'header' => $header,
    'footer' => $footer
    ]
); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" type="text/css" href="<?= url("assets/vendors/slick-1.8.1/slick/slick.css") ?>"/>
<link rel="stylesheet" type="text/css" href="<?= url("assets/vendors/slick-1.8.1/slick/slick-theme.css") ?>"/>
<style>


.modal-dialog {
  max-width: 730px;
}

.wrap-modal-slider {
  padding: 0 30px;
  opacity: 0;
  transition: all 0.3s;
}

.wrap-modal-slider.open {
  opacity: 1;
}

.slick-prev:before, .slick-next:before {
  color: red;
}

</style>
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>

<div class="avoid-navbar"></div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  open slick slider inside modal bootstrap
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Compartilhar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="flex-grow-1 text-start p-2 border rounded" id="linkToCopy">
                        <?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>
                    </div>
                    <button class="btn btn-secondary ms-2" id="copyUrl">
                        <i class="fas fa-link"></i> Copiar URL
                    </button>
                </div>
                <div class="wrap-modal-slider">
                    <div class="your-class">
                        <div class="share-button align-items-center">
                            <button class="btn btn-primary m-2" id="shareFacebook">
                                <i class="fab fa-facebook-f fa-2x"></i>
                            </button>
                            <div>Facebook</div>
                        </div>
                        <div class="share-button align-items-center">
                            <button class="btn btn-success m-2" id="shareWhatsApp">
                                <i class="fab fa-whatsapp fa-2x"></i>
                            </button>
                            <div>WhatsApp</div>
                        </div>
                        <div class="share-button">
                            <button class="btn btn-danger m-2" id="sharePinterest">
                                <i class="fab fa-pinterest fa-2x"></i>
                            </button>
                            <div>Pinterest</div>
                        </div>
                        <div class="share-button">
                            <button class="btn btn-info m-2" id="shareLinkedIn">
                                <i class="fab fa-linkedin-in fa-2x"></i>
                            </button>
                            <div>LinkedIn</div>
                        </div>
                        <div class="share-button">
                            <button class="btn btn-primary m-2" id="shareTelegram">
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

<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/vendors/slick-1.8.1/slick/slick.min.js") ?>"></script>
<script>
    $(document).ready(function(){
        $('.your-class').slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            infinite: false,
            arrows: true,
            prevArrow: '<button type="button" class="slick-prev">Previous</button>',
            nextArrow: '<button type="button" class="slick-next">Next</button>'
        });
    });

    $('.modal').on('shown.bs.modal', function (e) {
        $('.your-class').slick('setPosition');
        $('.wrap-modal-slider').addClass('open');
    })
</script>
<?= $this->stop() ?>