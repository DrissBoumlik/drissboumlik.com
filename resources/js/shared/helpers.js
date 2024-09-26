
function initFlatpickr() {
    if ($('.js-flatpickr').length == 0) return;
    One.helpersOnLoad('js-flatpickr');
}
function initSelect2() {
    if ($('.js-select2').length == 0) return;
    One.helpersOnLoad(['jq-select2']);
}

function setUpImagePreviewOnFileInput(inputFileElementID, imageElementID) {
    let imageElement = document.getElementById(inputFileElementID)
    if (imageElement) {
        imageElement.onchange = (event) => {
            if (event.target.files.length > 0) {
                let src = URL.createObjectURL(event.target.files[0]);
                let preview = document.getElementById(imageElementID);
                preview.src = src;
            }
        };
    }
}

export { initSelect2, initFlatpickr, setUpImagePreviewOnFileInput };
