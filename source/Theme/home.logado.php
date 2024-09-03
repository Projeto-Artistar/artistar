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
                        <li><a href="#" class="nav-link px-2 link-secondary">Iniciar Vendas</a></li>
                        <li><a href="#" class="nav-link px-2 link-dark"></a></li>
                        <li><a href="#" class="nav-link px-2 link-dark">Categorias</a></li>
                    </ul>
                </div>
                <div id="barra-direita" class="d-flex">
                    <form class="col-12 col-md-auto me-md-3 d-none d-md-flex">
                        <input type="search" class="form-control" placeholder="Pesquisar..." aria-label="Search">
                    </form>

                    <button data-bs-toggle="offcanvas" style="border:none; background:none;" type="button" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                        <i class="fa-solid fa-bars" style="width:24px; text-align: center;"></i>
                    </button>
                </div>
            </div>
        </header>

        <nav class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header px-4 d-flex justify-content-between align-items-center">
                <a href="/" class="d-flex align-items-center me-md-auto link-dark text-decoration-none">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Logo_TV_2015.svg" alt="mdo" class="bi me-2" width="40" height="32">
                </a>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                
            </div>
                <div class="offcanvas-body d-flex flex-column justify-content-between">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="d-md-none">
                        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                            <input type="search" class="form-control" placeholder="Pesquisar..." aria-label="Search">
                        </form>
                    </li>
                    <li class="d-md-none">
                        <a href="#" class="nav-link link-secondary">
                            <div class="d-flex align-items-center">
                                <span>Eventos</span>
                            </div>
                        </a>
                    </li>
                    <li class="d-md-none">
                        <a href="#" class="nav-link link-dark">
                            <div class="d-flex align-items-center">
                                <span>Lojas</span>
                            </div>
                        </a>
                    </li>
                    <li class="d-md-none">
                        <a href="#" class="nav-link link-dark">
                            <div class="d-flex align-items-center">
                                <span>Categorias</span>
                            </div>
                        </a>
                    </li>
                    <li class="d-md-none border-top my-3"></li>
                    <li>
                        <a href="#" class="nav-link link-dark d-block">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-plus bi me-4" style="width:24px; text-align: center;"></i>
                                <span>Inscrições</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark d-block">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-list bi me-4" style="width:24px; text-align: center;"></i>
                                <span>Inventário</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-dark d-block">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-dollar-sign bi me-4" style="width:24px; text-align: center;"></i>
                                <span>Vendas</span>
                            </div>
                        </a>
                    </li>
                    <li class="border-top my-3"></li>
                    <li>
                        <a href="#" class="nav-link link-dark">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-ranking-star bi me-4" style="width:24px; text-align: center;"></i>
                                <span>Estatísticas</span>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="border-top my-3"></div>
                <div class="d-flex justify-content-between align-items-center">
                    <div href="#" class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center px-2">
                            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-4">
                            <span><strong>Sua Loja</strong></span>
                        </div>
                    </div>
                    <button style="border:none; background:none;"><i class="fa-solid fa-right-from-bracket px-2"></i></button>
                </div>
            </div>
        </nav>
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
          © Artistar. Todos os direitos reservados.
        </div>
      </footer>
      <script src="/assets/js/home.js"></script>
</html>
