import { drawText, initParticlesJS, initSlider, initDarkMode, initEvents } from "./functions";
import { initLaraberg, initSelect2, initGallery, initImageCropper, initSyntaxHighlighting, initDatatable, initPostPageEvent } from "./plugins-use";


$(function () {
    init();
});

document.addEventListener('livewire:navigated', () => {
    init();
});

function init() {
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
        setTimeout(() => {
            try { hljs.highlightAll() }
            catch (error) { console.log(error)}
        }, 1000)
    } catch (error) {
        // console.log(error);
        throw error
    }
}
