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
                if (response.data.photos.length > 0) viewPhotos(response.data.photos);
                basicInfo = response.data.basicInfo;
                viewBasicInfo(basicInfo);
                if (basicInfo.contacts.length > 0) viewContacts(basicInfo.contacts);
                if (basicInfo.socialMedia.length > 0) viewSocialMedia(basicInfo.socialMedia);
                if (response.data.days.length > 0)  viewDays(response.data.days);
                if (response.data.prices.length > 0) viewPrices(response.data.prices);
            }
        },
        error: function(error) {
            console.log('An error occurred');
        }
    });
}

function viewPhotos(photos) {
    photos.forEach(photo => {
        addAlbumIndicator(photo);
        moldPhoto(photo);
    });
    if (photos.length > 1) {
        $('#slide-btn-previous').show();
        $('#slide-btn-next').show();
    }
    $('#photosCarousel').show();
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
    loadButtons();
    // loadSubtitle(basicInfo.subtitle);
    if (basicInfo.address != '')  loadAddress(basicInfo.address);
    loadDescription(basicInfo.description);
    loadProductor(basicInfo.production);
    
}

function loadTitle(title) {
    $('#eventTitle').html(`<h1>${title}</h1>`);
    $('#eventTitle').show();
}

function loadButtons() {
    let htmlButtons = `
        <div class="event-buttons">
            <button class="btn btn-favorite shadow-none btn-event-action"><i class="mdi mdi-heart-outline btn-icon"></i></button>
            <button class="btn btn-share shadow-none btn-event-action"><i class="mdi mdi-share-variant btn-icon"></i></button>
        </div>
    `;
    $('#column-buttons').html(htmlButtons);
    $('#column-buttons').show();
    favoriteEvent();
}

function favoriteEvent() {
    $('.btn-favorite').on('click', function() {
        let icon = $(this);
        icon.addClass('animate-grow-shrink');
        let child = icon.children();
        if(child.hasClass('mdi-heart-outline')) {
            child.removeClass('mdi-heart-outline');
            child.addClass('mdi-heart');
        } else {
            child.removeClass('mdi-heart');
            child.addClass('mdi-heart-outline');
        }
        // Remove a classe após a animação terminar
        icon.on('animationend', function() {
            icon.removeClass('animate-grow-shrink');
        });
    });
}

function loadSubtitle(subtitle) {
    $('#eventSubtitle').text(subtitle);
    $('#eventSubtitle').show();
}

function loadDescription(description) {
    $('#eventDescription').html(description);
    $('#eventDescription').show();
    $('#column-description').show();
    $('#row-dpi').show();
}

function loadAddress(address) {
    $('#eventAddress').text(address);
    $('#eventAddress').show();
    generateMap(basicInfo.address);
}

function loadProductor(productor) {
    $('#eventProductor').text(productor);
    $('#column-productor').show();
}

function generateMap(address) {
    var url = "https://www.google.com/maps?q=" + encodeURIComponent(address) + "&output=embed";
    var iframe = "<iframe frameborder='0' style='border:0; width: 100%; min-height: 500px;' src='" + url + "' allowfullscreen></iframe>";
    $('#mapa').html(iframe);
    $('#row-map').show();
}

function viewContacts(contacts) {
    contacts.forEach(contact => {
        moldContact(contact);
    });
    $('#contactsColumn').show();
}

function moldContact(contact) {
    let htmlContact = `<li><i class="${contact.icon}"></i> <span class="color-klikit-2 mx-2">${contact.value}</span></li>`;
    $('#contactsList').append(htmlContact);
}

function viewSocialMedia(socialMedia) {
    socialMedia.forEach(social => {
        moldSocialMedia(social);
    });
    $('#socialMediaColumn').show();
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
    days.forEach(day => {
        moldDay(day);
    });
    $('#daysRow').show();
    $('#column-pi').show();
    $('#row-dpi').show();
}

function moldDay(day) {
    let htmlDay = `
        <div class="col-xxl-4 col-md-6 col-sm-4 col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">${day.date}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">${day.start_time} - ${day.end_time}</h6>
                </div>
            </div>
        </div>
    `;
    $('#daysRow').append(htmlDay);
}

function viewPrices(prices) {
    prices.forEach(price => {
        moldPrice(price);
    });
    $('#pricesRow').show();
    $('#column-pi').show();
    $('#row-dpi').show();
}

function moldPrice(price) {

    let htmlPrice = `
        <div class="col-xxl-4 col-md-6 col-sm-4 col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">${price.name}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">${price.price}</h6>
                    <span class="card-subtitle mb-2 text-muted">Até ${price.end_date}</span>
                </div>
            </div>
        </div>
    `;
    $('#pricesRow').append(htmlPrice);

}

$(document).ready(function() {
    getEvent();
});

