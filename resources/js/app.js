import { initParticlesJS, initDarkMode } from "@/functions";
import 'lazysizes';

document.addEventListener('DOMContentLoaded', function () {
    try {
        initParticlesJS();
        initDarkMode();
    } catch (error) {
        console.log(error);
    }
});
