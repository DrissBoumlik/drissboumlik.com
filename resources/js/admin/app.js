import { initDarkMode, initEvents } from "./functions";
import { initPostEditor, initSelect2, initDatatable, initChart } from "../shared/plugins-use";


$(function () {
    try {

        initDarkMode();
        initPostEditor();
        initSelect2();
        initEvents();
        initDatatable();
        initChart();
    } catch (error) {
    }
});
