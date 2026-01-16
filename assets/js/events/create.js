new Sortable(document.getElementById('pricesRow'), {
    animation: 150,
    ghostClass: 'ghost',
    chosenClass: 'chosen',
    filter: '.unsortable',
        onMove: (evt) => {
        // se o alvo de inserção é um "unsortable", não permite mover para antes dele
        if (evt.related && evt.related.classList.contains('unsortable') && !evt.willInsertAfter) {
        return false;
        }
    },
    onChoose: function(e) {
        e.target.classList.add('grabbing');
    },
    onUnchoose: function(e) {
        e.target.classList.remove('grabbing');
    },
    onStart: function(e) {
        e.target.classList.add('grabbing');
    },
    onEnd: function(e) {
        e.target.classList.remove('grabbing');
    },
    onMove: function(e) {
        e.target.classList.add('grabbing');
    },
});

$('#addPriceCard').on('click', function() {
    $('#newPriceModal').modal('show');
});

$('.moedaReal').inputmask('decimal', {
    alias: 'numeric',
    groupSeparator: '.',
    radixPoint: ',',
    autoGroup: true,
    digits: 2,
    digitsOptional: false,
    placeholder: '0',
    rightAlign: false,
    removeMaskOnSubmit: true // remove a máscara ao submeter o form
});

// Formulário de nova taxa cria uma nova carta de taxa
$('#newPriceForm').on('submit', function(e) {
    e.preventDefault();
    const name = $('#priceName').val();
    const amount = $('#priceAmount').val();
    const observation = $('#priceObservation').val();

    const newPriceCard = `
    <div role="button" class="col-xxl-4 col-md-6 col-sm-4 col-6 mb-3">
        <div class="card h-100 flex-column">
            <div class="card-body">
                <h5 class="card-title">${name}</h5>
                <h6 class="card-subtitle mb-2 text-muted color-klikit-2">R$ ${amount}</h6>
                <span class="card-subtitle mb-2 text-muted">${observation}</span>
            </div>
        </div>
    </div>
    `;
    $('#pricesRow').append(newPriceCard);
    $('#newPriceModal').modal('hide');
    $('#newPriceForm')[0].reset();
});