<header class="navbar navbar-expand-lg navbar bg-white mb-4 fixed-top border-bottom py-3" id="navbar">
    <div class="container-fluid px-3">
        <div class="d-flex">
            <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Logo_TV_2015.svg" alt="mdo" class="bi me-2" width="40" height="32">
            </a>

            <ul class="nav col-12 me-md-auto mb-2 justify-content-center mb-md-0 d-none d-md-flex">
                <li><a href="/login" class="nav-link px-2 link-secondary link-hover">Log-in</a></li>
                <li><a href="#" class="nav-link px-2 link-dark link-hover">Cadastre-se</a></li>
            </ul>
        </div>
        <div id="barra-direita" class="d-flex">
            <form class="col-12 col-md-auto me-md-3 d-none d-md-flex">
                <input type="search" class="form-control pesquisa-superior" placeholder="Pesquisar..." aria-label="Search">
            </form>

            <button data-bs-toggle="offcanvas" style="border:none; background:none;" type="button" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" class="link-hover d-md-none">
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
                <a href="/login" class="nav-link link-secondary">
                    <div class="d-flex align-items-center">
                        <span>Log-in</span>
                    </div>
                </a>
            </li>
            <li class="d-md-none">
                <a href="#" class="nav-link link-dark">
                    <div class="d-flex align-items-center">
                        <span>Cadastre-se</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</nav>