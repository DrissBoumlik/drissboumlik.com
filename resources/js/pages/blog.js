document.addEventListener('DOMContentLoaded', function () {
    try {
        let searchBlogFormWrapper = document.querySelector('.search-blog-form-wrapper');
        let searchBlogInput = document.querySelector('.search-blog-input');
        let displaySearchFormBtn = document.querySelector('.display-search-form');

        if (searchBlogFormWrapper) {
            window.addEventListener('keydown', function (event) {
                if (event.ctrlKey && (event.key === 'k' || event.key === 'K')) {
                    event.preventDefault();
                    searchBlogFormWrapper.classList.remove('d-none');
                    searchBlogFormWrapper.classList.add('show');
                    if (searchBlogInput) {
                        searchBlogInput.focus();
                    }
                }
            });

            searchBlogFormWrapper.addEventListener('click', function (event) {
                if (event.target === searchBlogFormWrapper) {
                    searchBlogFormWrapper.classList.add('d-none');
                }
            });

            if (displaySearchFormBtn) {
                displaySearchFormBtn.addEventListener('click', function () {
                    searchBlogFormWrapper.classList.remove('d-none');
                    searchBlogFormWrapper.classList.add('show');
                    if (searchBlogInput) {
                        searchBlogInput.focus();
                    }
                });
            }
        }
    } catch (error) {
        console.log(error);
    }
});
