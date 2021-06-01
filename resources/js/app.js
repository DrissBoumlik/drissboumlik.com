// require('bootstrap');
import 'bootstrap';
require('particles.js');
import 'owl.carousel';



$(function () {

    try {
        if($('#particles-js').length) {
            // setTimeout(() => {
            //     $('.loader-wrapper').addClass('disappear');
            // }, 500);
            particlesJS.load('particles-js', '/plugins/particles/particles.min.json');
        }
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
                    items :1
                },
                768: {
                    items :2
                },
                1000: {
                    items :2
                },
            }
        };
        $('.owl-carousel').owlCarousel(params)
    } catch (error) {

    }
});
