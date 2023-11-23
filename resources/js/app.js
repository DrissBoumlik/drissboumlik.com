import { drawText, initParticlesJS, initSlider, initDarkMode, initEvents } from "./functions";


$(function () {
    try {

        drawText();
        initParticlesJS();
        if ($('.no-slider').length === 0) {
            initSlider();
        }
        initDarkMode();
        initEvents();
    } catch (error) {
        // console.log(error);
        // throw error
    }
});
