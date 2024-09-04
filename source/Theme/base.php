<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Artistar</title>
    <link rel="stylesheet" href="<?= url("assets/vendors/mdi/css/materialdesignicons.min.css") ?>">
    <link rel="stylesheet" href="<?= url("assets/vendors/fontawesome-6.6.0/css/all.min.css") ?>">
    <link rel="stylesheet" href="<?= url("assets/vendors/bootstrap-5.3.3/css/bootstrap.min.css") ?>">
    <link rel="shortcut icon" href="<?= url("assets/images/logo-mini.png") ?>" />
    <?= $this->section("css") ?>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar bg-white mb-4 fixed-top border-bottom py-3" id="navbar">
        <div class="container-fluid px-3">
            <div class="d-flex">
                <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Logo_TV_2015.svg" alt="mdo" class="bi me-2" width="40" height="32">
                </a>

                <ul class="nav col-12 me-md-auto mb-2 justify-content-center mb-md-0 d-none d-md-flex">
                    <li><a href="#" class="nav-link px-2 link-secondary">Log-in</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Cadastre-se</a></li>
                </ul>
            </div>
            <div id="barra-direita" class="d-flex">
                <form class="col-12 col-md-auto me-md-3 d-none d-md-flex">
                    <input type="search" class="form-control" placeholder="Pesquisar..." aria-label="Search">
                </form>
            </div>
        </div>
    </header>
    <?= $this->section("conteudo") ?>
</body>
<footer class="text-center text-lg-start bg-light text-muted">
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
        <div class="me-5 d-none d-lg-block">
            <span>Contate-nos</span>
        </div>
        <div>
            <a href="" class="me-4 text-reset">
            <i class="fab fa-facebook-f"></i>
            </a>
            <a href="" class="me-4 text-reset">
            <i class="fab fa-twitter"></i>
            </a>
            <a href="" class="me-4 text-reset">
            <i class="fab fa-google"></i>
            </a>
            <a href="" class="me-4 text-reset">
            <i class="fab fa-instagram"></i>
            </a>
            <a href="" class="me-4 text-reset">
            <i class="fab fa-linkedin"></i>
            </a>
            <a href="" class="me-4 text-reset">
            <i class="fab fa-github"></i>
            </a>
        </div>
    </section>
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2024 Artistar. Todos os direitos reservados.
    </div>
</footer>
<script src="<?= url("assets/vendors/bootstrap-5.3.3/js/bootstrap.bundle.min.js") ?>"></script>
<script src="<?= url("assets/js/jquery-3.6.0.js") ?>"></script>
<?= $this->section("js") ?>
</html>