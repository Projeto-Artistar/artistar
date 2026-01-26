<?= $this->layout("base", [
    'title' => $title, 
    'header' => false,
    'footer' => true,
]); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/login.css") ?>">
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
                    <h2 class="text-center">Login</h2>
                    <p class="text-center">Não possui conta? <a href="<?= url("register?r=" . $redirect) ?>" class="link-stellar-blue">Cadastre-se</a></p>
                    <form id="form-login" method="post" action="<?= url("?r=" . $redirect) ?>">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control input-stellar-blue" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control input-stellar-blue" id="senha" name="senha" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?= url("password-reset?r=" . $redirect) ?>" class="link-stellar-blue">Esqueci minha senha</a>
                            <button type="submit" class="btn btn-nocturne-purple w-25">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/js/login.js") ?>"></script>
<?= $this->stop() ?>