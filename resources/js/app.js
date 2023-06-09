import { drawText, initParticlesJS, initSlider, initDarkMode } from "./functions";

$(function () {
    try {
        Laraberg.init('laraberg_editor')
        drawText();
        initParticlesJS();
        initSlider();
        initDarkMode();

        // initEvents();
    } catch (error) {
        console.log(error);
    }
});
