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

// DATAS

$('#addDateCard').on('click', function() {
    $('#newDateModal').modal('show');
});

$('#newDateForm').on('submit', function(e) {
    e.preventDefault();
    var day = $('#dateDay').val();
    var time = $('#dateTime').val();
    var endTime = $('#dateEndTime').val();
    var observation = $('#dateObservation').val();

    //Pegar a data e formatar para dd/mm/yyyy
    //Pegar também qual o dia da semana é essa data
    //E formatar as horas para hh:mm
    var dateObj = new Date(day);
    var options = { weekday: 'long', year: 'numeric', month: '2-digit', day: '2-digit' };
    var formattedDay = dateObj.toLocaleDateString('pt-BR', options);
    var weekday = formattedDay.charAt(0).toUpperCase() + formattedDay.slice(1).split(',')[0];
    formattedDay = formattedDay.split(',')[1].trim();
    var formattedTime = time.slice(0, 5);
    var formattedEndTime = endTime.slice(0, 5);


    $('#daysRow').append(`
    <div class="col-xxl-4 col-md-6 col-12 mb-3" data-date="${day}">
        <div class="card h-100 flex-column position-relative">
            <div class="p-3 pb-2">
                <h5 class="mb-0">${weekday}</h5>
                <button type="button" class="btn-close btn-close-card p-3" style="position: absolute; top: 0.1rem; right: 0;" aria-label="Close"></button>
            </div>
            <div class="card-body pt-0">
                <h5 class="card-title">${formattedDay}</h5>
                <span class="card-subtitle mb-2 text-muted">${formattedTime} - ${formattedEndTime}</span>
            </div>
        </div>
        <input type="hidden" name="dates[${day}][day]" value="${day}">
        <input type="hidden" name="dates[${day}][time]" value="${time}">
        <input type="hidden" name="dates[${day}][endTime]" value="${endTime}">
        <input type="hidden" name="dates[${day}][observation]" value="${observation}">
    </div>
    `);
    $('#newDateModal').modal('hide');
    $('#newDateForm')[0].reset();
});

// TAXAS E CUSTOS

$('#addPriceCard').on('click', function() {
    $('#newPriceForm')[0].reset();
    $('#priceAmount').val('0,00');
    $('#priceOrder').val('');
    $('#newPriceModal').modal('show');
});

// Formulário de nova taxa cria uma nova carta de taxa
$('#newPriceForm').on('submit', function(e) {
    e.preventDefault();
    var name = $('#priceName').val();
    var amount = $('#priceAmount').val();
    var observation = $('#priceObservation').val();
    if ($('#priceOrder').val()) {
        var order = $('#priceOrder').val();
        $('input[name="prices[' + order + '][name]"]').val(name);
        $('.card-title[data-price="' + order + '"]').text(name);
        $('input[name="prices[' + order + '][amount]"]').val(amount);
        $('.card-subtitle[data-price="' + order + '"]').text('R$ ' + amount);
        $('input[name="prices[' + order + '][observation]"]').val(observation);
    } else {
        var order = $('#pricesRow .card-price-item').length + 1;
        while ($('div.card-price-item[data-price="' + order + '"]').length) order++;
        var newPriceCard = `
            <div class="col-xxl-4 col-md-6 col-12 mb-3 card-price-item" data-price="${order}">
                <div class="card h-100 flex-column position-relative">
                    <div class="d-flex justify-content-between align-items-center p-3 pb-2">
                        <i class="fa-solid fa-arrows-up-down-left-right color-cloud-gray"></i>
                        <button type="button" class="btn-close btn-close-card" aria-label="Close"></button>
                    </div>
                    <div class="card-body d-flex flex-column pt-0">
                        <div class="flex-grow-1">
                            <h5 class="card-title" data-price="${order}">${name}</h5>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted color-klikit-2" data-price="${order}">R$ ${amount}</h6>
                        <span class="btn btn-stellar-blue d-flex align-items-center mt-3 edit-price" data-price="${order}" >
                            <i class="fa-solid fa-pen-to-square ms-2 me-3" style="text-align: center;"></i> Editar
                        </span>
                    </div>
                </div>
                <input type="hidden" name="prices[${order}][name]" value="${name}">
                <input type="hidden" name="prices[${order}][amount]" value="${amount}">
                <input type="hidden" name="prices[${order}][observation]" value="${observation}">
                <input type="hidden" name="prices[${order}][order]" value="${order}">
            </div>
        `;
        $('#pricesRow').append(newPriceCard);
    }
    $('#newPriceModal').modal('hide');
    $('#newPriceForm')[0].reset();
    $('#priceAmount').val('0,00');
    $('#priceOrder').val('');
});

