import { initDarkMode, initEvents } from "./functions";
import { initPostEditor, initSelect2, initDatatable, initChart } from "../shared/plugins-use";
import 'lazysizes';


$(function () {
    try {

        initDarkMode();
        initPostEditor();
        try { initSelect2(); } catch (e) {}
        initEvents();
        initDatatable();
        initChart();
    } catch (error) {
    }
});
