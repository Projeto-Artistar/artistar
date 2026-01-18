<?= $this->layout("base", $layout); ?>

<?= $this->start("css") ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css">
<link rel="stylesheet" rel="preload" href="<?= url("assets/css/events/details.css") ?>">
<style>
#pricesRow .col-xxl-4,
#pricesRow .col-lg-3:not(.unsortable) {
  cursor: grab;
}

.grabbing * {
    cursor: grabbing !important;
}

.grid-square:active {
    cursor: grabbing!important;/* fighting on all fronts */
}
</style>
<?= $this->stop() ?>

<?= $this->start("conteudo") ?>
<section class="content avoid-navbar pt-4">
    <form id="eventForm">
        <section class="container">
            <div class="row mb-3">
                <div>
                    <h1 class="text-center text-sm-start color-nocturne-purple">Novo Evento</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-12 mb-3">
                    <label for="filter-name" class="form-label">*Nome</label>
                    <input class="form-control input-stellar-blue" name="eventTitle" type="text" id="eventTitle" placeholder="Nome do Evento" required> 
                </div>
                <div class="col-md-4 col-12 mb-3">
                    <label for="filter-name" class="form-label">Produtor</label>
                    <input class="form-control input-stellar-blue" name="eventProductor" type="text" id="eventProductor" placeholder="Nome do Produtor" required> 
                </div>
            </div>
            <h4 class="mb-3">Endereço</h4>
            <div class="row">
                <div class="col-md-2 col-12 mb-3">
                    <label for="filter-name" class="form-label">CEP</label>
                    <input class="form-control input-stellar-blue" name="eventCep" type="text" id="eventCep" placeholder="CEP" required> 
                </div>
                <div class="col-md-3 col-12 mb-3">
                    <label for="filter-name" class="form-label">UF</label>
                    <select class="form-select input-stellar-blue" name="eventState" id="eventState" required>
                        <option value="" selected disabled>Selecione a UF</option>
                    </select>
                </div>
                <div class="col-md-4 col-12 mb-3">
                    <label for="filter-name" class="form-label">Cidade</label>
                    <select class="form-select input-stellar-blue" name="eventCity" id="eventCity" required>
                        <option value="" selected disabled>Selecione a Cidade</option>
                    </select>
                </div>
                 <div class="col-md-3 col-12 mb-3">
                    <label for="filter-name" class="form-label">Bairro</label>
                    <input class="form-control input-stellar-blue" name="eventNeighborhood" type="text" id="eventNeighborhood" placeholder="Bairro" required> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-12 mb-3">
                    <label for="filter-name" class="form-label">Endereço</label>
                    <input class="form-control input-stellar-blue" name="eventAddress" type="text" id="eventAddress" placeholder="Endereço" required> 
                </div>
                <div class="col-md-3 col-12 mb-3">
                    <label for="filter-name" class="form-label">Número</label>
                    <input class="form-control input-stellar-blue" name="eventNumber" type="text" id="eventNumber" placeholder="Número" required> 
                </div>
                <div class="col-md-3 col-12 mb-3">
                    <label for="filter-name" class="form-label">Complemento</label>
                    <input class="form-control input-stellar-blue" name="eventComplement" type="text" id="eventComplement" placeholder="Complemento" required> 
                </div>
            </div>
            <div class="row" id="row-dpi" >
                <div class="col-md-6 mb-3" id="column-description">
                    <h4 class="mb-3">Descrição</h4>
                    <section id="eventDescription"><textarea class="form-control input-stellar-blue" name="eventDescription" rows="13" resizable></textarea></section>
                </div>
                <div class="col-md-6" id="column-pi">
                    <h4 class="mb-3">Datas</h4>
                    <div class="row align-items-stretch" id="daysRow">
                        <div role="button" class="col-xxl-4 col-md-6 col-12 mb-3 text-decoration-none" id="addDateCard">
                            <div class="card text-center h-100 card-hover bg-stellar-blue color-snow-white border-0 flex-column">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <i class="fas fa-plus fa-2x m-3"></i>
                                    <h6 class="card-title">Nova Data</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="my-3">Taxas e Custos</h4>
                    <div class="row align-items-stretch" id="pricesRow">
                        <div role="button" class="col-xxl-4 col-md-6 col-12 mb-3 text-decoration-none unsortable" id="addPriceCard">
                            <div class="card text-center h-100 card-hover bg-stellar-blue color-snow-white border-0 flex-column">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <i class="fas fa-plus fa-2x m-3"></i>
                                    <h6 class="card-title">Novo Evento</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php if (!empty($event['contacts'])) {?>
                    <div class="col-md-6" id="contactsColumn">
                        <h4 class="my-3">Contatos</h4>
                        <ul class="list-unstyled" id="contactsList">
                            <?php foreach($event['contacts'] as $contact) {?>
                                <li>
                                    <i class="<?= $contact['icon'] ?>"></i> <span class="color-klikit-2 mx-2"><?= $contact['value']?></span>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <?php if (!empty($event['socialMedia'])) {?>
                    <div class="col-md-6" id="socialMediaColumn">
                        <h4 class="my-3">Redes Sociais</h4>
                        <ul class="list-unstyled" id="socialMediaList">
                            <?php foreach($event['socialMedia'] as $socialMedia) {?>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="<?= $socialMedia['icon']?>"></i> <a class="link-kitlit-1 mx-2" href="<?= $socialMedia['url']?>" target="_blank"><?= $socialMedia['name']?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </section>
        <?php if (!empty($event['address'])) {?>
        <section id="section-map" class="bg-klikit-5 py-3">
            <div class="container">
                <div class="row mb-3" id="row-map">
                    <h4 class="mb-3">Local</h4>
                    <div id="mapa">
                        <iframe frameborder='0' title="Google Maps do local do evento" style='border:0; width: 100%; min-height: 500px;' src='https://www.google.com/maps?q=<?= urlencode($event['address'])?>&output=embed' allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </section>
        <?php } ?>
    </section>
</form>
<section id="datesModal">
    <div class="modal fade" id="newDateModal" tabindex="-1" role="dialog" aria-labelledby="newDateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newDateModalLabel">Nova Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newDateForm">
                        <div class="mb-3">
                            <label for="dateDay" class="form-label">Dia</label>
                            <input type="date" class="form-control input-stellar-blue" id="dateDay" required>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 mb-3">
                                <label for="dateTime" class="form-label">Hora Inicial</label>
                                <input type="time" class="form-control input-stellar-blue" id="dateTime" required>
                            </div>
                            <div class="col-xl-6 mb-3">
                                <label for="dateDeadline" class="form-label">Hora Final</label>
                                <input type="time" class="form-control input-stellar-blue" id="dateEndTime">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="dateObservation" class="form-label">Observação</label>
                            <textarea class="form-control input-stellar-blue" id="dateObservation" rows="3" resizable></textarea>
                        </div>
                        <button type="submit" class="btn btn-stellar-blue float-end">Adicionar Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="pricesModal">
    <div class="modal fade" id="newPriceModal" tabindex="-1" role="dialog" aria-labelledby="newPriceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newPriceModalLabel">Nova Taxa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newPriceForm">
                        <div class="mb-3">
                            <label for="priceName" class="form-label">Nome da Taxa</label>
                            <input type="text" class="form-control input-stellar-blue" id="priceName" required>
                        </div>
                        <div class="mb-3">
                            <label for="priceAmount" class="form-label">Valor</label>
                            <input type="text" class="form-control moedaReal input-stellar-blue" id="priceAmount" required value="0,00">
                        </div>
                        <div class="mb-3">
                            <label for="priceObservation" class="form-label">Observação</label>
                            <textarea class="form-control input-stellar-blue" id="priceObservation" rows="3" resizable></textarea>
                        </div>
                        <input type="hidden" id="priceOrder" value="">
                        <button type="submit" class="btn btn-stellar-blue float-end">Adicionar Taxa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->stop() ?>

<?= $this->start("js") ?>
<!-- Outros scripts -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/pt-br.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
<script src="<?= url("assets/js/events/create.js") ?>"></script>
<?= $this->stop() ?>