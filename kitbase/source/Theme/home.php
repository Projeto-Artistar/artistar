<?= $this->layout("layoutHome", [ "sideBar" => $sideBar, "navBar" => $navBar ] ); ?>

<?= $this->start("conteudo") ?>

    <div class="page-header">
        <h3 class="page-title"> Página </h3>
        <p>Caminho » de » Migalhas</p>
    </div>
    <div class="row">
        <p>Bem limpo :)</p>
    </div>

<?= $this->stop() ?>

<?= $this->start("css") ?>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<?= $this->stop() ?>