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
                viewPhotos(response.data.photos);
                basicInfo = response.data.basicInfo;
                viewBasicInfo(basicInfo);
                viewContacts(basicInfo.contacts);
                viewSocialMedia(basicInfo.socialMedia);
                viewDays(response.data.days);
                viewPrices(response.data.prices);
            }
        },
        error: function(error) {
            console.log('An error occurred');
        }
    });
}

function viewPhotos(photos) {
    if (photos.length > 0) {
        photos.forEach(photo => {
            addAlbumIndicator(photo);
            moldPhoto(photo);
        });
        if (photos.length > 1) {
            $('#slide-btn-previous').show();
            $('#slide-btn-next').show();
        }
        $('#photosCarousel').show();
        createImageModal();
    }
    $('#carouselSkeleton').hide();
}  

function createImageModal() {
    let htmlModal = `
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered slide-dialog">
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <img  class="img-fluid img-modal" alt="Imagem">
                </div>
            </div>
        </div>
    `;
    $('#slide-item-modal').append(htmlModal);
    $('.slide-item').on('click', function() {
        $('#imageModal').find('img').attr('src', $(this).attr('src'));
        $('#imageModal').modal('show');
    });
}

function addAlbumIndicator(photo) {
    let current = photo.order == 0 ? 'class="active" aria-current="true"' : '';
    let htmlIndicator = `
        <button type="button" data-bs-target="#photosCarousel" data-bs-slide-to="${photo.order}" ${current} aria-label="${photo.label}"></button>
    `;
    $('#photo-carousel-indicators').append(htmlIndicator);
}

function moldPhoto(photo) {
    let active = photo.order == 0 ? 'active' : '';
    let htmlPhoto = `
        <div class="carousel-item ${active}">
            <div class="slide d-flex justify-content-center">
                <div class="slide-background" style="background-image: url('${photo.url}');"></div>
                <img class="slide-item" src="${photo.url}" alt="${photo.label}">
            </div>
        </div>
    `;
    $('#carousel-items').append(htmlPhoto);
}

function viewBasicInfo(basicInfo) {
    loadTitle(basicInfo.title);
    loadButtons(basicInfo.favorite);
    // loadSubtitle(basicInfo.subtitle);
    loadAddress(basicInfo.address);
    loadDescription(basicInfo.description);
    loadProductor(basicInfo.production);
}

function loadTitle(title) {
    $('#eventTitle').html(`<h1>${title}</h1>`);
    $('#eventTitle').show();
    $('#eventTitle-skeleton').hide();
}

function loadButtons(favorite) {
    let favoriteClass = favorite == 1 ? 'mdi-heart' : 'mdi-heart-outline';
    let htmlButtons = `
        <div class="event-buttons">
            <button class="btn btn-favorite shadow-none btn-event-action"><i class="mdi ${favoriteClass} btn-icon"></i></button>
            <button class="btn btn-share shadow-none btn-event-action" id="btn-share"><i class="mdi mdi-share-variant btn-icon"></i></button>
        </div>
    `;
    $('#column-buttons').html(htmlButtons);
    $('#column-buttons').show();
    $('#btn-share').on('click', function() {
        $('#shareModal').modal('show');
    });
    $('#column-buttons-skeleton').hide();
    favoriteEvent();
}

function favoriteEvent() {
    $('.btn-favorite').on('click', function() {
        let icon = $(this);
        $.ajax({
            url: '/apis/events/favorite',
            type: 'POST',
            data: {
                eventId: eventId
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.code == 200) {
                    icon.addClass('animate-grow-shrink');
                    let child = icon.children();
                    if (response.data.favorite) {
                        if(child.hasClass('mdi-heart-outline')) {
                            child.removeClass('mdi-heart-outline');
                            child.addClass('mdi-heart');
                        }
                    } else {
                        if (child.hasClass('mdi-heart')) {
                            child.removeClass('mdi-heart');
                            child.addClass('mdi-heart-outline');
                        }
                    }
                    icon.on('animationend', function() {
                        icon.removeClass('animate-grow-shrink');
                    });
                } else {
                    if (response.code == 401) {
                        window.location.href = '/login';
                    }
                }
            },
            error: function(error) {
                console.log('An error occurred');
            }
        });

    });
}

