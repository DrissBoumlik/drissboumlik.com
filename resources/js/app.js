import { drawText, initParticlesJS, initSlider, initDarkMode, initEvents } from "./functions";
import { initPostEditor, initSelect2, initGallery, initImageCropper, initSyntaxHighlighting, initDatatable, initPostPageEvent } from "./plugins-use";


$(function () {
    try {

        // drawText();
        initParticlesJS();
        initSlider();
        initDarkMode();

        initPostEditor();
        initSelect2();
        // initGallery();
        initSyntaxHighlighting();
        // initImageCropper();
        initEvents();
        initDatatable();
        // initPostPageEvent();
    } catch (error) {
        // console.log(error);
        throw error
    }
});
