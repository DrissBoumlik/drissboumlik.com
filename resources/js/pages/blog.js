import $ from 'jquery';

$(function () {
    try {
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
    } catch (error) {
        // console.log(error);
    }
});
