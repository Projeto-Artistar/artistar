<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kitbase</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= url("assets/vendors/mdi/css/materialdesignicons.min.css") ?>">
    <link rel="stylesheet" href="<?= url("assets/vendors/flag-icon-css/css/flag-icon.min.css") ?>">
    <link rel="stylesheet" href="<?= url("assets/vendors/css/vendor.bundle.base.css") ?>">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End Plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?= url("assets/css/style.css") ?>">
    <link rel="stylesheet" href="<?= url("assets/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= url("assets/bootstrap-icons/bootstrap-icons.css") ?>">
    <link rel="stylesheet" href="<?= url("assets/css/bsstyle.css") ?>">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?= url("assets/images/logo-mini.png") ?>" />

    <style>
        :root {
            --detalhes: <?= DETALHES ?>;
            --fundoIcone: <?= FUNDOICONE ?>;
            --iconeCor: <?= PRINCIPAL ?>;
            --fundoNavHover: <?= FUNDONAVHOVER ?>;
        }

        .table th, .table td {
            white-space: inherit;
        }

        /* .btn-primary {
            color: var(--detalhes) !important;
            background-color: var(--iconeCor) !important;
            border-color: var(--iconeCor) !important;
        }
        .btn-primary:hover {
            color: var(--iconeCor) !important;
            background-color: var(--detalhes) !important;
            border-color: var(--detalhes) !important;
        } */

    </style>
    

    <?= $this->section("css") ?>


    <script>
        function urlHost(url){
            return window.location.origin+url
        }
    </script>


</head>
<body class="sidebar-icon-only">
<div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <?= $navBar ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <?= $sideBar ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <?= $this->section("conteudo") ?>

            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
            <footer class="footer">
                <div class="footer-inner-wraper">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © backsite.com.br 2024</span>
                    </div>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<script src="<?= url("assets/js/bootstrap.min.js") ?>"></script>
<script src="<?= url("assets/js/bootstrap.bundle.min.js") ?>"></script>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="<?= url("assets/vendors/js/vendor.bundle.base.js") ?>"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="<?= url("assets/vendors/chart.js/Chart.min.js") ?>"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="<?= url("assets/js/off-canvas.js") ?>"></script>
<script src="<?= url("assets/js/hoverable-collapse.js") ?>"></script>
<script src="<?= url("assets/js/misc.js") ?>"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="<?= url("assets/js/chart.js") ?>"></script>
<!-- End custom js for this page -->
<?= $this->section("js") ?>

</body>
</html>