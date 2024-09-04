import $ from 'jquery';

$(function () {
    try {
        if ($('.owl-carousel-wrapper').length !== 0) {
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
                    jQuery('.owl-carousel').owlCarousel(params);
                });
        }
    } catch (error) {
        // console.log(error);
    }
});