function loadSubtitle(subtitle) {
    $('#eventSubtitle').text(subtitle);
    $('#eventSubtitle').show();
}

function loadDescription(description) {
    if (description != '' && description != null && description != undefined) {
        $('#eventDescription').html(description);
        $('#eventDescription').show();
        $('#column-description').show();
    } else {
        $('#column-pi').removeClass('col-md-6');
        $('#column-pi').addClass('col-12');
    }
    $('#column-description-skeleton').hide();
}

function loadAddress(address) {
    if (address != '') {
        let htmlAddress = `<h6 class="color-klikit-2"><i class="mdi mdi-map-marker"></i> ${address}</h6>`;
        $('#eventAddress').append(htmlAddress);
        $('#eventAddress').show();
        generateMap(basicInfo.address);
    } else {
        $('#column-productor').removeClass('justify-content-end')
    }
    $('#eventAddress-skeleton').hide();
    
}

function loadProductor(productor) {
    $('#eventProductor').text(productor);
    $('#column-productor-skeleton').hide();
    $('#column-productor').show();
}

function generateMap(address) {
    var url = "https://www.google.com/maps?q=" + encodeURIComponent(address) + "&output=embed";
    var iframe = "<iframe frameborder='0' style='border:0; width: 100%; min-height: 500px;' src='" + url + "' allowfullscreen></iframe>";
    $('#mapa').html(iframe);
    $('#row-map').show();
    $('#section-map').show();
}

function viewContacts(contacts) {
    if (contacts.length > 0) {
        contacts.forEach(contact => {
            moldContact(contact);
        });
        $('#contactsColumn').show();
    }
    $('#contactsColumn-skeleton').hide();
}

function moldContact(contact) {
    let htmlContact = `<li><i class="${contact.icon}"></i> <span class="color-klikit-2 mx-2">${contact.value}</span></li>`;
    $('#contactsList').append(htmlContact);
}

function viewSocialMedia(socialMedia) {
    if (socialMedia.length > 0) {
        socialMedia.forEach(social => {
            moldSocialMedia(social);
        });
        $('#socialMediaColumn').show();
    }
    $('#socialMediaColumn-skeleton').hide();
}

function moldSocialMedia(social) {
    let htmlSocial = `
        <li class="d-flex align-items-center mb-2">
            <i class="${social.icon}"></i> <a class="link-kitlit-1 mx-2" href="${social.url}" target="_blank">${social.name}</a>
        </li>
    `;
    $('#socialMediaList').append(htmlSocial);
}

function viewDays(days) {
    if (days.length > 0) {
        days.forEach(day => {
            moldDay(day);
        });
        $('#daysRow').show();
        $('#column-pi').show();
    }
    $('#column-pi-skeleton').hide();
}

function moldDay(day) {
    let htmlDay = `
        <div class="col-xxl-4 col-md-6 col-sm-4 col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">${day.date}</h5>
                    <h6 class="card-subtitle mb-2 text-muted color-klikit-2">${day.start_time} - ${day.end_time}</h6>
                </div>
            </div>
        </div>
    `;
    $('#daysRow').append(htmlDay);
}

function viewPrices(prices) {
    if (prices.length > 0) {
        prices.forEach(price => {
            moldPrice(price);
        });
        $('#pricesRow').show();
        $('#column-pi').show();
    }
    $('#column-pi-skeleton').hide();
}

function moldPrice(price) {

    let htmlPrice = `
        <div class="col-xxl-4 col-md-6 col-sm-4 col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">${price.name}</h5>
                    <h6 class="card-subtitle mb-2 text-muted color-klikit-2">${price.price}</h6>
                    <span class="card-subtitle mb-2 text-muted">Até ${price.end_date}</span>
                </div>
            </div>
        </div>
    `;
    $('#pricesRow').append(htmlPrice);

}

$(document).ready(function() {
    // setTimeout(function() {
        getEvent();
    // }, 3000);     
    $('.your-class').slick({
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: false,
        arrows: true,
        prevArrow: '<button type="button" class="slick-prev">Previous</button>',
        nextArrow: '<button type="button" class="slick-next">Next</button>',
        responsive: [
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
              },
            },
            {
              breakpoint: 576,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
              },
            },
        ],
    });
});

