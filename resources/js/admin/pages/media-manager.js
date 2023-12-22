import { initMediaManagerEvent, displayMedias } from "../functions";

$(function () {
    try {
        initMediaManagerEvent();
        displayMedias();
    } catch (error) {
        // console.log(error);
    }
});
