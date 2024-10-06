import * as bootstrap from "bootstrap";

document.addEventListener('DOMContentLoaded', function () {
    try {
        if (document.querySelectorAll('[data-toggle]').length !== 0) {
            let tooltipTriggerList = Array.from(document.querySelectorAll('[data-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    } catch (error) {
        // console.log(error);
    }
});
