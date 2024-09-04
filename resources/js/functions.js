import $ from 'jquery';
window.$ = window.jQuery = $;
import { toggleDarkMode } from "./shared/functions";
import particlesJson from '../plugins/particles/particles.min.json';


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


function initAjaxEvents() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
}

function initBanner() {
    $('.banner-close').on('click', function () {
        $(this).closest('.banner').remove();
    });
}


function initLikePostBtn() {
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


export { drawText, initParticlesJS, initDarkMode, initAjaxEvents };
