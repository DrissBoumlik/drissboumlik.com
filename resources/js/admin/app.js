import { initDarkMode, initAjaxEvents } from "./functions";
import 'lazysizes';


$(function () {
    try {
        initDarkMode();
        initAjaxEvents();
    } catch (error) {
    }
});
