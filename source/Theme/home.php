<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/vendor/fontawesome-6.6.0/css/all.min.css">    
        <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.4.95/css/materialdesignicons.min.css">
        <link href="vendor/bootstrap-5.3.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="assets/css/home.css" rel="stylesheet">
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
        <section class="pt-5 mb-4 mt-5">
            <div class="container">
                <div class="row">
                    <div>
                        <div class="bg-primary py-6 px-6 px-xl-0 rounded-4 ">
                        <div class="row align-items-center">
                            <div class="offset-xl-1 col-xl-5 col-md-6 col-12 p-5">
                            <div>
                                <h2 class="h1 text-white mb-3">Vamos tornar suas vendas mais fáceis!</h2>
                                <p class="text-white fs-4">Registre sua atividade e analise seus resultados de forma rápida e eficiente...</p>
                                <button class="btn btn-dark">Vamos lá!</button>
                            </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                            <div class="text-center">
                                <img src="https://codescandy.com/geeks-bootstrap-5/assets/images/education/course.png" alt="learning" class="img-fluid">
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="container">
            <div class="row" id="eventos">
            </div>
        </section>
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
      <script src="/assets/js/home.js"></script>
      <script>
        $(document).ready(function() {
          setTimeout(function() {
                carregarEventos();
            }, 2000);
        });
      </script>
</html>
