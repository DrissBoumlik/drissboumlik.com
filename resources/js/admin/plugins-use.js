function initFlatpickr() {
    if (document.querySelectorAll('.js-flatpickr').length === 0) return;
    One.helpersOnLoad('js-flatpickr');
}
function initSelect2() {
    if (document.querySelectorAll('.js-select2').length === 0) return;
    One.helpersOnLoad(['jq-select2']);
}

export { initSelect2, initFlatpickr };
