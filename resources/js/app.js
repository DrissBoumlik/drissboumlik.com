import { drawText, initParticlesJS, initSlider, initDarkMode } from "./functions";

$(function () {
    try {
        drawText();
        initParticlesJS();
        initSlider();
        initDarkMode();

        // initEvents();
    } catch (error) {
        console.log(error);
    }
});
