import { drawText, initParticlesJS, initDarkMode, initBanner } from "./functions";
import 'lazysizes';

document.addEventListener('DOMContentLoaded', function () {
    try {
        drawText();
        initParticlesJS();
        initDarkMode();
        initBanner();
    } catch (error) {
        // console.log(error);
    }
});
