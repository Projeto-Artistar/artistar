<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="/<?= isset($homenPath) && !empty($homenPath) ? $homenPath : 'nucleo' ?>">
            <img style="height: auto;width: 10%;" src="<?= url("assets/images/logo-mini.png") ?>" alt="logo" />
            <img src="<?= url("assets/images/logo.png") ?>" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="/<?= isset($homenPath) && !empty($homenPath) ? $homenPath : 'nucleo' ?>"><img src="<?= url("assets/images/logo-mini.png") ?>" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>