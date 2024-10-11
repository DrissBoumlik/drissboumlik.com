import $ from 'jquery';
window.jQuery = $;
document.addEventListener('DOMContentLoaded', function () {
    try {
        let owlCarouselWrapper = document.querySelector('.owl-carousel-wrapper');
        if (owlCarouselWrapper) {
            import('owl.carousel')
                .then(function () {
                    let params = {
                        loop: true,
                        dots: false,
                        // margin: 10,
                        // nav: true,
                        // freeDrag: true,
                        autoplay: true,
                        smartSpeed: 500,
                        autoplayTimeout: 3000,
                        // autoplaySpeed: 3000,
                        autoplayHoverPause: true,
                        slideTransition: 'linear',
                        responsive: {
                            0: {
                                items: 1
                            },
                            768: {
                                items: 2
                            },
                            1000: {
                                items: 2
                            },
                        }
                    };

                    let owlCarousels = document.querySelectorAll('.owl-carousel');
                    owlCarousels.forEach(function (carousel) {
                    new window.jQuery(carousel).owlCarousel(params);
                    
                    document.querySelector('.owl-carousel-items').classList.remove('invisible');
                    document.querySelector('.owl-carousel-loading').remove();
                });
            });
        }
    } catch (error) {
        console.log(error);
    }
});