$(document).on('click', '.btn-close-card', function(e) {
    e.preventDefault();
    $(this).closest('.card-price-item').fadeOut(300, function() {
        $(this).remove();
    });
});

$(document).on('click', '.edit-price', function(e) {
    e.preventDefault();
    var priceId = $(this).data('price');
    var name = $('input[name="prices[' + priceId + '][name]"]').val();
    var amount = $('input[name="prices[' + priceId + '][amount]"]').val();
    var observation = $('input[name="prices[' + priceId + '][observation]"]').val();
    console.log(priceId, name, amount, observation);
    $('#priceOrder').val(priceId);
    $('#priceName').val(name);
    $('#priceAmount').val(amount);
    $('#priceObservation').val(observation);
    $('#newPriceModal').modal('show');
});

new Sortable(document.getElementById('pricesRow'), {
    animation: 150,
    ghostClass: 'ghost',
    chosenClass: 'chosen',
    filter: '.unsortable',
    onMove: (evt) => {
        evt.target.classList.add('grabbing');
        return !((evt.related && evt.related.classList.contains('unsortable') && !evt.willInsertAfter));
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
    }
});

async function searchCEP() {
    var cep = document.getElementById('eventCep').value.replace(/\D/g, '');
    $.ajax({
        url: `https://viacep.com.br/ws/${cep}/json/`,
        type: 'GET',
        success: async function(response) {
            console.log(response);
            if (!response.erro) {
                document.getElementById('eventAddress').value = response.logradouro;
                document.getElementById('eventNeighborhood').value = response.bairro;
                document.getElementById('eventState').value = response.uf;
                await searchCities(response.uf, response.localidade);
            // } else {
            //     document.getElementById('eventAddress').value = response.logradouro;
            //     document.getElementById('eventNeighborhood').value = response.bairro;
            //     document.getElementById('eventState').value = response.uf;
            //     await searchCities(response.uf);
            //     document.getElementById('eventCity').value = response.localidade;
            }
        },
        error: async function(error) {
            console.log('An error occurred');
        }
    });
}

document.getElementById('eventCep').addEventListener('blur', async function() {
    await searchCEP();
});

async function searchStates() {
    var select = document.getElementById('eventState');
    select.innerHTML = '<option value="">Carregando...</option>';
    $.ajax({
        url: '/apis/states',
        type: 'POST',
        success: async function(response) {
            response = JSON.parse(response);
            if (response.code == 200) {
                select.innerHTML = '';
                states = response.data.states;
                select.innerHTML = '<option value="">Selecione um estado</option>';
                states.forEach(state => {          
                    var option = document.createElement('option');
                    option.value = state.sigla;
                    option.text = state.nome;
                    select.appendChild(option);
                });
            }
        },
        error: async function(error) {
            console.log('An error occurred');
        }
    });
}

searchStates();

async function searchCities(uf, defaultCity = '') {
    var select = document.getElementById('eventCity');
    select.innerHTML = '<option value="">Carregando...</option>';
    $.ajax({
        url: '/apis/cities',
        type: 'POST',
        data: {uf: uf},
        success: async function(response) {
            response = JSON.parse(response);
            if (response.code == 200) {
                select.innerHTML = '';
                cities = response.data.cities;
                select.innerHTML = '<option value="">Selecione uma cidade</option>';
                cities.forEach(city => {          
                    var option = document.createElement('option');
                    if (city.nome == defaultCity) option.selected = true;
                    option.value = city.nome;
                    option.text = city.nome;
                    select.appendChild(option);
                });
            }
        },
        error: async function(error) {
            console.log('An error occurred');
        }
    });
}

document.getElementById('eventState').addEventListener('change', async function() {
    var uf = this.value;
    searchCities(uf); 
});