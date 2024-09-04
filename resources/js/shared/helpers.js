
function initFlatpickr() {
    if ($('.js-flatpickr').length == 0) return;
    One.helpersOnLoad('js-flatpickr');
}
function initSelect2() {
    if ($('.js-select2').length == 0) return;
    One.helpersOnLoad(['jq-select2']);
}


export { initSelect2, initFlatpickr };
