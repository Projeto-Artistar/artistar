function search() {
    event.preventDefault(); // Prevenir o envio padrão do formulário
    var searchInput = document.getElementById('searchInput');
    var encodedValue = encodeURIComponent(searchInput.value);

    // Criar um campo oculto com o valor codificado
    var hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 's';
    hiddenInput.value = encodedValue;

    var form = document.getElementById('searchForm');
    form.appendChild(hiddenInput);
    form.submit();
}

document.getElementById('searchIcon').addEventListener('click', async function() {
    search();
});
document.getElementById('searchForm').addEventListener('submit', async function(event) {
    search();
});

document.getElementById('filterIcon').addEventListener('click', async function() {
    var filterRow = document.getElementById('filterRow');
    filterRow.classList.toggle('show');
});

async function searchCities(uf) {
    var select = document.getElementById('filterCity');
    select.innerHTML = `<option value="${defaultCity}">${defaultCity}</option>`;
    $.ajax({
        url: '/apis/cities',
        type: 'POST',
        data: {uf: uf},
        success: async function(response) {
            response = JSON.parse(response);
            if (response.code == 200) {
                cities = response.data.cities;
                select.innerHTML = '<option value="">Selecione uma cidade</option>';
                cities.forEach(city => {
                    
                    var option = document.createElement('option');
                    //selected if city is the same as the one selected
                    if (city.nome == defaultCity) {
                        option.selected = true;
                    }
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

document.getElementById('filterRegion').addEventListener('change', async function() {
    var uf = this.value;
    searchCities(uf); 
});