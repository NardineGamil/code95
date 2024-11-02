jQuery(document).ready(function($) {
    var swiper = new Swiper('.mySwiper', {
        slidesPerView: 5,
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 2.5,
                centeredSlides: true,
                loop: true,
                loopAdditionalSlides: 30,
            },
            1024: {
                slidesPerView: 3,
                centeredSlides: true,
                loop: true,
                loopAdditionalSlides: 30,
            }
        },
    });
});

jQuery(document).ready(function($) {
    $('.navbar-toggler').on('click', function() {
        var target = $(this).data('bs-target'); // Get the target from data attribute
        $(target).collapse('toggle'); // Toggle the collapse
    });
});



