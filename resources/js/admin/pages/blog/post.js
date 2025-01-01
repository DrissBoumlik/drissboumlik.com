import { setUpImagePreviewOnFileInput, get_alert_box, get_loader, remove_loader, getToken } from "@/admin/tools";
import { initFlatpickr, initSelect2 } from "@/admin/plugins-use";
import { getCookie } from "@/shared/functions";
import { initPostEditor, initCommonFormInputEvents } from "@/admin/pages/blog/helpers";

document.addEventListener('DOMContentLoaded', function () {
    try {
        initPostEditor();
        try { initSelect2(); } catch (e) {}

        initCommonFormInputEvents();

        setUpImagePreviewOnFileInput('post-image', 'post-image-preview');

        let viewPostAssetsBtn = document.querySelectorAll('.btn-view-post-assets');
        if (viewPostAssetsBtn.length) {
            viewPostAssetsBtn.forEach(btn => {
                btn.addEventListener('click', function () {
                    let postSlug = document.getElementById('post-slug').value;
                    get_loader();
                    fetch(`/api/posts/${postSlug}/assets`)
                        .then(response => response.json())
                        .then(data => {
                            remove_loader();
                            let postAssets = data.post_assets;
                            fillPostAssetsModal(postAssets);
                        });
                });
            });
        }

        initFlatpickr();

        document.addEventListener('submit', function (e) {
            if (e.target.classList.contains('btn-action-post') || e.target.closest('.btn-action-post') || e.target.closest('#edit-post')) {
                e.preventDefault();

                if (!confirm("Are you sure ?")) {
                    return;
                }

                let form = e.target.closest('form');
                let data = new FormData(form);

                let postContent = tinymce.get('post-content').getContent();
                postContent = postContent.replaceAll('<pre class="', '<pre class="loading-spinner ');
                data.set('content', postContent);
                data.append('_method', 'PUT');
                const operationName = e.submitter.getAttribute("name");
                data.append(operationName, true);

                get_loader();
                fetch(form.getAttribute('action'), {
                        method: 'POST',
                        body: data
                    }).then(response => response.json())
                    .then(response => {
                        remove_loader();
                        if (operationName) {
                            if (operationName !== "destroy") {
                                if (response.post.deleted_at) {
                                    const restoreButton = document.createElement('button');
                                    restoreButton.type = 'submit';
                                    restoreButton.className = 'btn-action btn-action-post btn btn-secondary d-flex justify-content-center align-items-center w-100';
                                    restoreButton.name = 'restore';
                                    restoreButton.innerHTML = '<i class="fa fa-fw fa-rotate-left me-1"></i> Restore';
                                    const deleteButton = document.querySelector('.btn-action-post[name="delete"]');
                                    if (deleteButton) deleteButton.replaceWith(restoreButton);
                                } else {
                                    const deleteButton = document.createElement('button');
                                    deleteButton.type = 'submit';
                                    deleteButton.className = 'btn-action btn-action-post btn btn-warning d-flex justify-content-center align-items-center w-100';
                                    deleteButton.name = 'restore';
                                    deleteButton.innerHTML = '<i class="fa fa-fw fa-trash me-1"></i> Delete';
                                    const restoreButton = document.querySelector('.btn-action-post[name="restore"]');
                                    if (restoreButton) restoreButton.replaceWith(deleteButton);
                                }
                            }
                        } else {
                            if (response.post?.slug) {
                                window.history.pushState(null,null, `/admin/posts/edit/${response.post.slug}`);
                                document.getElementById('link-view-post').setAttribute('href', `/blog/${response.post.slug}?forget=1`);
                                form.setAttribute('action', `/api/posts/${response.post.slug}`);
                            }
                        }
                        get_alert_box({ class: response.class, message: response.message, icon: response.icon });
                    }).catch(async (error) => {
                    remove_loader();
                        const response = await error.json();
                        console.log(error, response);
                        get_alert_box({ class: response.class, message: response.message, icon: response.icon });
                    });
            }

            if (e.target.classList.contains('btn-action') || e.target.closest('.btn-action') || e.target.closest('#create-post')) {
                e.preventDefault();

                if (!confirm("Are you sure ?")) {
                    return;
                }

                let form = e.target.closest('form');
                let data = new FormData(form);
                data.append(e.submitter.getAttribute("name"), true);
                data.append("_token", getToken());

                get_loader();
                fetch(form.getAttribute('action'), {
                    method: 'POST',
                    body: data
                }).then(response => response.json())
                    .then(response => {
                        remove_loader();
                        console.log(response);
                        get_alert_box({ class: response.class, message: response.message, icon: response.icon });
                    })
                    .catch(async (error) => {
                        remove_loader();
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
