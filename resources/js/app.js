import { drawText, initParticlesJS, initDarkMode, initAjaxEvents } from "./functions";
import $ from 'jquery';
import 'lazysizes';

$(function () {
    try {
        drawText();
        initParticlesJS();
        initDarkMode();
        initAjaxEvents();
    } catch (error) {
        // console.log(error);
    }
});
