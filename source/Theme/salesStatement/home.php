<?= $this->layout("base", $layout); ?>
<?= $this->start("css") ?>
<style>
    .tr-accordion {
        display: none;
    }

.tr-accordion:has(td > .accordion-collapse.show, .accordion-collapse.collapsing) {
    display: table-row;
}

.hoverable-text {
    cursor: pointer;
}

.hoverable-text:hover {
    text-decoration: underline;
}

</style>
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="container pt-3 minimum-height">
    <style>
    /* Animação customizada para collapse */
    </style>
    <div class="row avoid-navbar">
        <div class="col-sm-6 col-12 mb-3 mb-sm-0">
            <div>
                <h1 class="text-center text-sm-start color-nocturne-purple">Extrato de Vendas</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <form id="search-form" class="d-flex align-items-center mb-4">
                <!-- Input de pesquisa com ícone de lupa -->
                <div class="input-group me-3">
                    <input type="search" class="form-control input-stellar-blue" placeholder="Pesquisar produtos..." name="search" value="">
                    <button class="btn btn-outline-stellar-blue" type="submit">
                        <i class="fas fa-search"></i> 
                    </button>
                </div>
                <a class="btn btn-outline-stellar-blue btn-md" id="filter-button" data-bs-toggle="modal" data-bs-target="#filterModal">
                    Filtros
                </a>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12 table-responsive-md">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="color-nocturne-purple">Venda</span>
                        </th>
                        <th scope="col" class="text-center">
                            <span class="color-nocturne-purple">Data</span>
                        </th>
                        <th scope="col" class="text-center">
                            <span class="color-nocturne-purple">Status do<br>Pagamento</span>
                        </th>
                        <th scope="col" class="text-center">
                            <span class="color-nocturne-purple">Status da<br>Entrega</span>
                        </th>
                        <th scope="col" class="text-center">
                            <span class="color-nocturne-purple">Método de Pagamento</span>
                        </th>
                        <th scope="col" class="text-center">
                            <span class="color-nocturne-purple">Produtos</span><br>
                            <span class="color-nocturne-purple">Unidades</span>
                        </th>
                        <th scope="col" class="text-end">
                            <span class="color-nocturne-purple">Valor</span><br>
                            <span class="color-nocturne-purple">Desconto</span>
                        </th>
                        <th scope="col">&nbsp;</th>
                    </tr>
                </thead>
                <tbody class="accordion accordion-flush">
                    <?php foreach ($sales as $sale): ?>
                    <tr 
                        class="accordion-header link-nocturne-purple" 
                        id="heading-<?= $sale['id'] ?>" 
                        class="accordion-button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapse-<?= $sale['id'] ?>"
                        aria-expanded="true" 
                        aria-controls="collapse-<?= $sale['id'] ?>"
                    >
                        <th scope="row"><span class="color-stellar-blue">#<?= $sale['numero'] ?></span></th>
                        <td class="text-center">
                            <?= $sale['data_criacao'] ?><br>
                            <small class="color-gray"><?= $sale['hora_criacao'] ?></small>
                        </td>
                        <td class="text-center">
                            <?= $sale['pago'] ? '<span class="badge text-bg-success rounded-pill p-2">Pago</span>' : '<span class="badge bg-sunshine-yellow color-graphite-gray rounded-pill p-2">Pendente</span>' ?>
                        </td>
                        <td class="text-center">
                            <?= $sale['entregue'] ? '<span class="badge text-bg-success rounded-pill p-2">Entregue</span>' : '<span class="badge bg-sunshine-yellow color-graphite-gray rounded-pill p-2">Pendente</span>' ?>
                        </td>
                        <td class="text-center"><?= $sale['pagamento'] ?></td>
                        <td class="text-center">
                            <?= $sale['total_itens'] ?><br>
                            <small class="color-gray"><?= $sale['total_unidades'] ?></small>
                        </td>
                        <td class="text-end">
                            <span class="color-nocturne-purple">R$<?= $sale['total_valor'] ?></span><br>
                            <small class="color-gray">R$<?= $sale['total_desconto'] ?></small>
                        </td>
                        <td class="text-center">
                            <i class="accordion-button collapsed bg-none shadow-none" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $sale['id'] ?>" aria-expanded="false" aria-controls="collapse-<?= $sale['id'] ?>"></i>
                        </td>
                    </tr>
                    <tr class="tr-accordion">
                        <td colspan="8" class="p-0 px-2">
                            <div            
                                id="collapse-<?= $sale['id'] ?>" 
                                class="accordion-collapse collapse" 
                                aria-labelledby="heading-<?= $sale['id'] ?>" 
                                data-bs-parent="#accordionExample"
                            >
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th width="10" scope="col">&nbsp;</th>
                                            <th scope="col">
                                                <span class="color-gray">Produto</span>
                                            </th>
                                            <th scope="col" class="text-center">
                                                <span class="color-gray">Qtd.</span>
                                            </th>
                                            <th scope="col" class="text-end">
                                                <span class="color-gray">Desconto</span>
                                            </th>
                                            <th scope="col" class="text-end">
                                                <span class="color-gray">Valor</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items[$sale['id']] as $item): ?>
                                            <tr>
                                                <td>
                                                    <img src="<?= empty($item['thumbnail']) ? 'assets/image/200x300.png' : $item['thumbnail'] ?>" alt="<?= $item['nome'] ?>" class="img-fluid" style="max-width: 100px; max-height:100px;">
                                                </td>
                                                <td>
                                                    <span class="color-nocturne-purple"><?= $item['nome'] ?></span><br>
                                                    <small class="color-gray"><?= $item['codigo_interno'] ?></small>
                                                </td>
                                                <td class="text-center"><?= $item['qtd'] ?></td>
                                                <td class="text-end">
                                                    <span class="color-nocturne-purple">R$<?= $item['desconto'] ?></span><br>
                                                    <small class="color-gray">R$<?= $item['desconto_unitario'] ?>/uni</small>
                                                </td>
                                                <td class="text-end">
                                                    <span class="color-nocturne-purple">R$<?= $item['valor'] ?></span><br>
                                                    <small class="color-gray">R$<?= $item['valor_unitario'] ?>/uni</small>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
         
<?= $this->stop() ?>