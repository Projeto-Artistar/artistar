<?php
require_once 'classes/sales.php';

$sales = new Sales();

$mySales = $sales->listSales();

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">    
        <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.4.95/css/materialdesignicons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>
    <body>
        <header class="p-3 mb-3 border-bottom">
            <div>
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="d-lg-flex">
                        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Logo_TV_2015.svg" alt="mdo" class="bi me-2" width="40" height="32">
                        </a>

                        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                            <li><a href="#" class="nav-link px-2 link-secondary">Eventos</a></li>
                            <li><a href="#" class="nav-link px-2 link-dark">Lojas</a></li>
                            <li><a href="#" class="nav-link px-2 link-dark">Categorias</a></li>
                        </ul>
                    </div>
                    <div class="d-lg-flex">
                        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                            <input type="search" class="form-control" placeholder="Pesquisar..." aria-label="Search">
                        </form>
    
                        <button data-bs-toggle="offcanvas" style="border:none; background:none;" type="button" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Logo_TV_2015.svg" alt="mdo" class="bi me-2" width="40" height="32">
                    <span class="ml-1 fs-4">Artistar</span>
                </a>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                
            </div>
                <div class="offcanvas-body d-flex flex-column justify-content-between">
                <ul class="nav nav-pills flex-column mb-auto">
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
                <hr>
                <div class="d-flex justify-content-between">
                    <a>
                        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                        <strong>*Sua Loja*</strong>
                    </a>
                    <i class="fa-solid fa-right-from-bracket"></i>
                </div>
            </div>
        </div>
        
    </body>
</html>