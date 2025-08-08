<?= $this->layout("base", [
    'title' => $title, 
    'header' => false,
    'footer' => true
]); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/password-reset/home.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-nocturne-purple-stellar-blue-gradient">
    <div class="row min-h-75 outer-box">
        <div class="py-5 d-flex flex-column-reverse flex-md-row">
            <div class="col-md-6 d-flex align-items-center justify-content-center order-2 order-md-1">
                <img src="https://codescandy.com/geeks-bootstrap-5/assets/images/education/course.png" alt="Login Image" class="img-fluid">
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center order-1 order-md-2">
                <div class="login-form border">
                    <h2 class="text-center">Esqueci minha senha</h2>
                    <form id="form-password-reset" method="get" action="<?= url("password-reset/code") ?>">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control input-stellar-blue" id="email" name="email" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?= url('login') ?>" class="link-stellar-blue">Cancelar</a>
                            <button type="submit" class="btn btn-nocturne-purple" id="btn-confirm-password-reset">
                                <span id="spinner-confirm" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                                <span id="text-confirm">Enviar e-mail</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="toasts-section">
    <div class="toast align-items-center text-light bg-success border-0 toast-success m-3" id="myToast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
        <div class="toast-header">
            <strong class="me-auto" id="toastTitle">Título</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastBody">
            Mensagem do toast.
        </div>
    </div>
</section>

<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/js/password-reset/home.js") ?>"></script>
<?= $this->stop() ?>