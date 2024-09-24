<?= $this->layout("base", [
    'title' => $title, 
    'header' => $header,
    'footer' => $footer
    ]
); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/register/home.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row py-md-5 py-3 w-75">
        <div class="col d-flex align-items-center justify-content-center">
            <div class="login-form border">
                <h2 class="text-center">Nova Senha</h2>
                <form id="form-new-password" method="post" action="<?= url("auth/update-password") ?>">
                    <div class="mb-3">
                        <label for="senha" class="form-label">Nova Senha</label>
                        <input type="password" class="form-control input-kiklit-2" id="senha" name="senha" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmacao-senha" class="form-label">Confirmação de Nova Senha</label>
                        <input type="password" class="form-control input-kiklit-2" id="confirmacao-senha" name="confirmacao-senha" required>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-kiklit-2">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/js/register/home.js") ?>"></script>
<?= $this->stop() ?>