<?= $this->layout("base", $layout); ?>

<?= $this->start("css") ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= url("assets/css/sales/home.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<form id="product-details-form" class="container pt-3 minimum-height">
    <div class="row avoid-navbar">
        <div class="col-sm-6 col-12 mb-3 mb-sm-0 px-sm-0">
            <div>
                <h1 class="text-center text-sm-start">Nova Venda</h1>
            </div>
        </div>
    </div>
    <div class="row px-sm-0 p-3">
        <div class="col-lg-4 border rounded col-12 mb-3">
            <div class="row p-3">
                <input type="text" id="search" placeholder="Digite o nome do produto...">
                <div id="suggestions"></div>
            </div>
        </div>
        <div class="col-lg-8 col-12 mb-lg-3">
            <div class="row ps-lg-3">
                <div class="col-12 border rounded p-3 mb-3">
                    <div class="row">
                        <div id="selected" class="selected-products"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<section id="toasts-section">
    <div class="toast align-items-center text-light bg-success border-0 toast-sucesso m-3" id="myToast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
        <div class="toast-header">
            <strong class="me-auto" id="toastTitle">Título</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastBody">
            Mensagem do toast.
        </div>
    </div>
</section>
<section class="modal-form">
    <div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="duplicateModalLabel">Duplicar</h5>
                    <button type="button" class="btn-close input-stellar-blue" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você tem certeza que deseja duplicar o produto <strong>""</strong> com o nome <strong>"Cópia - ""</strong>?<br>
                    Esta ação criará uma cópia do produto com todas as informações, exceto o ID do produto, que será novo.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-fog-gray" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-stellar-blue" id="accept-duplicate">Duplicar!</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Excluir</h5>
                    <button type="button" class="btn-close input-stellar-blue" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você tem certeza que deseja excluir o produto <strong>""</strong>?<br>
                    Esta ação não poderá ser desfeita.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-fog-gray" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-nocturne-purple" id="accept-delete">Excluir!</button>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
<script>
  const produtos = <?= json_encode($products); ?>
</script>
  <script src="<?= url("assets/js/sales/home.js") ?>"></script>
<?= $this->stop() ?>