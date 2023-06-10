import { drawText, initParticlesJS, initSlider, initDarkMode } from "./functions";

$(function () {
    try {

        Laraberg.init('post_body')
        One.helpersOnLoad(['jq-select2']);
        drawText();
        initParticlesJS();
        initSlider();
        initDarkMode();

        // initEvents();
    } catch (error) {
        // console.log(error);
        throw error
    }
});
