// import 'bootstrap';
require('particles.js');
// var slugify = require('slugify')
import 'owl.carousel';

function drawText() {
    let text = `
       /$$           /$$
      | $$          |__/
  /$$$$$$$  /$$$$$$  /$$  /$$$$$$$ /$$$$$$$
 /$$__  $$ /$$__  $$| $$ /$$_____//$$_____/
| $$  | $$| $$  \\__/| $$|  $$$$$$|  $$$$$$
| $$  | $$| $$      | $$ \\____  $$\\____  $$
|  $$$$$$$| $$      | $$ /$$$$$$$//$$$$$$$/
 \\_______/|__/      |__/|_______/|_______/

  /$$                                         /$$ /$$ /$$
 | $$                                        | $$|__/| $$
 | $$$$$$$   /$$$$$$  /$$   /$$ /$$$$$$/$$$$ | $$ /$$| $$   /$$
 | $$__  $$ /$$__  $$| $$  | $$| $$_  $$_  $$| $$| $$| $$  /$$/
 | $$  \\ $$| $$  \\ $$| $$  | $$| $$ \\ $$ \\ $$| $$| $$| $$$$$$/
 | $$  | $$| $$  | $$| $$  | $$| $$ | $$ | $$| $$| $$| $$_  $$
 | $$$$$$$/|  $$$$$$/|  $$$$$$/| $$ | $$ | $$| $$| $$| $$ \\  $$
 |_______/  \\______/  \\______/ |__/ |__/ |__/|__/|__/|__/  \\__/
    `;
    console.log(text);
}

function string_to_slug(str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "åàáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to = "aaaaaaeeeeiiiioooouuuunc------";

    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str
        .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-') // collapse dashes
        .replace(/^-+/g, '') // trim - from start of text
        .replace(/-+$/g, ''); // trim - from end of text

    return str;
}

function toggleDarkMode(button, isActive) {
    let _body = $(document.body);
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
    d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function initParticlesJS() {
    if ($('#particles-js').length) {
        // setTimeout(() => {
        //     $('.loader-wrapper').addClass('disappear');
        // }, 500);
        particlesJS.load('particles-js', '/plugins/particles/particles.min.json');
    }
}

function initSlider() {
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
    $('.owl-carousel').owlCarousel(params);
}

function initDarkMode() {
    let _body = $(document.body);
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
}

function initEvents() {
    $(document).on('focusout', '#post-title', function () {
        let postTitle = $(this).val();
        let postSlug = string_to_slug(postTitle);
        // slugify(postTitle, {
        //     replacement: '-',  // replace spaces with replacement character, defaults to `-`
        //     remove: undefined, // remove characters that match regex, defaults to `undefined`
        //     lower: true,      // convert to lower case, defaults to `false`
        //     strict: true,     // strip special characters except replacement, defaults to `false`
        //     locale: 'vi'       // language code of the locale to use
        // });
        $('#post-slug').val(postSlug);
    });
}

export { drawText, initParticlesJS, initSlider, initDarkMode };
