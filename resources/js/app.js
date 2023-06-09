import { drawText, initParticlesJS, initSlider, initDarkMode } from "./functions";

$(function () {
    try {

        One.helpersOnLoad(['jq-select2']);
        Laraberg.init('post_body')
        drawText();
        initParticlesJS();
        initSlider();
        initDarkMode();

        // initEvents();
    } catch (error) {
        console.log(error);
        throw error
    }
});
