<?= $this->layout("base", $layout); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="<?= url("assets/css/sales-statement/home.css") ?>">
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
    <div class="row" id="filters">
        <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
            </div>
            <div class="d-flex align-items-end">
                <form id="id-sort-form" class="d-flex align-items-center" method="GET" action="/sales-statement">
                    <select class="form-select form-select-sm input-stellar-blue" id="sort-options" name="sort" onchange="this.form.submit()">
                        <?php foreach ($orderList as $key => $value): ?>
                            <option value="<?= $key ?>" <?= $value['selected'] ? 'selected' : '' ?>><?= $value['label'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 table-responsive-md">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">&nbsp;</th>
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
                    <tr class="link-nocturne-purple">
                        <td class="text-center">
                            <i class="accordion-button collapsed bg-none shadow-none accordion-header"
                                id="heading-<?= $sale['id'] ?>" 
                                class="accordion-button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapse-<?= $sale['id'] ?>"
                                aria-expanded="true" 
                                aria-controls="collapse-<?= $sale['id'] ?>">
                            </i>
                        </td>
                        <th class="align-middle" scope="row" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $sale['id'] ?>">
                            <span class="color-stellar-blue">#<?= $sale['numero'] ?></span>
                        </th>
                        <td class="text-center align-middle" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $sale['id'] ?>">
                            <?= $sale['data_criacao'] ?><br>
                            <small class="color-gray"><?= $sale['hora_criacao'] ?></small>
                        </td>
                        <td class="text-center align-middle" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $sale['id'] ?>">
                            <?= $sale['pago'] ? '<span class="badge text-bg-success rounded-pill p-2">Pago</span>' : '<span class="badge bg-sunshine-yellow color-graphite-gray rounded-pill p-2">Pendente</span>' ?>
                        </td>
                        <td class="text-center align-middle" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $sale['id'] ?>">
                            <?= $sale['entregue'] ? '<span class="badge text-bg-success rounded-pill p-2">Entregue</span>' : '<span class="badge bg-sunshine-yellow color-graphite-gray rounded-pill p-2">Pendente</span>' ?>
                        </td>
                        <td class="text-center align-middle" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $sale['id'] ?>">
                            <?= $sale['pagamento'] ?>
                        </td>
                        <td class="text-center align-middle" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $sale['id'] ?>">
                            <?= $sale['total_itens'] ?><br>
                            <small class="color-gray"><?= $sale['total_unidades'] ?></small>
                        </td>
                        <td class="text-end align-middle" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $sale['id'] ?>">
                            <span class="color-nocturne-purple">R$<?= moedaReal($sale['total_valor']) ?></span><br>
                            <small class="color-gray">R$<?= moedaReal($sale['total_desconto']) ?></small>
                        </td>
                        <td class="text-center align-middle">
                            <div class="d-flex justify-content-sm-end justify-content-between">
                                <!-- 3 dots button with dropdown -->
                                <button type="button" class="btn btn-stellar-blue text-white mx-sm-3 text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="<?= url("sales-statement/sale/{$sale['id']}") ?>">
                                            <i class="fa-solid fa-pen-to-square me-1" aria-hidden="true"></i> Editar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" id="delete-product" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="fa fa-trash me-1" aria-hidden="true"></i> Cancelar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr class="tr-accordion">
                        <td colspan="9" class="p-0 px-2">
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
                                                <td class="text-center align-middle">
                                                    <img src="<?= empty($item['thumbnail']) ? 'assets/image/200x300.png' : $item['thumbnail'] ?>" alt="<?= $item['nome'] ?>" class="img-fluid" style="max-width: 100px; max-height:100px;">
                                                </td>
                                                <td class="align-middle">
                                                    <span class="color-nocturne-purple"><?= $item['nome'] ?></span><br>
                                                    <small class="color-gray"><?= $item['codigo_interno'] ?></small>
                                                </td>
                                                <td class="text-center align-middle"><?= $item['qtd'] ?></td>
                                                <td class="text-end align-middle">
                                                    <span class="color-nocturne-purple">R$<?= $item['desconto'] ?></span><br>
                                                    <small class="color-gray">R$<?= $item['desconto_unitario'] ?>/uni</small>
                                                </td>
                                                <td class="text-end align-middle">
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
    <section class="section-pagination">
        <div class="container">
            <div class="row justify-content-between align-items-center" id="pagination-controls">
                <div class="col-md-6 col-12 d-flex justify-content-md-start justify-content-center mb-2 mb-md-0 px-0">
                    <p class="text-muted">Mostrando <span id="result-count"><?= count($sales)?></span> resultados de <span id="total-count"><?= $totalSales ?></span></p>
                </div>
                <div class="col-md-6 col-12 d-flex justify-content-md-end justify-content-center px-0">
                    <?php if (!empty($sales)): ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                                $url = url("sales-statement").'?';
                                $url .= 'sort=' . urlencode($sort);
                                                    
                            ?>
                            <?php if ($pages['current'] > 1): ?>
                            <li class="page-item">
                                <a class="page-link stellar-blue" href="<?= $url ?>&pagination[offset]=<?= ($pages['current'] - 2) * $pagination['limit'] ?>">Anterior</a>
                            </li>
                            <?php else: ?>
                            <li class="page-item disabled">
                                <span class="page-link stellar-blue">Anterior</span>
                            </li>
                            <?php endif; ?>
                            <!-- Max of 4 pages before and 4 after -->
                            <?php
                            $start = max(1, $pages['current'] - 4);
                            $end = min($pages['total'], $pages['current'] + 4);
                            for ($i = $start; $i <= $end; $i++): ?>
                                <li class="page-item <?= $i == $pages['current'] ? 'active' : 'd-none d-md-flex' ?>" >
                                    <a class="page-link stellar-blue" href="<?= $i == $pages['current'] ? '#' : $url.'&pagination[offset]='.(($i - 1) * $pagination['limit']) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php if ($pages['current'] < $pages['total']): ?>
                            <li class="page-item">
                                <a class="page-link stellar-blue" href="<?= $url ?>&pagination[offset]=<?= $pages['current'] * $pagination['limit'] ?>">Próxima</a>
                            </li>
                            <?php else: ?>
                            <li class="page-item disabled">
                                <span class="page-link stellar-blue">Próxima</span>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</section>
         
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/js/sales-statement/home.js") ?>"></script>
<?= $this->stop() ?>