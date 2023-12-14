import { drawText, initParticlesJS, initSlider, initDarkMode, initEvents, initTooltip } from "./functions";
import $ from 'jquery';
import 'lazysizes';

$(function () {
    try {
        if($('[data-toggle]').length !== 0) {
            initTooltip();
        }
        drawText();
        initParticlesJS();
        if ($('.owl-carousel-wrapper').length !== 0) {
            import('owl.carousel')
                .then(initSlider);
        }
        initDarkMode();
        initEvents();
    } catch (error) {
        // console.log(error);
        throw error
    }
});
