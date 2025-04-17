<?= $this->layout("base", [
    'title' => $title, 
    'header' => false,
    'footer' => true
]); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/login.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="container-fluid vh-100 d-flex align-items-center justify-content-center bg-btp-kitlit-gradient">
    <!-- <div class="row w-75 h-75 outer-box"> -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="login-form border">
                <h2 class="text-center">Confirmação de E-mail</h2>
                <form id="form-confirmacao" method="post" action="<?= url("") ?>">
                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código de Confirmação</label>
                        <div class="d-flex justify-content-between">
                            <input type="text" class="form-control text-center m-1 input-validate input-kiklit-2" id="codigo1" name="code[0]" maxlength="1" required style="text-transform: uppercase;">
                            <input type="text" class="form-control text-center m-1 input-validate input-kiklit-2" id="codigo2" name="code[1]" maxlength="1" required style="text-transform: uppercase;">
                            <input type="text" class="form-control text-center m-1 input-validate input-kiklit-2" id="codigo3" name="code[2]" maxlength="1" required style="text-transform: uppercase;">
                            <input type="text" class="form-control text-center m-1 input-validate input-kiklit-2" id="codigo4" name="code[3]" maxlength="1" required style="text-transform: uppercase;">
                            <span class="mx-2">-</span>
                            <input type="text" class="form-control text-center m-1 input-validate input-kiklit-2" id="codigo5" name="code[4]" maxlength="1" required style="text-transform: uppercase;">
                            <input type="text" class="form-control text-center m-1 input-validate input-kiklit-2" id="codigo6" name="code[5]" maxlength="1" required style="text-transform: uppercase;">
                            <input type="text" class="form-control text-center m-1 input-validate input-kiklit-2" id="codigo7" name="code[6]" maxlength="1" required style="text-transform: uppercase;">
                            <input type="text" class="form-control text-center m-1 input-validate input-kiklit-2" id="codigo8" name="code[7]" maxlength="1" required style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <a class="btn btn-kiklit-2 mx-1" href="<?= url('auth/logout')?>">Cancelar</a>
                        <button type="submit" class="btn btn-kiklit-2">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    <!-- </div> -->
</section>

<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/js/register/validate-email.js") ?>"></script>
<?= $this->stop() ?>