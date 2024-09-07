<?= $this->layout("base", [
    'title' => $title, 
    'footer' => $footer
    ]
); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/login.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="container-fluid vh-100 d-flex align-items-center justify-content-center bg-klikit-2">
    <div class="row py-md-5 py-3 outer-box">
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="login-form border">
                <h2 class="text-center">Cadastro</h2>
                <p class="text-center">Já possui conta? <a href="<?= url("login") ?>" class="color-btp-1">Entrar</a></p>
                <form id="form-login" method="get" action="<?= url("validate-email") ?>">
                    <div class="mb-3">
                        <label for="user" class="form-label">Usuário</label>
                        <input type="text" class="form-control" id="user" name="user" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmacao-senha" class="form-label">Confirmação de senha</label>
                        <input type="password" class="form-control" id="confirmacao-senha" name="confirmacao-senha" required>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-btp-1">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <img src="https://codescandy.com/geeks-bootstrap-5/assets/images/education/course.png" alt="Login Image" class="img-fluid">
        </div>
    </div>
</section>

<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/js/login.js") ?>"></script>
<?= $this->stop() ?>