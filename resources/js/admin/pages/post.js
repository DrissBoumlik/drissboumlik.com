import { initFlatpickr, initSelect2, setUpImagePreviewOnFileInput } from "../../shared/helpers";
import {getCookie, get_alert_box, initPostEditor} from "@/shared/functions";
import {string_to_slug} from "@/admin/functions";

document.addEventListener('DOMContentLoaded', function () {
    try {
        initPostEditor();
        try { initSelect2(); } catch (e) {}

        document.addEventListener('focusout', function (event) {
            if (event.target.classList.contains('input-to-slugify')) {
                let postTitle = event.target.value;
                let postSlug = string_to_slug(postTitle);
                // let postSlug = slugify(postTitle, {
                //     // replacement: '-',  // replace spaces with replacement character, defaults to `-`
                //     // remove: undefined, // remove characters that match regex, defaults to `undefined`
                //     lower: true,      // convert to lower case, defaults to `false`
                //     strict: true,     // strip special characters except replacement, defaults to `false`
                //     // locale: 'vi',      // language code of the locale to use
                //     trim: true         // trim leading and trailing replacement chars, defaults to `true`
                // });
                document.querySelectorAll('.input-slug').forEach(input => {
                    input.value = postSlug;
                });
            }
        });

        setUpImagePreviewOnFileInput('image', 'image-preview');

        let viewPostAssetsBtn = document.querySelectorAll('.btn-view-post-assets');
        if (viewPostAssetsBtn.length) {
            viewPostAssetsBtn.forEach(btn => {
                btn.addEventListener('click', function () {
                    let postSlug = document.getElementById('post-slug').value;
                    fetch(`/api/posts/${postSlug}/assets`)
                        .then(response => response.json())
                        .then(data => {
                            let postAssets = data.post_assets;
                            fillPostAssetsModal(postAssets);
                        });
                });
            });
        }

        initFlatpickr();

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-action-post')) {
                e.preventDefault();

                if (!confirm("Are you sure ?")) {
                    return;
                }

                let form = e.target.closest('form');
                let data = new FormData(form);

                let postContent = tinymce.get('post_body').getContent();
                postContent = postContent.replaceAll('<pre class="', '<pre class="loading-spinner ');
                data.set('post_content', postContent);
                data.append('_method', 'PUT');
                data.append(e.target.getAttribute("name"), true);

                console.log(data);
                fetch(form.getAttribute('action'), {
                        method: 'POST',
                        body: data
                    }).then(response => response.json())
                    .then(response => {
                        document.getElementById('link-view-post').setAttribute('href', `/blog/${response.post.slug}?forget=1`);
                        form.setAttribute('action', `/admin/posts/${response.post.slug}`);
                        if (response.post.deleted_at) {
                            const restoreButton = document.createElement('button');
                            restoreButton.type = 'submit';
                            restoreButton.className = 'btn-action btn-action-post btn btn-secondary d-flex justify-content-center align-items-center w-100';
                            restoreButton.name = 'restore';
                            restoreButton.innerHTML = '<i class="fa fa-fw fa-rotate-left me-1"></i> Restore';
                            const deleteButton = document.querySelector('.btn-action-post[name="delete"]');
                            deleteButton.replaceWith(restoreButton);
                        } else {
                            const deleteButton = document.createElement('button');
                            deleteButton.type = 'submit';
                            deleteButton.className = 'btn-action btn-action-post btn btn-warning d-flex justify-content-center align-items-center w-100';
                            deleteButton.name = 'restore';
                            deleteButton.innerHTML = '<i class="fa fa-fw fa-trash me-1"></i> Delete';
                            const restoreButton = document.querySelector('.btn-action-post[name="restore"]');
                            restoreButton.replaceWith(deleteButton);
                        }
                        get_alert_box({ class: response.class, message: response.message, icon: response.icon });
                    }).catch(async (error) => {
                        const response = await error.json();
                        console.log(error, response);
                        get_alert_box({ class: response.class, message: response.message, icon: response.icon });
                    });
            }

        });


        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('btn-action') || e.target.closest('.btn-action') || e.target.closest('#create-post')) {
                e.preventDefault();

                if (!confirm("Are you sure ?")) {
                    return;
                }

                let form = e.target.closest('form');
                let data = new FormData(form);
                data.append(e.submitter.getAttribute("name"), true);
                data.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                fetch(form.getAttribute('action'), {
                    method: 'POST',
                    body: data
                }).then(response => response.json())
                    .then(response => {
                        console.log(response);
                        get_alert_box({ class: response.class, message: response.message, icon: response.icon });
                    })
                    .catch(async (error) => {
                        const response = await error.json();
                        console.log(error, response);
                        get_alert_box({ class: response.class, message: response.message, icon: response.icon });
                    });
            }
        });

    } catch (error) {
        // console.log(error);
    }
});


function fillPostAssetsModal(postAssets){
    let gallery = `<div class="col-12"><div class="text-center p-5">No assets found</div></div>`;
    if (postAssets && postAssets.hasOwnProperty("compressed") && postAssets.compressed.length) {
        gallery = '';
        postAssets.compressed.forEach(function (post_asset) {
            let link_original = post_asset.link.replace('compressed/', '');
            gallery += `<div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-5" style="height: 150px">
                            <div class="post-content-asset h-100 overflow-hidden" style="border-radius: 5px">
                                <a href="${link_original}" target="_blank">
                                    <img src="${post_asset.link}" class="img-fluid w-100 h-100 lazyload"
                                         data-src="${link_original}"
                                         style="object-fit: fill; object-position: top center" alt="">
                                </a>
                            </div>
                            <a href="${post_asset.link}" target="_blank">
                                <span class="fs-sm">${post_asset.filename}</span></a>
                        </div>`;
        });
    }

    let theme = getCookie("theme")
    let modal = `
                    <div class="modal modal-post-assets ${theme}" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Post Assets: ${postAssets.compressed.length} images</h5>
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

    document.body.insertAdjacentHTML('beforeend', modal);

    let modalPostAssets = document.querySelector('.modal-post-assets');
    let closeButtons = document.querySelectorAll('.btn-close, .modal-post-assets');

    closeButtons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            if (e.target !== this) {
                return;
            }
            modalPostAssets.remove();
            let modalBackdrop = document.querySelector('.modal-backdrop');
            if (modalBackdrop) modalBackdrop.remove();
        });
    });

    modalPostAssets.style.display = 'block';
}
