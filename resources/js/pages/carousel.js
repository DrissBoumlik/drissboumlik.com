import { initSlider } from "../functions";
import $ from 'jquery';

$(function () {
    try {
        if ($('.owl-carousel-wrapper').length !== 0) {
            import('owl.carousel')
                .then(initSlider);
        }
    } catch (error) {
        // console.log(error);
    }
});
