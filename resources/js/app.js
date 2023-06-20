import { drawText, initParticlesJS, initSlider, initDarkMode, initEvents } from "./functions";
import { initLaraberg, initSelect2, initGallery, initImageCropper, initSyntaxHighlighting } from "./plugins-use";


$(function () {
    try {

        // drawText();
        initParticlesJS();
        initSlider();
        initDarkMode();

        initLaraberg();
        initSelect2();
        initGallery();
        initSyntaxHighlighting();
        // initImageCropper();
        initEvents();
    } catch (error) {
        // console.log(error);
        throw error
    }
});
