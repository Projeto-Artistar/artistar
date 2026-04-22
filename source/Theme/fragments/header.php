<header class="navbar navbar-expand-lg navbar bg-white mb-4 fixed-top border-bottom py-3" id="navbar">
    <div class="container-fluid px-3 bg-white">
        <div class="d-flex">
            <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                <img src="<?= url("assets/image/logo.png") ?>" alt="mdo" class="bi me-2 logo-artistar" width="100">
            </a>
        </div>
        <div id="barra-direita" class="d-flex">
            <!-- <form class="col-12 col-md-auto me-md-3 d-none d-md-flex" method="GET" action="<?= url('events') ?>">
                <input name="search" type="search" class="form-control pesquisa-superior input-kiklit-2" placeholder="Pesquisar..." aria-label="Search" value="<?= $search ?>">
            </form> -->
            <?php if (false): ?>
            <div class="dropdown language-selector me-2 d-flex align-items-center">
                <button class="btn language-selector-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Selecionar idioma">
                    <img src="<?= url('assets/image/flags/' . $languageOptions[$activeLanguage]['flag']) ?>" alt="" class="language-flag me-2">
                    <span class="d-none d-sm-inline me-2"><?= $languageOptions[$activeLanguage]['label'] ?></span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end language-selector-menu shadow-sm">
                    <?php foreach ($languageOptions as $langCode => $langData): 
                        $newUrl = $urlWithoutLang .'&lang=' . $langCode;
                    ?>
                    <li>
                        <a class="dropdown-item d-flex align-items-center<?= $activeLanguage === $langCode ? ' active' : '' ?>" href="<?= htmlspecialchars($newUrl, ENT_QUOTES, 'UTF-8') ?>">
                            <img src="<?= url('assets/image/flags/' . $langData['flag']) ?>" alt="" class="language-flag me-2">
                            <span><?= $langData['label'] ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            <div>
                <ul class="nav col-12 me-md-auto mb-2 justify-content-center mb-md-0 d-none d-md-flex">
                    <li><a href="<?= url('login')?>" class="nav-link px-2 link-stellar-blue"><?= $translator->translate('Login') ?></a></li>
                    <li><a href="<?= url('register')?>" class="nav-link px-2 link-stellar-blue"><?= $translator->translate('Cadastre-se') ?></a></li>
                </ul>
                <button data-bs-toggle="offcanvas" style="border:none; background:none;" type="button" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" class="link-hover d-md-none">
                    <i class="fa-solid fa-bars" style="width:24px; text-align: center;"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<nav class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header px-4 d-flex justify-content-between align-items-center">
            <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                <img src="<?= url("assets/image/logo.png") ?>" alt="mdo" class="bi me-2 logo-artistar" width="100">
            </a>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        
    </div>
        <div class="offcanvas-body d-flex flex-column justify-content-between">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="d-md-none">
                <a href="<?= url('login') ?>" class="nav-link link-stellar-blue">
                    <div class="d-flex align-items-center">
                        <span><?= $translator->translate('Login') ?></span>
                    </div>
                </a>
            </li>
            <li class="d-md-none">
                <a href="<?= url('register') ?>" class="nav-link link-stellar-blue">
                    <div class="d-flex align-items-center">
                        <span><?= $translator->translate('Cadastre-se') ?></span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</nav>