<header class="navbar navbar-expand-lg navbar bg-white mb-4 fixed-top border-bottom py-3" id="navbar">
    <div class="container-fluid px-3 bg-white">
        <div class="d-flex">
            <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                <img src="<?= url("assets/image/logo.svg") ?>" alt="mdo" class="bi me-2" width="40" height="32">
            </a>

            <ul class="nav col-12 me-md-auto mb-2 justify-content-center mb-md-0 d-none d-md-flex">
                <li><a href="/begin" class="nav-link px-2 link-kitlit-1 link-hover">Iniciar</a></li>
                <li><a href="/stock" class="nav-link px-2 link-kitlit-1 link-hover">Inventário</a></li>
            </ul>
        </div>
        <div id="barra-direita" class="d-flex">
            <!-- <form class="col-12 col-md-auto me-md-3 d-none d-md-flex" method="GET" action="<?= url('events') ?>">
                <input name="search" type="search" class="form-control pesquisa-superior input-kiklit-2" placeholder="Pesquisar..." aria-label="Search" value="<?= $search ?>">
            </form> -->
            <div class="dropdown">
                <button  style="border:none; background:none;" type="button" class="link-kitlit-2 link-hover" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-bell" style="width:24px; text-align: center;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="px-2"><i class="fa-solid fa-bell" style="width:24px; text-align: center;"></i>Notificações</h6></li>
                    <li><div class="dropdown-divider"></div></li>
                    <div style="max-height: 300px; overflow-y: scroll;">
                        <li><h6 class="px-2">Importantes</h6></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-start" href="#">
                                <img src="/assets/image/logo.svg" alt="Notification Image" class="rounded-circle me-3" width="40" height="40">
                                <div>
                                    <h6 class="mb-1">Novo Pedido Recebido</h6>
                                    <p class="mb-0 text-muted">Você recebeu um novo pedido de João Silva.</p>
                                    <small class="text-muted">12/04/2025 14:30</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-start" href="#">
                                <img src="/assets/image/logo.svg" alt="Notification Image" class="rounded-circle me-3" width="40" height="40">
                                <div>
                                    <h6 class="mb-1">Novo Pedido Recebido</h6>
                                    <p class="mb-0 text-muted">Você recebeu um novo pedido de João Silva.</p>
                                    <small class="text-muted">12/04/2025 14:30</small>
                                </div>
                            </a>
                        </li>
                        <li><div class="dropdown-divider"></div></li>
                        <li><h6 class="px-2">Outras notificações</h6></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-start" href="#">
                                <img src="/assets/image/logo.svg" alt="Notification Image" class="rounded-circle me-3" width="40" height="40">
                                <div>
                                    <h6 class="mb-1">Novo Pedido Recebido</h6>
                                    <p class="mb-0 text-muted">Você recebeu um novo pedido de João Silva.</p>
                                    <small class="text-muted">12/04/2025 14:30</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-start" href="#">
                                <img src="/assets/image/logo.svg" alt="Notification Image" class="rounded-circle me-3" width="40" height="40">
                                <div>
                                    <h6 class="mb-1">Novo Pedido Recebido</h6>
                                    <p class="mb-0 text-muted">Você recebeu um novo pedido de João Silva.</p>
                                    <small class="text-muted">12/04/2025 14:30</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-start" href="#">
                                <img src="/assets/image/logo.svg" alt="Notification Image" class="rounded-circle me-3" width="40" height="40">
                                <div>
                                    <h6 class="mb-1">Novo Pedido Recebido</h6>
                                    <p class="mb-0 text-muted">Você recebeu um novo pedido de João Silva.</p>
                                    <small class="text-muted">12/04/2025 14:30</small>
                                </div>
                            </a>
                        </li>
                    </div>
                </ul>
            </div>
            <button data-bs-toggle="offcanvas" style="border:none; background:none;" type="button" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" class="link-kitlit-2 link-hover">
                <i class="fa-solid fa-bars" style="width:24px; text-align: center;"></i>
            </button>
        </div>
    </div>
</header>

<nav class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header px-4 d-flex justify-content-between align-items-center">
        <a href="/" class="d-flex align-items-center me-md-auto link-dark text-decoration-none">
            <img src="<?= url("assets/image/logo.svg") ?>" alt="mdo" class="bi me-2" width="40" height="32">
        </a>
        <button type="button" class="btn-close text-reset input-kiklit-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        
    </div>
        <div class="offcanvas-body d-flex flex-column justify-content-between">
        <ul class="nav nav-pills flex-column mb-auto">
            <!-- <li class="d-md-none">
                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                    <input type="search" class="form-control" placeholder="Pesquisar..." aria-label="Search">
                </form>
            </li> -->
            <li class="d-md-none">
                <a href="#" class="nav-link color-klikit-1">
                    <div class="d-flex align-items-center">
                        <span>Iniciar</span>
                    </div>
                </a>
            </li>
            <li class="d-md-none">
                <a href="<?= url('stock')?>" class="nav-link color-klikit-1">
                    <div class="d-flex align-items-center">
                        <span>Inventário</span>
                    </div>
                </a>
            </li>
            <li class="d-md-none border-top my-3"></li>
            <li>
                <a href="#" class="nav-link link-dark d-block link-hover">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-dollar-sign bi me-4" style="width:24px; text-align: center;"></i>
                        <span>Vendas</span>
                    </div>
                </a>
            </li>
            <li>
               <a href="#" class="nav-link link-dark link-hover">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-ranking-star bi me-4" style="width:24px; text-align: center;"></i>
                        <span>Estatísticas</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link link-dark d-block link-hover">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-plus bi me-4" style="width:24px; text-align: center;"></i>
                        <span>Inscrições</span>
                    </div>
                </a>
            </li>

            <li class="border-top my-3"></li>
            <li>
                <a href="#" class="nav-link link-dark link-hover">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-ranking-star bi me-4" style="width:24px; text-align: center;"></i>
                        <span>Minha Loja</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link link-dark link-hover">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-ranking-star bi me-4" style="width:24px; text-align: center;"></i>
                        <span>Meus Ajudantes</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link link-dark link-hover">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-ranking-star bi me-4" style="width:24px; text-align: center;"></i>
                        <span>Lojas que eu Ajudo</span>
                    </div>
                </a>
            </li>
            

            <li class="border-top my-3"></li>
            <li>
                <a href="#" class="nav-link link-dark link-hover">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-gear bi me-4" style="width:24px; text-align: center;"></i>
                        <span>Configurações</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?= url("auth/new-password")?>" class="nav-link link-dark link-hover">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-lock bi me-4" style="width:24px; text-align: center;"></i>
                        <span>Trocar Senha</span>
                    </div>
                </a>
            </li>
        </ul>
        <div class="border-top my-3"></div>
        <div class="d-flex justify-content-between align-items-center">
            <div href="#" class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center px-2">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-4">
                    <span><strong><?= $_SESSION['artistar']['user']['nome_completo'] ?></strong></span>
                </div>
            </div>
            <button style="border:none; background:none;" onclick="window.location.href='/auth/logout';" class="link-hover"><i class="fa-solid fa-right-from-bracket px-2"></i></button>
        </div>
    </div>
</nav>