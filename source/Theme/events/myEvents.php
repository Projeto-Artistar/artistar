<?= $this->layout("base", $layout); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css">
<link rel="stylesheet" href="<?= url("assets/css/events/myEvents.css") ?>">
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="minimum-height avoid-navbar">
    <section class="section-banner">
        <div class="container">
            <div class="row py-5">
                <div class="col-xl-6 col-12">
                    <div class="row">
                        <a class="h1 mb-3 link-nocturne-purple" href="<?= url('events/my-events') ?>">Meus Eventos</a>
                        <p class="fs-5">Veja em que situação estão suas inscrições em eventos!</p>
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <span class="dot bg-cotton-candy me-2 rounded-5" style="height:10px; width:10px;"></span>Pendentes (<?= $totals['total_pendente'] ?>)
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="dot bg-stellar-blue me-2 rounded-5" style="height:10px; width:10px;"></span>Realizadas (<?= $totals['total_realizada'] ?>)
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="dot bg-nocturne-purple me-2 rounded-5" style="height:10px; width:10px;"></span>Aprovadas (<?= $totals['total_aprovada'] ?>)
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <span class="dot bg-gray me-2 rounded-5" style="height:10px; width:10px;"></span>Finalizados (<?= $totals['total_finalizados'] ?>)
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <div class="row">
                        <span class="h4 color-gray">Eventos de Hoje</span>
                    </div>
                    <?php foreach ($todayEvents as $event): ?>
                        <div class="row mb-3 p-3">
                            <div class="lembrete-evento">
                                <span class="h5">
                                    <a class="link-nocturne-purple" href="<?= url('events/id/'.$event['evento_id']) ?>"><?= $event['evento_nome'] ?></a>
                                </span>
                                <br>
                                <span class="text-muted">
                                    <?= $event['hora_inicial'].' - '.$event['hora_final'] ?>
                                </span>
                                <br>
                                <!-- colocar tooltip -->
                                <span class="obs-lembrete" data-toggle="tooltip" data-placement="top" title="<?= nl2br($event['evento_data_observacao']) ?>">
                                    <?= nl2br($event['evento_data_observacao']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>     
                </div>
                <div class="col-xl-6 col-12">
                    <div id="calendar"></div>
                </div>
            </div>
            <hr>
        </div>    
    </section>
    <section class="section-eventos">
        <div class="container">
            <div class="pb-5">
                <span class="h2">Listagem</span>
            </div>
            <div class="row lista-eventos" id="eventos">
                <a class="col-lg-3 col-md-4 col-sm-6 mb-4 text-decoration-none" href="<?= url('events/create') ?>">
                    <div class="card text-center h-100 card-hover bg-stellar-blue color-snow-white border-0">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <i class="fas fa-plus fa-2x mb-3"></i>
                            <h6 class="card-title">Novo Evento</h6>
                        </div>
                    </div>
                </a>
                <?php foreach ($events as $event): ?>
                <a class="col-lg-3 col-md-4 col-sm-6 mb-4 evento" href="<?= url('events/id/'.$event['evento_id']) ?>">
                    <div class="card">
                        <img class="card-img-top" src="<?= !empty($event['thumbnail']) ? $event['thumbnail'] : '/assets/image/logo.png' ?>" alt="Card image cap">
                        <span class="image-overlay"><?= $event['data_inicial'].($event['evento_data_inicial'] != $event['evento_data_final'] ? ' - '.$event['data_final'] : '') ?></span>
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between align-items-center">
                                <span class="color-stellar-blue nome-produto"><?= $event['evento_nome'] ?></span>
                                <?php 
                                    switch ($event['status']) {
                                        case 'finalizado':
                                            $badgeClass = 'bg-secondary';
                                            $badgeText = 'Finalizado';
                                            break;
                                        case 'pendente':
                                            $badgeClass = 'bg-cotton-candy';
                                            $badgeText = 'Pendente';
                                            break;
                                        case 'realizada':
                                            $badgeClass = 'bg-stellar-blue';
                                            $badgeText = 'Realizada';
                                            break;
                                        case 'aprovada':
                                            $badgeClass = 'bg-nocturne-purple';
                                            $badgeText = 'Aprovada';
                                            break;
                                        default:
                                            $badgeClass = 'bg-gray';
                                            $badgeText = 'Desconhecido';
                                    }
                                    echo "<span class='badge $badgeClass'>$badgeText</span>";
                                ?>
                            </h5>
                            <p class="card-text descricao-evento">
                                <?= $event['evento_subtitulo'] ?>
                            </p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</section>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/pt-br.global.min.js"></script>
<script>
    <?php 
        $jsonEvents = [];
        foreach ($events as $event) {
            $jsonEvents[] = [
                'title' => $event['evento_nome'],
                'start' => $event['evento_data_inicial'],
                'end' => $event['evento_data_inicial'] != $event['evento_data_final'] ? date('Y-m-d', strtotime($event['evento_data_final'].' +1 day')) : null,
                'url' => url('events/id/'.$event['evento_id']),
                'classNames' => ['calendario-evento', 'evento-'.$event['status']]
            ];
        }
        echo "const events = ".json_encode($jsonEvents).";";
    ?>
</script>
<script src="<?= url("assets/js/events/myEvents.js") ?>"></script>

<?= $this->stop() ?>