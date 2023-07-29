import { drawText, initParticlesJS, initSlider, initDarkMode, initEvents } from "./functions";
import { initLaraberg, initSelect2, initGallery, initImageCropper, initSyntaxHighlighting, initDatatable, initPostPageEvent } from "./plugins-use";


$(function () {
    try {

        // drawText();
        initParticlesJS();
        initSlider();
        initDarkMode();

        initLaraberg();
        initSelect2();
        initGallery();
        // initSyntaxHighlighting();
        // initImageCropper();
        initEvents();
        initDatatable();
        initPostPageEvent();

    } catch (error) {
        // console.log(error);
        throw error
    }
});
