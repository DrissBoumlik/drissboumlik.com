import { drawText, initParticlesJS, initSlider, initDarkMode, initEvents, initTooltip } from "./functions";


$(function () {
    try {
        if($('.resume-menu').length !== 0) {
            initTooltip();
        }
        drawText();
        initParticlesJS();
        if ($('.no-slider').length === 0) {
            initSlider();
        }
        initDarkMode();
        initEvents();
    } catch (error) {
        // console.log(error);
        throw error
    }
});
