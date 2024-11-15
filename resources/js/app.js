import { drawText, initParticlesJS, initDarkMode } from "./functions";
import 'lazysizes';

document.addEventListener('DOMContentLoaded', function () {
    try {
        drawText();
        initParticlesJS();
        initDarkMode();
    } catch (error) {
        // console.log(error);
    }
});
