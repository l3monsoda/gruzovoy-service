// Модальные окна

$('.popup-with-form').magnificPopup({
    type: 'inline',
    preloader: false,
    focus: '#name',
    removalDelay: 300, //delay removal by X to allow out-animation


    callbacks: {
        beforeOpen: function() {
            this.st.mainClass = this.st.el.attr('data-effect');
            if ($(window).width() < 700) {
                this.st.focus = false;
            } else {
                this.st.focus = '#name';
            }
        }
    }
});

$('.form-modal-window__send-button').on('click', function(e) {
    e.preventDefault();
})

// Мобильное меню, ивенты кнопки

const menuToggle = document.querySelector('#menu-toggle');
const mobileNavContainer = document.querySelector('#mobile-nav');
const buttonToggle = document.querySelector('.header__call-button');

menuToggle.onclick = function() {
    buttonToggle.classList.toggle('header__call-button_inactive');
    menuToggle.classList.toggle('menu-icon-active');
    mobileNavContainer.classList.toggle('navigation-mobile__list_active');
}

// Зона загрузки файлов

Dropzone.autoDiscover = false;

var myDropzone = new Dropzone("li#formUpload", {
    url: "#",
    maxFilesize: 2, // MB
    uploadMultiple: true,
    maxFiles: 5,
    acceptedFiles: '.jpg, .png, jpeg',
    dictDefaultMessage: 'Загрузите изображение',
});

// Шторка до/после

$(function() {
    $(".portfolio__slider").twentytwenty({
        no_overlay: true, //Do not show the overlay with before and after
    });
    // Mesure your images and divide by 2.
    var imgWidth = $(".portfolio__slider img").width() / 2;

    // On the container, apply a left offset of 50% (screen center) - minus half image width.
    $(".portfolio__slider").css({ "position": "relative", "left": "calc(50% - " + imgWidth + "px)" });
});

//  Галерея выполненных работ слик-карусель

$('.js-gallery').slick({
    rows: 2,
    slidesPerRow: 4,
    prevArrow: '    <svg class="gallery-arrow mod-prev">\n' +
        '      <use xlink:href="/assets/img/sprite.svg#angle-left"></use>\n' +
        '    </svg>',
    nextArrow: '    <svg class="gallery-arrow mod-next">\n' +
        '      <use xlink:href="/assets/img/sprite.svg#angle-right"></use>\n' +
        '    </svg>',
    responsive: [{
            breakpoint: 1025,
            settings: {
                slidesPerRow: 3
            }
        },
        {
            breakpoint: 769,
            settings: {
                slidesPerRow: 2
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesPerRow: 1
            }
        }
    ]
});

// Слик лайтбокс

$('.js-gallery').slickLightbox({
    src: 'src',
    itemSelector: '.js-gallery-popup img',
    background: 'rgba(0, 0, 0, .7)'
});

//  Маз слайдер

$('.maz-slider').slick({
    slidesToShow: 1,
    centerMode: true,
    dots: true,

    prevArrow: '    <svg class="maz-slider-arrow mod-prev">\n' +
        '      <use xlink:href="/assets/img/sprite.svg#angle-left"></use>\n' +
        '    </svg>',
    nextArrow: '    <svg class="maz-slider-arrow mod-next">\n' +
        '      <use xlink:href="/assets/img/sprite.svg#angle-right"></use>\n' +
        '    </svg>'
});

// Отправка данных с формы

$('.btn_submit').click(function() {

    const clientPhone = $('.phone-input').val();
    const clientName = $('.name-input').val();
    const textComment = $('.textarea-item').val();

    $.ajax({
        url: "../php/send.php",
        type: "post",
        data: {
            "phone": clientPhone,
            "name": clientName,
            "comment": textComment

        },
        error: function() { $("#erconts").html("Произошла ошибка!"); },

        beforeSend: function() {
            $("#erconts").html("Отправляем данные...");
        },
        success: function(result) {

            $('#erconts').html(result);
            console.log("ntcn");
        }
    });
});

// Сумматор таблицы прайс-листа

const service = document.querySelectorAll('.table-row');
const finalPrice = document.querySelector('.price-result');
const finalTime = document.querySelector('.time-result');

for (var i = 0; i < service.length; i++) {

    service[i].onclick = function() {

        this.classList.toggle('table-row-active');

        let currentCheckbox = this.querySelector('.table-row-checkbox');

        currentCheckbox.classList.toggle('table-row-checkbox_active');

        calcPrice();
        calcTime();
    }
}

function calcPrice() {

    let price = 0;

    for (var i = 0; i < service.length; i++) {
        if (service[i].classList.contains('table-row-active')) {
            price += parseInt(service[i].getAttribute('data-price'));
        }
    }

    finalPrice.innerHTML = price;
}

function calcTime() {

    let time = 0;

    for (var i = 0; i < service.length; i++) {
        if (service[i].classList.contains('table-row-active')) {
            time += parseInt(service[i].getAttribute('data-time'));
        }
    }

    finalTime.innerHTML = time;

}

// Фильтр грузовиков

var fActive = '';
const tabItems = document.querySelectorAll('.tab-item');

function filterCard(fabrication) {
    if (fActive != fabrication) {
        $('.painting-card__item').filter('.' + fabrication).fadeIn();
        $('.painting-card__item').filter(':not(.' + fabrication + ')').fadeOut();
        fActive = fabrication;
    }
}

$('#russian').click(function() {
    $(this).addClass('tab-item__active');
    $('.tab-item').not(this).removeClass('tab-item__active');
    filterCard('russia');
});

$('#europian').click(function() {
    $(this).addClass('tab-item__active');
    $('.tab-item').not(this).removeClass('tab-item__active');
    filterCard('europe');
});

$('#american').click(function() {
    $(this).addClass('tab-item__active');
    $('.tab-item').not(this).removeClass('tab-item__active');
    filterCard('usa');
});

$('#chineese').click(function() {
    $(this).addClass('tab-item__active');
    $('.tab-item').not(this).removeClass('tab-item__active');
    filterCard('china');
});

$('#all').click(function() {
    $(this).addClass('tab-item__active');
    $('.tab-item').not(this).removeClass('tab-item__active');
    $('.painting-card__item').fadeIn();
    fActive = 'all';
});