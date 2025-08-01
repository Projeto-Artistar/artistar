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
                <input type="text" id="search" class="form-control" placeholder="Digite o nome do produto...">
                <div id="suggestions" class="list-group rounded mt-1 shadow-sm" style="max-height: 200px; overflow-y: auto;">
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-12">
            <div class="row ps-lg-3">
                <div class="col-12 border rounded p-3 mb-3">
                    <h5 class="mb-3">Carrinho</h5>
                    <form id="product-form">
                        <div class="row selected-products" id="selected">
                            <div class="no-products">Adicione produtos ao carrinho para iniciar a venda.</div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12 text-end">
                            Total: <span class="color-nocturne-purple">R$<span id="total-price" >0,00</span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-end pe-0">
                    <button type="button" class="btn btn-stellar-blue" id="finalizar-venda">Finalizar Venda</button>
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
  const produtos = <?php array_walk_recursive($products,function(&$item){$item=strval($item);}); echo json_encode($products); ?>
</script>
  <script src="<?= url("assets/js/sales/home.js") ?>"></script>
<?= $this->stop() ?>