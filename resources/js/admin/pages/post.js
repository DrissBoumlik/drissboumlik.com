import { initFlatpickr, initSelect2, setUpImagePreviewOnFileInput } from "../../shared/helpers";
import {getCookie} from "@/shared/functions";
import {string_to_slug} from "@/admin/functions";

$(function () {
    try {
        initPostEditor();
        try { initSelect2(); } catch (e) {}

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

        setUpImagePreviewOnFileInput('image', 'image-preview');

        let viewPostAssetsBtn = $('.btn-view-post-assets')
        if (viewPostAssetsBtn.length) {
            viewPostAssetsBtn.on('click', function () {
                let post_slug = $('#post-slug').val();
                $.ajax({
                    type: 'GET',
                    url: `/api/posts/${post_slug}/assets`,
                    success: function (response) {
                        let postAssets = response.post_assets;
                        fillPostAssetsModal(postAssets);
                    }
                });
            });
        }

        initFlatpickr();

        $(document).on('click', '.btn-action', function (e) {
            e.preventDefault();

            if (!confirm("Are you sure ?")) {
                return;
            }

            $(this).closest('form').submit();
        });

    } catch (error) {
        // console.log(error);
    }
});

function initPostEditor() {
    if ($('#post_body').length == 0) return;
    let options = {
        selector: 'textarea#post_body',
        plugins: `searchreplace autolink visualblocks visualchars media charmap nonbreaking anchor insertdatetime
                lists advlist wordcount help emoticons autosave code link table codesample image preview pagebreak
                accordion`,
        toolbar: `code codesample emoticons link image pagebreak | undo redo restoredraft | bold italic underline
                | alignleft aligncenter alignright alignjustify lineheight indent outdent | bullist numlist
                | accordion visualblocks visualchars searchreplace`,
        pagebreak_separator: '<hr/>',
        height: 700,
        fixed_toolbar_container: '.tox-editor-header',
        codesample_languages: [
            { text: 'Bash', value: 'bash' },
            { text: 'Typscript', value: 'typscript' },
            { text: 'Markdown', value: 'markdown' },
            { text: 'Pug', value: 'pug' },
            { text: 'Sass', value: 'sass' },
            { text: 'Yaml', value: 'yaml' },
            { text: 'SQL', value: 'sql' },
            { text: 'Powershell', value: 'powershell' },
            { text: 'DOS', value: 'dos' },
            { text: 'Batch', value: 'batch' },
            { text: 'HTML/XML', value: 'markup' },
            { text: 'CSS', value: 'css' },
            { text: 'JavaScript', value: 'javascript' },
            { text: 'PHP', value: 'php' },
            { text: 'Ruby', value: 'ruby' },
            { text: 'Python', value: 'python' },
            { text: 'Java', value: 'java' },
            { text: 'C', value: 'c' },
            { text: 'C#', value: 'csharp' },
            { text: 'C++', value: 'cpp' }
        ],
    };
    let theme = getCookie('theme');
    if (theme === 'dark-mode') {
        options = {...options,  skin: 'oxide-dark', content_css: 'dark'};
    }
    let tinymceDOM = tinymce.get('post_body');
    if(tinymceDOM != null) {
        let _content = tinymceDOM.getContent();
        tinymceDOM.destroy();
        tinymceDOM.setContent(_content);
    }
    tinymce.init(options);
}

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

export { initPostEditor }
