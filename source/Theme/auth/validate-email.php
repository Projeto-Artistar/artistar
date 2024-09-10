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
    <!-- <div class="row w-75 h-75 outer-box"> -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="login-form border">
                <h2 class="text-center">Confirmação de E-mail</h2>
                <p class="text-center">Já possui uma conta? <a href="<?= url("login") ?>" class="color-btp-1">Entrar</a></p>
                <form id="form-confirmacao" method="post" action="<?= url("validate-email") ?>">
                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código de Confirmação</label>
                        <div class="d-flex justify-content-between">
                            <input type="text" class="form-control text-center m-1 input-validate" id="codigo1" name="codigo1" maxlength="1" required style="text-transform: uppercase;">
                            <input type="text" class="form-control text-center m-1 input-validate" id="codigo2" name="codigo2" maxlength="1" required style="text-transform: uppercase;">
                            <input type="text" class="form-control text-center m-1 input-validate" id="codigo3" name="codigo3" maxlength="1" required style="text-transform: uppercase;">
                            <input type="text" class="form-control text-center m-1 input-validate" id="codigo4" name="codigo4" maxlength="1" required style="text-transform: uppercase;">
                            <span class="mx-2">-</span>
                            <input type="text" class="form-control text-center m-1 input-validate" id="codigo5" name="codigo5" maxlength="1" required style="text-transform: uppercase;">
                            <input type="text" class="form-control text-center m-1 input-validate" id="codigo6" name="codigo6" maxlength="1" required style="text-transform: uppercase;">
                            <input type="text" class="form-control text-center m-1 input-validate" id="codigo7" name="codigo7" maxlength="1" required style="text-transform: uppercase;">
                            <input type="text" class="form-control text-center m-1 input-validate" id="codigo8" name="codigo8" maxlength="1" required style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-btp-1">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    <!-- </div> -->
</section>

<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/js/login.js") ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input[type="text"]');
        inputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                if (this.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', function(event) {
                if (event.key === 'Backspace' && this.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    });
</script>
<?= $this->stop() ?>