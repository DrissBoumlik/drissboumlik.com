import { initTooltip } from "../functions";
import $ from 'jquery';

$(function () {
    try {
        if($('[data-toggle]').length !== 0) {
            initTooltip();
        }
    } catch (error) {
        // console.log(error);
    }
});

