function getEvent() {
    $.ajax({
        url: '/apis/events/details',
        type: 'POST',
        data: {
            eventId: eventId
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.code == 200) {
                // eventos = response.data.eventos;
                
                // eventos.forEach(evento => {
                //     modeloEvento(evento);
                // });
            }
        },
        error: function(error) {
            console.log('An error occurred');
        }
    });
}

$(document).ready(function() {
    getEvent();
});
