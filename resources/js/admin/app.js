import { initDarkMode, initAjaxEvents } from "./functions";
import 'lazysizes';


$(function () {
    try {
        initDarkMode();
        initAjaxEvents();

        $(document).on('click', '.toggle-header', function () {
            $('.toggle-header').toggleClass('btn-alt-secondary tc-black-bg')
            setTimeout(() => $('#page-container').toggleClass('page-header-fixed'), 1000);
        })

    } catch (error) {
    }
});
