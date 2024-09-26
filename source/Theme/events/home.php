<?= $this->layout("base", [
    'title' => $title, 
    'header' => $header,
    'footer' => $footer
    ]
); ?>

<?= $this->start("css") ?>
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="container minimum-height">
</section>

<?= $this->stop() ?>

<?= $this->start("js") ?>
<?= $this->stop() ?>