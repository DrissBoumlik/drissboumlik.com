import { initDarkMode, initAjaxEvents } from "./functions";
import 'lazysizes';


document.addEventListener('DOMContentLoaded', function () {
    try {
        initDarkMode();
        initAjaxEvents();
        const toggleHeaderButtons = document.querySelectorAll('.toggle-header')
        toggleHeaderButtons.forEach(function (toggleHeader) {
                toggleHeader.addEventListener('click', function (event) {
                    toggleHeaderButtons.forEach(function (header) {
                        header.classList.toggle('btn-alt-secondary');
                        header.classList.toggle('tc-blue-dark-2-bg');
                    });
                    setTimeout(() => document.getElementById('page-container')
                        .classList.toggle('page-header-fixed'), 1000);
            })
        })

    } catch (error) {
    }
});
