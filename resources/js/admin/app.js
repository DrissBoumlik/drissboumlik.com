import { initDarkMode, initEvents } from "./functions";
import { initPostEditor, initSelect2, initDatatable } from "./plugins-use";


$(function () {
    try {

        initDarkMode();
        initPostEditor();
        initSelect2();
        initEvents();
        initDatatable();
    } catch (error) {
    }
});
