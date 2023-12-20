import { initFlatpickr, initPostEditor, initSelect2 } from "../../shared/plugins-use";
import { initBlogEvents } from "../functions";

$(function () {
    try {
        initPostEditor();
        try { initSelect2(); } catch (e) {}
        initBlogEvents();
        initFlatpickr();
    } catch (error) {
        // console.log(error);
    }
});
