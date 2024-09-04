import $ from 'jquery';
import * as bootstrap from "bootstrap";

$(function () {
    try {
        if($('[data-toggle]').length !== 0) {
            let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        }
    } catch (error) {
        // console.log(error);
    }
});

