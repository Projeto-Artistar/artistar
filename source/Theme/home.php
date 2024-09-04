
<?= $this->layout("base", [
    'title' => $title, 
    'header' => $header,
    'footer' => $footer
    ]
); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/home.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
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
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/js/home.js") ?>"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        getEventos();
    });
</script>
<?= $this->stop() ?>
