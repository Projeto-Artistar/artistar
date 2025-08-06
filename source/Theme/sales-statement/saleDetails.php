<?= $this->layout("base", $layout); ?>

<?= $this->start("css") ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= url("assets/css/sales-statement/saleDetails.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<form id="new-sale-form" class="container pt-3 minimum-height" method="post" action="<?= url("/sales/insert") ?>">
    <div class="row avoid-navbar">
        <div class="col-sm-6 col-12 mb-3 mb-sm-0 px-sm-0">
            <div class="d-flex align-items-baseline gap-3">
                <h1 class="text-center text-sm-start color-nocturne-purple">Venda #<?= $saleInfo['numero']?></h1>
                <h5 class="text-center text-sm-start color-gray"><?= $saleInfo['data_criacao'] ?> às <?= $saleInfo['hora_criacao'] ?></h5>
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
            <div class="col-12 mb-3">
                <label for="payment-select" class="form-label">Método de Pagamento</label>
                <select class="form-select form-select-sm" id="payment-select" name="payment_method" aria-label="Método de pagamento">
                    <option value="dinheiro" selected>Dinheiro</option>
                    <option value="pix">Pix</option>
                    <option value="cartao-debito">Cartão de Débito</option>
                    <option value="cartao-credito">Cartão de Crédito</option>
                    <option value="boleto">Boleto</option>
                    <option value="transferencia">Transferência</option>
                    <option value="outro">Outro</option>
                </select>
            </div>
            <div class="col-12 mb-3">
                <div class="form-check form-switch form-switch-sm">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckPaid" name="paid" value="1" <?= $saleInfo['pago'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="flexSwitchCheckPaid">Pago</label>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="form-check form-switch form-switch-sm">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDelivered" name="delivered" value="1" <?= $saleInfo['entregue'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="flexSwitchCheckDelivered">
                        Entregue <small> (Uma data) </small>
                    </label>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="form-check form-switch form-switch-sm">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckCancelled" name="cancelled" value="1" <?= $saleInfo['cancelada'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="flexSwitchCheckCancelled">Cancelada</label>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-12">
            <div class="row ps-lg-3">
                <div class="col-12 border rounded p-3 mb-3">
                    <h5 class="mb-3">Carrinho</h5>
                        <div class="row selected-products" id="selected">
                            <div class="no-products">Adicione produtos ao carrinho para iniciar a venda.</div>
                        </div>
                    <div class="row">
                        <div class="col-12 text-end">
                            <input type="hidden" id="total-input" name="total_price" value="0">
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
    <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertModalLabel">Finalizar Venda</h5>
                    <button type="button" class="btn-close input-stellar-blue" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você está prestes a finalizar a venda. Por favor, confirme os detalhes abaixo:
                    <div class="my-3">
                        Total da Venda: <span class="color-nocturne-purple">R$<span id="total-price-modal">0,00</span></span>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="payment-select" class="form-label">Método de Pagamento</label>
                            <select class="form-select form-select-sm" id="payment-select" name="payment_method" aria-label="Método de pagamento">
                                <option value="dinheiro" selected>Dinheiro</option>
                                <option value="pix">Pix</option>
                                <option value="cartao-debito">Cartão de Débito</option>
                                <option value="cartao-credito">Cartão de Crédito</option>
                                <option value="boleto">Boleto</option>
                                <option value="transferencia">Transferência</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 col-12">
                            <div class="mb-3 form-check form-switch form-switch-sm">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="paid" checked value="1">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Pedido pago</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="mb-3 form-check form-switch form-switch-sm">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="delivered" checked value="1">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Pedido entregue</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-fog-gray" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-nocturne-purple" id="accept-insert">Finalizar!</button>
                </div>
            </div>
        </div>
    </div>
</form>
<section id="modal-section">
    <!-- Modal for "Sale Inserted!" -->
    <div class="modal fade" id="saleInsertedModal" tabindex="-1" aria-labelledby="saleInsertedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saleInsertedModalLabel">Venda Registrada!</h5>
                </div>
                <div class="modal-body">
                    A venda foi registrada com sucesso! Você pode visualizar os detalhes da venda na seção de vendas.
                </div>
                <div class="modal-footer">
                    <a href="<?= url("sales-statement") ?>" class="btn btn-nocturne-purple">Ver Extrato</a>
                    <a href="<?= url("sales") ?>" class="btn btn-stellar-blue">Nova Venda</a>
                </div>
            </div>
        </div>
    </div>
</section>
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
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
<script>
  const produtos = <?php array_walk_recursive($products,function(&$item){$item=strval($item);}); echo json_encode($products); ?>;
  const selecionados = new Set();
</script>
<script src="<?= url("assets/js/sales-statement/saleDetails.js") ?>"></script>
<script>
    adicionarProdutosEmLote(<?php array_walk_recursive($saleItems,function(&$item){$item=strval($item);}); echo json_encode($saleItems); ?>)
</script>
<?= $this->stop() ?>