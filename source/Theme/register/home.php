<?= $this->layout("base", [
    'title' => $title, 
    'header' => false,
    'footer' => true
]); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/register/home.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-stellar-blue-nocturne-purple-gradient">
    <div class="row py-md-5 py-3 outer-box">
        <div class="d-block d-md-flex">
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="login-form border">
                    <h2 class="text-center">Cadastro</h2>
                    <p class="text-center">Já possui conta? <a href="<?= url("login?r=".$redirect) ?>" class="link-stellar-blue">Entrar</a></p>
                    <form id="form-register" class="needs-validation" method="get" action="<?= url("register/validate-email?r=".$redirect) ?>" novalidate>
                        <div class="mb-3">
                            <label for="user" class="form-label">Nome de Usuário</label>
                            <input type="text" class="form-control input-stellar-blue" id="user" name="user" required minlength="3">
                            <small id="userCompleteHelp" class="form-text text-muted">Identificação única.</small>
                            <div class="invalid-feedback" id="userInvalidFeedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="complete_user" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control input-stellar-blue" id="complete_user" name="complete_user" required>
                            <small id="userCompleteHelp" class="form-text text-muted">Nome artístico/da loja</small>
                            <div class="invalid-feedback" id="completeUserInvalidFeedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control input-stellar-blue" id="email" name="email" required>
                            <div class="invalid-feedback">
                                Por favor, insira um e-mail válido.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control input-stellar-blue" id="senha" name="senha" required>
                            <div class="invalid-feedback">
                                A senha deve conter pelo menos 8 caracteres, incluindo uma letra maiúscula, uma letra minúscula, um número e um caractere especial.
                            </div>
                        </div>
                        <div class="mb-3 position">
                            <label for="confirmacao-senha" class="form-label">Confirmação de senha</label>
                            <input type="password" class="form-control input-stellar-blue" id="confirmacao-senha" name="confirmacao-senha" required>
                            <div class="invalid-feedback">
                                As senhas não coincidem.
                            </div>
                        </div>
                        <!-- <div class="mb-3 position d-flex">
                            <input type="checkbox" class="form-check-input checkbox-kiklit-2" id="aceito-termos" name="aceito-termos" required>
                            <label class="form-check label" for="aceito-termos">Li e aceito as <a href="<?= url('legal/privacy')?>" target="_blank" class="link-kitlit-2">Políticas de Privacidade</a> e os <a href="<?= url('legal/terms')?>" target="_blank" class="link-kitlit-2">Termos de Uso</a></label>
                        </div> -->
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-nocturne-purple" id="btn-confirm-register">
                                <span id="spinner-confirm" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                                <span id="text-confirm">Confirmar</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <img src="<?= url('assets/image/luna.svg') ?>" alt="Login Image" class="img-fluid" style="max-width: 60%;">
            </div>
        </div>
    </div>
</section>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/js/register/home.js") ?>"></script>
<?= $this->stop() ?>