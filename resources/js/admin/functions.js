// import 'bootstrap';
import {getCookie, toggleDarkMode} from "../shared/functions";
import { initSelect2 } from "../shared/plugins-use";

function string_to_slug(str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "åàáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to = "aaaaaaeeeeiiiioooouuuunc------";

    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str
        .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-') // collapse dashes
        .replace(/^-+/g, '') // trim - from start of text
        .replace(/-+$/g, ''); // trim - from end of text

    return str;
}

function initDarkMode() {
    $(document).on('click', '.toggle-dark-mode-admin', function () {
        toggleDarkMode($('#page-container'),
            {darkmode: 'page-header-dark dark-mode sidebar-dark', lightmode: 'light-mode'},
            {name: 'theme', darkmodeValue: 'dark-mode', lightmodeValue: 'light-mode'});

    });
}

let postAssets = null;
function initEvents() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    $('.btn-export').on('click', function() {
        let tablesNames = null;
        if (!$('#export-all-tables').prop('checked')) {
            tablesNames = '';
            document.querySelectorAll('#tables .table-item').forEach(function (e) {
                if (e.checked) {
                    tablesNames += e.closest('tr').querySelector('.table-name').innerText + ' ';
                }
            });
            tablesNames = tablesNames.trim();
        }
        let dontCreateTables = $('#do-not-create-tables').prop('checked');
        let queryString = `
            ${tablesNames ? 'tables=' + tablesNames : ''}
            &
            ${dontCreateTables ? 'dontCreateTables=1' : ''}
        `;
        console.log(queryString.trim());
        window.open('/admin/export-db?' + queryString);
    });

    One.helpersOnLoad('js-flatpickr');


    $(document).on('focusout', '.input-to-slugify', function () {
        let postTitle = $(this).val();
        let postSlug = string_to_slug(postTitle)
        // let postSlug = slugify(postTitle, {
        //     // replacement: '-',  // replace spaces with replacement character, defaults to `-`
        //     // remove: undefined, // remove characters that match regex, defaults to `undefined`
        //     lower: true,      // convert to lower case, defaults to `false`
        //     strict: true,     // strip special characters except replacement, defaults to `false`
        //     // locale: 'vi',      // language code of the locale to use
        //     trim: true         // trim leading and trailing replacement chars, defaults to `true`
        // });
        $('.input-slug').val(postSlug);
    });

    let imageElement = document.getElementById('image')
    if (imageElement) {
        imageElement.onchange = (event) => {
            if (event.target.files.length > 0) {
                let src = URL.createObjectURL(event.target.files[0]);
                let preview = document.getElementById("image-preview");
                preview.src = src;

                // initImageCropper();
            }
        };
    }

    let viewPostAssetsBtn = $('.btn-view-post-assets')
    if (viewPostAssetsBtn.length) {
        viewPostAssetsBtn.on('click', function() {

            if (!postAssets || !postAssets.length) {
                $.ajax({
                    type: 'GET',
                    url: `/api/posts/${$('#post-slug').val()}/assets`,
                    success: function (response) {
                        postAssets = response.post_assets;
                        fillPostAssetsModal(postAssets);
                    }
                });
            } else {
                fillPostAssetsModal(postAssets);
            }
        });
    }

    let show_password_btn = $('.show-password');
    if (show_password_btn.length) {
        show_password_btn.on('click', function() {
            let input_password = $(this).siblings('input');
            let type = input_password.attr('type') === 'text' ? 'password' : 'text';
            input_password.attr('type', type);
        });
    }

}

function fillPostAssetsModal(postAssets){
    let gallery = ``;
    postAssets.forEach(function (post_asset) {
        let link_original = post_asset.link.replace('--compressed', '');
        gallery += `<div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-5" style="height: 150px">
                                        <div class="post-content-asset h-100 overflow-hidden" style="border-radius: 5px">
                                        <img src="${post_asset.link}" class="img-fluid w-100 h-100 lazyload"
                                         data-src="${link_original}"
                                         style="object-fit: fill; object-position: top center" alt=""></div>
                                        <a href="${post_asset.link}" target="_blank">
                                        <span class="fs-sm">${post_asset.filename}</span></a>
                                        </div>`;
    });

    let theme = getCookie("theme")
    let modal = `
                    <div class="modal modal-post-assets ${theme}" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Post Assets: ${postAssets.length} images</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row">${gallery}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-backdrop fade show"></div>`;
    $('body').append(modal);
    let modalPostAssets = $('.modal-post-assets');
    $('.btn-close').add('.modal-post-assets').on('click', function (e) {
        if (e.target !== modalPostAssets[0] && e.target !== $('.btn-close')[0]) {
            return;
        }
        modalPostAssets.remove();
        $('.modal-backdrop').remove();
    });
    modalPostAssets.show();
}

function shortenTextIfLongByLength(text, length, end = '...'){
    return text.length < length ? text : text.substring(0, length) + end;
}

function getDomClass(status) {
    let classes = [
        {'value' : 0, 'class' : 'bg-gray text-gray-dark', 'text' : 'Draft'},
        {'value' : 1, 'class' : 'bg-warning-light text-warning', 'text' : 'Pending'},
        {'value' : 2, 'class' : 'bg-success-light text-success', 'text' : 'Published'},
    ]
    return classes[status];
}

export { initDarkMode, initEvents, shortenTextIfLongByLength, getDomClass };
