async function getEventos() {
    $.ajax({
        url: '/apis/events',
        type: 'POST',
        success: async function(response) {
            response = JSON.parse(response);
            if (response.code == 200) {
                eventos = response.data.eventos;
                
                eventos.forEach(evento => {
                    modeloEvento(evento);
                });
            }
        },
        error: async function(error) {
            console.log('An error occurred');
        }
    });
}

async function modeloEvento(evento) {
    let htmlEvento = `
        <a class="col-lg-3 col-md-4 col-sm-6 mb-4 evento" href="/events/${evento.id}/${evento.url}">
            <div class="card">
                <img class="card-img-top" src="${evento.image}" alt="Card image cap">
                <span class="image-overlay">${evento.start_date} - ${evento.end_date}</span>
                <div class="card-body">
                    <h5 class="card-title">${evento.title}</h5>
                    <p class="card-text descricao-evento">${evento.subtitle}</p>
                </div>
            </div>
        </a>
    `;
    $('#eventos').append(htmlEvento)
}

$(document).ready(async function() {
    getEventos();
    $('.evento > .card').each(function() {
        var $card = $(this);
        var $cardBody = $card.find('.card-body');
        var $cardImgTop = $card.find('.card-img-top');

        $cardBody.on('mouseover', function() {
            $cardImgTop.css('height', '0');
        });

        $cardBody.on('mouseout', function() {
            $cardImgTop.css('height', '150px'); // Altura inicial
        });
    });

    $('#carrossel-lojas').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: true,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 2000,
        prevArrow: '<button type="button" class="slick-prev slick-arrow" >Previous</button>',
        nextArrow: '<button type="button" class="slick-next slick-arrow">Next</button>',
        responsive: [
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
              },
            },
            {
              breakpoint: 576,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              },
            },
        ],
    });
    // $('#carrossel-lojas').on('setPosition', function() {
    //     $('.slick-slide').each(function() {
    //         var $slide = $(this);
    //         $slide.css('height', '300px'); // Defina a altura desejada
    //     });
    // });
});
