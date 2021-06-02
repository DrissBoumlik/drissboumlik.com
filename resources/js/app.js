// require('bootstrap');
import 'bootstrap';
require('particles.js');
import 'owl.carousel';

let _body = $(document.body);

function toggleDarkMode(button, isActive) {
    if (isActive) {
        _body.addClass('dark-mode').removeClass('light-mode');
        button.addClass('dark-mode').removeClass('light-mode');
        $('.icon-mode').addClass('dark-mode').removeClass('light-mode');
        setCookie('mode', 'dark');
    } else {
        _body.removeClass('dark-mode').addClass('light-mode');
        button.removeClass('dark-mode').addClass('light-mode');
        $('.icon-mode').removeClass('dark-mode').addClass('light-mode');
        setCookie('mode', 'light');
    }
}

function setCookie(name, value) {
    var d = new Date();
    d.setTime(d.getTime() + (365*24*60*60*1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

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
            smartSpeed: 2000,
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
        $('.owl-carousel').owlCarousel(params);

        $(document).on('click', '.toggle-dark-mode', function () {
            let _this = $(this);
            let _isActive = !_body.hasClass('dark-mode');
            // let _isActive = localStorage.getItem('isDarkModeActive');
            _this.addClass('pushed');
            setTimeout(() => {
                _this.removeClass('pushed');
            }, 300);
            toggleDarkMode(_this, _isActive);
        });

    } catch (error) {

    }
});
