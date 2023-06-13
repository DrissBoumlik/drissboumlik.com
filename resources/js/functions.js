// import 'bootstrap';
import {initImageCropper} from "./plugins-use";

require('particles.js');
// var slugify = require('slugify')
import 'owl.carousel';
var slugify = require('slugify')

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

function toggleDarkMode(_body, isActive) {
    if (isActive) {
        _body.addClass('dark-mode').removeClass('light-mode');
        setCookie('mode', 'dark');
    } else {
        _body.removeClass('dark-mode').addClass('light-mode');
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
        toggleDarkMode(_body, _isActive);
    });
}

function get_alert_box(params) {
    let alert_element = `
        <div data-notify="container" class="col-11 col-sm-4 alert ${params.class} alert-dismissible animated fadeIn" role="alert" data-notify-position="bottom-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1033; bottom: 20px; right: 20px; animation-iteration-count: 1;">
            <p class="mb-0">
                <span data-notify="icon"></span>
                <span data-notify="title"></span>
                <span data-notify="message">${params.message}</span>
            </p>
            <a class="p-2 m-1 text-dark" href="javascript:void(0)" aria-label="Close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 1035;">
                <i class="fa fa-times"></i>
            </a>
        </div>
    `;
    $(document.body).append(alert_element);
    $('.alert.alert-dismissible').on('click', function() { $(this).remove() });
}

function initEvents() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    $(document).on('focusout', '.input-to-slugify', function () {
        let postTitle = $(this).val();
        let postSlug = string_to_slug(postTitle)
        // let postSlug = slugify(postTitle, {
        //     // replacement: '-',  // replace spaces with replacement character, defaults to `-`
        //     // remove: undefined, // remove characters that match regex, defaults to `undefined`
        //     lower: true,      // convert to lower case, defaults to `false`
        //     strict: true,     // strip special characters except replacement, defaults to `false`
        //     // locale: 'vi',      // language code of the locale to use
        //     trim: true         // trim leading and trailing replacement chars, defaults to `true`
        // });
        $('.input-slug').val(postSlug);
    });

    $(document).on('click', '.like-post', function () {
        let post = $(this).data('post');

        let liked_posts = JSON.parse(localStorage.getItem('liked-posts'));
        if (liked_posts && liked_posts.includes(post.slug)) {
            get_alert_box({class : 'alert-warning', message : 'Already liked !!'})
            return
        }

        $.ajax({
            method: 'POST',
            url: '/blog/like/' + post.slug,
            success: function (response) {
                localStorage.setItem('liked-posts', JSON.stringify([response.post.slug]))
                $('.post-likes-count').text(`${response.post.likes} Likes`);
            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    });

    let imageElement = document.getElementById('image')
    if (imageElement) {
        imageElement.onchange = (event) => {
            if (event.target.files.length > 0) {
                let src = URL.createObjectURL(event.target.files[0]);
                let preview = document.getElementById("image-preview");
                preview.src = src;

                // initImageCropper();
            }
        };
    }
}

export { drawText, initParticlesJS, initSlider, initDarkMode, initEvents };