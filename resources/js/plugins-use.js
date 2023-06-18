
function initGallery() {
    if ($('.js-gallery').length == 0) return;
    One.helpersOnLoad(['jq-magnific-popup']);
}

function initLaraberg() {
    if ($('#post_body').length == 0) return;
    let options = { };
    Laraberg.init('post_body', options)
}

function initSelect2() {
    if ($('.js-select2').length == 0) return;
    One.helpersOnLoad(['jq-select2']);
}
let t = null;
function initImageCropper() {
    let e = document.getElementById("js-img-cropper");
    if (e == null) return;

    if (t) {
        t.destroy();
    }

    One.onLoad((() => class {
        static initImageCropper() {
            Cropper.setDefaults({ aspectRatio: 16 / 9, preview: ".js-img-cropper-preview" });
            t = new Cropper(e, { crop: function (e) {

                } });
            document.querySelectorAll('[data-toggle="cropper"]').forEach((e => {
                e.addEventListener("click", (o => {
                    let a = e.dataset.method || !1, r = e.dataset.option || !1, c = {
                        // crop: () => { t.getData() },
                        zoom: () => { t.zoom(r) },
                        setDragMode: () => { t.setDragMode(r) },
                        rotate: () => { t.rotate(r) },
                        scaleX: () => { t.scaleX(r), e.dataset.option = -r },
                        scaleY: () => { t.scaleY(r), e.dataset.option = -r },
                        setAspectRatio: () => { t.setAspectRatio(r) },
                        crop: () => { t.crop() },
                        clear: () => { t.clear() }
                    };
                    c[a] && c[a]()
                }));
            }));
        }
        static init() { this.initImageCropper() }
    }.init()));
}



export { initLaraberg, initSelect2, initGallery, initImageCropper };
