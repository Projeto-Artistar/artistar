<?= $this->layout("base", $layout); ?>

<?= $this->start("css") ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= url("assets/css/statistics/home.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="container pt-3 mb-3">
    <div class="row avoid-navbar mb-3 d-flex align-items-center">
        <div class="col-lg-4 col-12 px-sm-0 mt-2">
            <h1 class="text-center text-sm-start color-nocturne-purple">Estatísticas</h1>
        </div>
        <div class="col-lg-8 col-12 px-sm-0 text-sm-end text-center mt-2">
            <input 
                type="date" 
                class="form-control d-inline-block w-auto mb-md-0 mb-3" 
                value="<?= $dataReferencia ?>" 
                id="referenceDate" 
                onchange="window.location.href = '<?= url('statistics/?period='.$periodoSelecionado) ?>' + '&date=' + this.value;"
            >
            <div class="btn-group p-2" role="group" aria-label="Período">
                <?php foreach ($periodos as $key => $periodo) {
                    $periodoSelecionado = $_GET['period'] ?? 'day';
                    if ($periodoSelecionado == $key) {
                        echo '<a href="#" class="link-light link-underline-opacity-0 px-2 bg-nocturne-purple rounded-3 text-center align-middle">' . $periodo['name'] . '</a>';
                    } else if (($periodoSelecionado == $periodo['following']) || empty($periodo['following'])) {
                        echo '<a href="'.url('statistics/?period='.$key).'" class="link-nocturne-purple px-2 text-center align-middle">' . $periodo['name'] . '</a>';
                    } else {
                        echo '<a href="'.url('statistics/?period='.$key).'" class="link-nocturne-purple px-2 border-dark-subtle border-0 border-end text-center align-middle">' . $periodo['name'] . '</a>';
                    }

                } ?>
            </div>
        </div>
    </div>
    <div class="row p-4 border rounded mb-3">
        <div class="col-12">
            <div class="row mb-3 d-flex justify-content-between align-items-center">
                    <div class="col-md-6 col-12">
                        <h2 class="color-nocturne-purple">Resumo</h2>
                    </div>
                    <div class="col-md-6 col-12 d-flex justify-content-end align-items-center">
                        <div class="d-flex text-center color-nocturne-purple me-2">Mostrar:</div>
                        <div class="toggle-container shadow-sm" id="toggle">
                            <div class="slider left" id="slider"></div>
                            <div class="toggle-btn active text-dark" data-side="left" id="graphByValue">Valor</div>
                            <div class="toggle-btn text-dark" data-side="right" id="graphByQuantity">Vendas</div>
                        </div>
                    </div>
            </div>
            <div class="row mb-5">
                <div class="col-xl-4 col-12">
                    <div class="row h-100 d-flex align-items-center">
                        <div class="col-12">
                            <h2 class="color-nocturne-purple">R$<?= moedaReal($graphData['totals']['vendas'])?></h2>
                            <h3 class="color-stellar-blue">Faturamento</h3>
                        </div>
                        <div class="col-12">
                            <h2 class="color-nocturne-purple"><?= $graphData['totals']['transacoes'] ?></h2>
                            <h3 class="color-stellar-blue">Total de Vendas</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-12 text-end">
                    <canvas id="myChart" class="w-100 chartjs-render-monitor"></canvas>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-12 text-center d-flex align-items-center justify-content-md-start">
                    <div class="rounded-circle bg-nocturne-purple d-flex align-items-center justify-content-center me-4" style="width: 80px; height: 80px; aspect-ratio: 1;">
                        <i class="fa-solid fa-dollar-sign fa-2x text-white"></i>
                    </div>
                    <div class="text-start">
                        Mais vendido por <span class="fs-5 color-stellar-blue">VALOR</span><br>
                        <span class="fs-4 color-nocturne-purple">R$<?= moedaReal($bestSellers['valor_maior_venda']) ?></span><br>
                        <span class="fs-5 color-lavanda"><?= $bestSellers['produto_maior_valor'] ?></span>
                    </div>
                </div>
                <div class="col-xl-4 col-12 text-center d-flex align-items-center justify-content-md-center">
                    <div class="rounded-circle bg-lavanda d-flex align-items-center justify-content-center me-4" style="width: 80px; height: 80px; aspect-ratio: 1;">
                        <i class="fa-solid fa-chart-line fa-2x text-white"></i>
                    </div>
                    <div class="text-start">
                        <span class="fs-5 color-stellar-blue">Ticket Médio</span><br>
                        <span class="fs-4 color-nocturne-purple">R$<?= moedaReal($graphData['totals']['vendas']/($graphData['totals']['transacoes'] > 0 ? $graphData['totals']['transacoes'] : 1)) ?></span><br>
                    </div>
                </div>
                <div class="col-xl-4 col-12 text-center d-flex align-items-center justify-content-md-end">
                    <div class="rounded-circle bg-stellar-blue d-flex align-items-center justify-content-center me-4" style="width: 80px; height: 80px; aspect-ratio: 1;">
                        <i class="fa-solid fa-box fa-2x text-white"></i>
                    </div>
                    <div class="text-start">
                        Mais vendido por <span class="fs-5 color-stellar-blue">QUANTIDADE</span><br>
                        <span class="fs-4 color-nocturne-purple"><?= empty($bestSellers['quantidade_mais_vendida']) ? 0 : $bestSellers['quantidade_mais_vendida'] ?> Unidades</span><br>
                        <span class="fs-5 color-lavanda"><?= $bestSellers['produto_mais_vendido'] ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="produtos-tab" data-bs-toggle="tab" href="#produtos" role="tab" aria-controls="produtos" aria-selected="true">Produtos</a>
                </li>
                <!-- <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                </li> -->
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="produtos" role="tabpanel" aria-labelledby="produtos-tab">
                    <div class="d-flex justify-content-end">
                        <!-- vertical align center -->
                        <div class="d-flex text-center align-items-center color-nocturne-purple me-2">Ordenar por:</div>
                        <div class="toggle-container shadow-sm my-3" id="toggle-product-order" style="width:250px;">
                            <div class="slider left" id="slider-product-order"></div>
                            <div class="toggle-btn active text-dark" data-side="left" id="productsByRevenue">Faturamento</div>
                            <div class="toggle-btn text-dark" data-side="right" id="productsByQuantity">Quantidade</div>
                        </div>
                    </div>
                    <div class="table-responsive-lg">
                        <table class="table table-striped" id="productsTable">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" scope="col">Posição</th>
                                    <th class="text-center align-middle" scope="col">Produto</th>
                                    <th class="text-center align-middle" scope="col">Quantidade</th>
                                    <th class="text-center align-middle" scope="col">Faturamento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productRanking as $key => $produto): ?>
                                <tr data-quantity="<?= $produto['total_vendido'] ?>" data-revenue="<?= $produto['total_faturado'] ?>" data-product="<?= $produto['produto_id'] ?>">
                                    <th class="text-center align-middle" scope="row" id="position-<?= $produto['produto_id']?>">#<?= $key+1 ?></th>
                                    <td class="text-center align-middle">
                                        <?= $produto['produto_nome'] ?><br>
                                        <small class="color-gray"><?= $produto['produto_codigo_interno'] ?></small>
                                    </td>
                                    <td class="text-center align-middle"><?= $produto['total_vendido'] ?></td>
                                    <td class="text-center align-middle">R$<?= moedaReal($produto['total_faturado']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Profile content</div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">Contact content</div> -->
            </div>
        </div>
    </div>
</section>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="<?= url("assets/vendors/chart.js/Chart.min.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const labels = <?= json_encode(array_values($graphData['labels'])) ?>;
    const totalTransacoes = <?= json_encode(array_values($graphData['values']['total_transacoes'])) ?>;
    const totalVendas = <?= json_encode(array_values($graphData['values']['total_vendas'])) ?>;
</script>
<script src="<?= url("assets/js/statistics/home.js") ?>"></script>
<?= $this->stop() ?>