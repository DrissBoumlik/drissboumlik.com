import { initParticlesJS, initDarkMode, initBanner } from "./functions";
import 'lazysizes';

document.addEventListener('DOMContentLoaded', function () {
    try {
        initParticlesJS();
        initDarkMode();
        initBanner();
    } catch (error) {
        console.log(error);
    }
});
