async function getEvent() {
    $.ajax({
        url: '/apis/events/details',
        type: 'POST',
        data: {
            eventId: eventId
        },
        success: async function(response) {
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

async function viewPhotos(photos) {
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
        lazyLoadImages();
        createImageModal();

    }
    $('#carouselSkeleton').hide();
}  

async function lazyLoadImages() {
    const lazyImages = document.querySelectorAll('img[data-src]');
    const lazyBackgrounds = document.querySelectorAll('.slide-background[data-bg]');

    if ('IntersectionObserver' in window) {
        const lazyObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const lazyElement = entry.target;
                    if (lazyElement.tagName === 'IMG') {
                        console.log(`Loading image: ${lazyElement.getAttribute('data-src')}`);
                        lazyElement.src = lazyElement.getAttribute('data-src');
                        lazyElement.removeAttribute('data-src');
                    } else if (lazyElement.classList.contains('slide-background')) {
                        lazyElement.style.backgroundImage = `url('${lazyElement.getAttribute('data-bg')}')`;
                        lazyElement.removeAttribute('data-bg');
                    }
                    observer.unobserve(lazyElement);
                }
            });
        });

        lazyImages.forEach(function(lazyImage) {
            lazyObserver.observe(lazyImage);
        });

        lazyBackgrounds.forEach(function(lazyBackground) {
            lazyObserver.observe(lazyBackground);
        });
    } else {
        // Fallback para navegadores que não suportam IntersectionObserver
        lazyImages.forEach(function(lazyImage) {
            lazyImage.src = lazyImage.getAttribute('data-src');
            lazyImage.removeAttribute('data-src');
        });

        lazyBackgrounds.forEach(function(lazyBackground) {
            lazyBackground.style.backgroundImage = `url('${lazyBackground.getAttribute('data-bg')}')`;
            lazyBackground.removeAttribute('data-bg');
        });
    }
}


async function createImageModal() {
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

async function addAlbumIndicator(photo) {
    let current = photo.order == 0 ? 'class="active" aria-current="true"' : '';
    let htmlIndicator = `
        <button type="button" data-bs-target="#photosCarousel" data-bs-slide-to="${photo.order}" ${current} aria-label="${photo.label}"></button>
    `;
    $('#photo-carousel-indicators').append(htmlIndicator);
}

async function moldPhoto(photo) {
    let active = photo.order == 0 ? 'active' : '';
    let htmlPhoto = `
        <div class="carousel-item ${active}">
            <div class="slide d-flex justify-content-center">
                <div class="slide-background" data-bg="/assets/image/800x400.png"></div>
                <img class="slide-item" src="${photo.url}" alt="${photo.label}" loading="lazy">
            </div>
        </div>
    `;
    $('#carousel-items').append(htmlPhoto);
}

async function viewBasicInfo(basicInfo) {
    loadTitle(basicInfo.title);
    loadButtons(basicInfo.favorite);
    // loadSubtitle(basicInfo.subtitle);
    loadAddress(basicInfo.address);
    loadDescription(basicInfo.description);
    loadProductor(basicInfo.production);
}

async function loadTitle(title) {
    $('#eventTitle').html(`<h1>${title}</h1>`);
    $('#eventTitle').show();
    $('#eventTitle-skeleton').hide();
}

async function loadButtons(favorite) {
    let favoriteIcon = favorite == 1 ? 'mdi:heart' : 'mdi:heart-outline';
    let htmlButtons = `
        <div class="event-buttons">
            <button class="btn btn-favorite shadow-none btn-event-action"><span class="iconify btn-icon" data-icon="${favoriteIcon}" data-inline="false"></span></button>
            <button class="btn btn-share shadow-none btn-event-action" id="btn-share"><span class="iconify btn-icon" data-icon="mdi:share-variant" data-inline="false"></span></button>
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

async function favoriteEvent() {
    $('.btn-favorite').on('click', function() {
        let icon = $(this);
        $.ajax({
            url: '/apis/events/favorite',
            type: 'POST',
            data: {
                eventId: eventId
            },
            success: async function(response) {
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

async function loadSubtitle(subtitle) {
    $('#eventSubtitle').text(subtitle);
    $('#eventSubtitle').show();
}

async function loadDescription(description) {
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

async function loadAddress(address) {
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

async function loadProductor(productor) {
    $('#eventProductor').text(productor);
    $('#column-productor-skeleton').hide();
    $('#column-productor').show();
}

async function generateMap(address) {
    var url = "https://www.google.com/maps?q=" + encodeURIComponent(address) + "&output=embed";
    var iframe = "<iframe frameborder='0' style='border:0; width: 100%; min-height: 500px;' src='" + url + "' allowfullscreen></iframe>";
    $('#mapa').html(iframe);
    $('#row-map').show();
    $('#section-map').show();
}

async function viewContacts(contacts) {
    if (contacts.length > 0) {
        contacts.forEach(contact => {
            moldContact(contact);
        });
        $('#contactsColumn').show();
    }
    $('#contactsColumn-skeleton').hide();
}

async function moldContact(contact) {
    let htmlContact = `<li><i class="${contact.icon}"></i> <span class="color-klikit-2 mx-2">${contact.value}</span></li>`;
    $('#contactsList').append(htmlContact);
}

async function viewSocialMedia(socialMedia) {
    if (socialMedia.length > 0) {
        socialMedia.forEach(social => {
            moldSocialMedia(social);
        });
        $('#socialMediaColumn').show();
    }
    $('#socialMediaColumn-skeleton').hide();
}

async function moldSocialMedia(social) {
    let htmlSocial = `
        <li class="d-flex align-items-center mb-2">
            <i class="${social.icon}"></i> <a class="link-kitlit-1 mx-2" href="${social.url}" target="_blank">${social.name}</a>
        </li>
    `;
    $('#socialMediaList').append(htmlSocial);
}

async function viewDays(days) {
    if (days.length > 0) {
        days.forEach(day => {
            moldDay(day);
        });
        $('#daysRow').show();
        $('#column-pi').show();
    }
    $('#column-pi-skeleton').hide();
}

async function moldDay(day) {
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

async function viewPrices(prices) {
    if (prices.length > 0) {
        prices.forEach(price => {
            moldPrice(price);
        });
        $('#pricesRow').show();
        $('#column-pi').show();
    }
    $('#column-pi-skeleton').hide();
}

async function moldPrice(price) {

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

document.addEventListener('DOMContentLoaded', function() {
    getEvent(); 

    $('#copyUrl').on('click', function() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(function() {
            const toast = new bootstrap.Toast(document.getElementById('copyToast'));
            toast.show();
        }, function(err) {
            console.error('Erro ao copiar a URL: ', err);
        });
    }); 

    $('#shareFacebook').on('click', function() {
        const url = window.location.href;
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
    });

    $('#shareWhatsApp').on('click', function() {
        const url = window.location.href;
        window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(url)}`, '_blank');
    });

    $('#sharePinterest').on('click', function() {
        const url = window.location.href;
        const description = document.title; // Você pode ajustar isso para usar uma descrição personalizada
        window.open(`https://pinterest.com/pin/create/button/?url=${encodeURIComponent(url)}&description=${encodeURIComponent(description)}`, '_blank');
    });

    $('#shareLinkedIn').on('click', function() {
        const url = window.location.href;
        const title = document.title; // Você pode ajustar isso para usar um título personalizado
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}`, '_blank');
    });

    $('#shareTelegram').on('click', function() {
        const url = window.location.href;
        window.open(`https://t.me/share/url?url=${encodeURIComponent(url)}`, '_blank');
    });


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

