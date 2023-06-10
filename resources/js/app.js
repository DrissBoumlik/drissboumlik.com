import { drawText, initParticlesJS, initSlider, initDarkMode, initEvents } from "./functions";
import { initLaraberg, initSelect2, initImageCropper } from "./plugins-use";


$(function () {
    try {
        drawText();
        initParticlesJS();
        initSlider();
        initDarkMode();

        initLaraberg();
        initSelect2();
        // initImageCropper();
        initEvents();
    } catch (error) {
        // console.log(error);
        throw error
    }
});
