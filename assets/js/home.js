function Eventos() {
    $.ajax({
        url: '/apis/eventos.php',
        type: 'GET',
        success: function(response) {
            response = JSON.parse(response);
            if (response.code == 200) {
                eventos = response.data.eventos;
                
                eventos.forEach(evento => {
                    modeloEvento(evento);
                });
            }
        },
        error: function(error) {
            console.log('An error occurred');
        }
    });
}

function modeloEvento(evento) {
    let htmlEvento = `
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card evento">
                <img class="card-img-top" src="${evento.imagem}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">${evento.titulo}</h5>
                    <p class="card-text descricao-evento">${evento.descricao}</p>
                </div>
            </div>
        </div>
    `;
    $('#eventos').append(htmlEvento)

}

$(document).ready(function() {
  
    Eventos();
    
});