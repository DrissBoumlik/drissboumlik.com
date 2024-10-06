import { drawText, initParticlesJS, initDarkMode, initAjaxEvents } from "./functions";
import 'lazysizes';

document.addEventListener('DOMContentLoaded', function () {
    try {
        drawText();
        initParticlesJS();
        initDarkMode();
        initAjaxEvents();
    } catch (error) {
        // console.log(error);
    }
});
