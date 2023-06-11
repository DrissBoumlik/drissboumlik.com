
function initGallery(){
    if ($('.js-gallery').length == 0) return;
    One.helpersOnLoad(['jq-magnific-popup']);
}

function initLaraberg() {
    if ($('#post_body').length == 0) return;
    let options = { };
    console.log(options);
    Laraberg.init('post_body', options)
}

function initSelect2() {
    if ($('.js-select2').length == 0) return;
    One.helpersOnLoad(['jq-select2']);
}

function initImageCropper() {
    One.onLoad((() => class {
        static initImageCropper() {
            let e = document.getElementById("js-img-cropper");
            Cropper.setDefaults({ aspectRatio: 4 / 3, preview: ".js-img-cropper-preview" });
            let t = new Cropper(e, { crop: function (e) { } });
            document.querySelectorAll('[data-toggle="cropper"]').forEach((e => {
                e.addEventListener("click", (o => {
                    let a = e.dataset.method || !1, r = e.dataset.option || !1, c = {
                        zoom: () => { t.zoom(r) },
                        setDragMode: () => { t.setDragMode(r) },
                        rotate: () => { t.rotate(r) },
                        scaleX: () => { t.scaleX(r), e.dataset.option = -r },
                        scaleY: () => { t.scaleY(r), e.dataset.option = -r },
                        setAspectRatio: () => { t.setAspectRatio(r) },
                        crop: () => { t.crop() },
                        clear: () => { t.clear() }
                    };
                    c[a] && c[a]() }))
                }))
        }
        static init() { this.initImageCropper() }
    }.init()));
}

function initDataTable() {

}

export { initLaraberg, initSelect2, initGallery, initDataTable, initImageCropper };
