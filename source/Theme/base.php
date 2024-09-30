<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?= isset($title) ? $title : 'Artistar' ?></title>
        <meta name="description" content="Descrição da página para melhorar SEO">
        <meta property="og:title" content="<?= isset($title) ? $title : 'Artistar' ?>">
        <meta property="og:description" content="Descrição da página para melhorar SEO">
        <meta property="og:image" content="<?= url("assets/image/logo.svg") ?>">
        <?php
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        ?>
        <meta property="og:url" content="<?= $currentUrl ?>">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?= isset($title) ? $title : 'Artistar' ?>">
        <meta name="twitter:description" content="Descrição da página para melhorar SEO">
        <meta name="twitter:image" content="<?= url("assets/image/logo.svg") ?>">
        <!-- <link rel="stylesheet" href="<?= url("assets/vendors/mdi/css/materialdesignicons.min.css") ?>"> -->
        <link rel="preload" href="<?= url("assets/vendors/fontawesome-6.6.0/css/all.min.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <link rel="preload" href="<?= url("assets/vendors/bootstrap-5.3.3/css/bootstrap.min.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <link rel="preload" href="<?= url("assets/css/artistar.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <link rel="shortcut icon" href="<?= url("assets/image/logo.svg") ?>" />
        <script src="https://code.iconify.design/2/2.2.1/iconify.min.js" defer></script>
        <?= $this->section("css") ?>
    </head>
    <body>
        <?php if(isset($header)) echo $header; ?>
        <?= $this->section("conteudo") ?>
        <?php if(isset($footer)) echo $footer; ?>
    </body>
    <script src="<?= url("assets/vendors/bootstrap-5.3.3/js/bootstrap.bundle.min.js") ?>" defer></script>
    <script src="<?= url("assets/js/jquery-3.6.0.js") ?>" defer></script>
    <?= $this->section("js") ?>
</html>