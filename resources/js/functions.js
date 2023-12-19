import * as bootstrap from 'bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;
import { toggleDarkMode } from "./shared/functions";
import particlesJson from '../plugins/particles/particles.min.json';

function initTooltip() {
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
}
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

function initParticlesJS() {
    if ($('#particles-js').length) {
        // setTimeout(() => {
        //     $('.loader-wrapper').addClass('disappear');
        // }, 500);
        particlesJS('particles-js', particlesJson);
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
    jQuery('.owl-carousel').owlCarousel(params);
}

function initDarkMode() {
    $(document).on('click', '.toggle-dark-mode', function () {
        let _this = $(this);
        _this.addClass('pushed');
        setTimeout(() => _this.removeClass('pushed'), 300);
        toggleDarkMode($(document.body),
            {darkmode: 'dark-mode', lightmode: 'light-mode'},
            {name: 'mode', darkmodeValue: 'dark', lightmodeValue: 'light'});
    });
}


function initEvents() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    $(document).on('submit', '.form-subscribe', function (e) {
        e.preventDefault();
        $.ajax({
            method: 'POST',
            url: '/subscribers',
            data: {'subscriber_email' : $('#subscriber-email').val()},
            success: function (response) {
                let subscribe_response = $('#form-subscribe-response');
                // let options = {
                //     icon: 'fa fa-fw fa-circle-check me-1', from: 'bottom', message: 'Thank you for subscribing<br/>A confirmation email has been sent!',
                //     allow_dismiss: true, showProgressbar: true, delay: 10000,
                // }
                // One.helpers('jq-notify', options);
                subscribe_response
                    .html(response.message)
                    .removeClass(subscribe_response.attr('data-class'))
                    .addClass(response.class)
                    .attr('data-class', response.class)
                    .removeAttr('hidden');
            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    });


    let show_password_btn = $('.show-password');
    if (show_password_btn.length) {
        show_password_btn.on('click', function() {
            let input_password = $(this).siblings('input');
            let type = input_password.attr('type') === 'text' ? 'password' : 'text';
            input_password.attr('type', type);
        });
    }

    $('.banner-close').on('click', function () {
        $(this).closest('.banner').remove();
    });

    let search_blog_form_wrapper = $('.search-blog-form-wrapper');
    if (search_blog_form_wrapper.length) {
        $(window).keydown(function (event) {
            if (event.ctrlKey && (event.key === 'k' || event.key === 'K')) {
                event.preventDefault();
                search_blog_form_wrapper.removeClass('d-none').addClass('show');
                $('.search-blog-input').focus();
            }
        });
        search_blog_form_wrapper.on('click', function (event) {
            if (event.target === this) {
                search_blog_form_wrapper.addClass('d-none');
            }
        });

        $('.display-search-form').on('click', function() {
            search_blog_form_wrapper.removeClass('d-none').addClass('show');
            $('.search-blog-input').focus();
        });
    }

    let likePostBtn = $('#btn-like-post');
    if (likePostBtn.length) {
        let postSlug = likePostBtn.data('slug');
        let postLike = JSON.parse(localStorage.getItem(postSlug));
        if (postLike) {
            let html = `<i class="fa-solid fa-thumbs-down me-2"></i>Unlike Post`;
            localStorage.setItem(postSlug, postLike)
            likePostBtn.data('state', 'liked')
                .data('like', postLike)
                .toggleClass('tc-blue-dark-2-bg tc-blue-dark-1-bg-hover tc-blue-dark-2-bg-hover tc-blue-dark-1-bg')
                .html(html)
        }
        likePostBtn.on('click', function(e) {
            let _this = $(this);
            postLike = (_this.data('like') || -1) * -1;
            $.ajax({
                type: 'POST',
                url: `/api/blog/${postSlug}/${postLike}`,
                success: function (response) {
                    _this.data('like', postLike);
                    let html = null;
                    if (postLike === 1) {
                        html = `<i class="fa-solid fa-thumbs-down me-2"></i>Unlike Post`;
                        _this.data('state', 'liked');
                    }
                    else {
                        html = `<i class="fa-solid fa-thumbs-up me-2"></i>Like Post`;
                        _this.data('state', '');
                    }
                    _this.data('like', postLike);
                    localStorage.setItem(postSlug, postLike === 1)
                    _this.toggleClass('tc-blue-dark-2-bg tc-blue-dark-1-bg-hover tc-blue-dark-2-bg-hover tc-blue-dark-1-bg').html(html)
                }
            });
        });
    }
}


export { drawText, initParticlesJS, initSlider, initDarkMode, initEvents, initTooltip };
