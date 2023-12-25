// import 'bootstrap';
import {get_alert_box, get_loader, getCookie, toggleDarkMode} from "../shared/functions";

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
function initAjaxEvents() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    $( document ).on( "ajaxSend", function(event, jqxhr, settings) {
        if (settings.url.startsWith('/api')) {
            get_loader();
        }
    });
    $( document ).on( "ajaxComplete", function(event, jqxhr, settings) {
        let loader = $('.spinner-global');
        if (loader.length) {
            loader.remove();
        }
    });
}

function fillPostAssetsModal(postAssets){
    let gallery = `<div class="col-12"><div class="text-center p-5">No assets found</div></div>`;
    if (postAssets && postAssets.length) {
        gallery = '';
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
    }

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

function initBlogEvents() {

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
}

function initExport() {
    let btnExport = $('.btn-export');
    if (btnExport.length) {
        btnExport.on('click', function () {
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
            ${dontCreateTables ? 'dontCreateTables=1' : ''}`;
            window.open('/admin/export-db?' + queryString);
        });
    }

    let btnExportAll = $('#export-all-tables');
    if (btnExportAll.length) {
        btnExportAll.on('click', function() {
            $('.table-item').prop('checked', this.checked)
        });
    }
}


function initMediaManagerEvent() {

    $(document).on('click', '.file-operation', function() {

        let operation = this.getAttribute('data-action');
        let media_name = this.getAttribute('data-name');
        let media_path = this.getAttribute('data-path').replace('\\', '/');

        let modal = `
            <div class="modal modal-operation-details" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title capitalize-first-letter">${operation} file : ${media_name}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="file-operation-form" class="file-operation-form">
                                <input type="hidden" name="media_name" value="${media_name}" />
                                <div class="mb-3">
                                    <label for="src-path" class="form-label">Source :</label>
                                    <input type="text" class="form-control" id="src-path" name="src-path"
                                            readonly value="${media_path}">
                                </div>
                                <div class="mb-3">
                                    <label for="dest-path" class="form-label">Dest :</label>
                                    <div class="input-group mb-3">
                                      <span class="input-group-text" id="basic-addon3">storage/</span>
                                        <input type="text" class="form-control" id="dest-path" name="dest-path"
                                                aria-describedby="basic-addon3">
                                    </div>
                                </div>
                                <div class="mb-3 d-flex column-gap-2">
                                    <button type="submit" value="copy" class="btn tc-blue-dark-1-outline tc-blue-dark-1-bg-hover w-100 btn-submit"><i class="fa-solid fa-copy me-2"></i>Copy</button>
                                    <button type="submit" value="move" class="btn tc-red-light-outline tc-red-light-bg-hover w-100 btn-submit"><i class="fa-solid fa-file-export me-2"></i>Move</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>`;
        $('body').append(modal);
        let modalOperationDetails = $('.modal-operation-details');
        $('.btn-close').add('.modal-operation-details').on('click', function(e) {
            if (e.target != modalOperationDetails[0] && e.target != $('.btn-close')[0]) {
                return;
            }
            modalOperationDetails.remove();
            $('.modal-backdrop').remove();
        });
        modalOperationDetails.show()
    });

    $(document).on('submit', '.file-operation-form', function(e) {
        e.preventDefault();
        if (!confirm("Are you sure ?")) {
            return;
        }
        let data = $(this).serializeArray();
        data.push({name: 'operation', value: e.originalEvent.submitter.value});
        console.log(data);
        $.ajax({
            method: 'POST',
            url: '/api/media/copy',
            data: data,
            success: function (response) {
                console.log(response);
                get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
                displayMedias();
            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log(jqXHR, textStatus, errorThrown);
                get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.msg, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
            }
        });
    });

    $(document).on('click', '.delete-file', function() {
        if (!confirm("Are you sure ?")) {
            return;
        }
        let _this = $(this);
        let path = _this.data('path');
        let name = _this.data('name');
        $.ajax({
            type: 'DELETE',
            url: `/api/path/${path}/name/${name}`,
            success: function (response) {
                console.log(response);
                get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
                displayMedias();
            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log(jqXHR, textStatus, errorThrown);
                get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.msg, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
            }
        });
    });

    let formUploadFiles = $('#form-upload-files');
    formUploadFiles.on('submit', function(e) {
        e.preventDefault();
        if (!confirm("Are you sure ?")) {
            return;
        }
        let form = document.getElementById('form-upload-files');
        let data = new FormData(form);
        let currentPath = $('#current-path').val();
        data.append('path', currentPath);
        $.ajax({
            method: 'POST',
            url: '/api/media',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                console.log(response);
                get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
                displayMedias();
            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log(jqXHR, textStatus, errorThrown);
                get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.msg, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
            }
        });
    });


    let formCreateDirectories = $('#form-create-directories');
    if (formCreateDirectories.length) {
        formCreateDirectories.on('submit', function(e) {
            e.preventDefault();
            if (!confirm("Are you sure ?")) {
                return;
            }
            const regex = new RegExp(`/admin/media-manager/\?`, 'g');
            let currentPath = window.location.pathname.replaceAll(regex, '');
            if (currentPath === "") {
                currentPath = "storage";
            }
            let directoriesNames = $('#directories-names').val().trim();
            if (directoriesNames === "") {
                get_alert_box({class: 'alert-warning', message: "Empty inputs !!", icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                return;
            }
            directoriesNames = directoriesNames.split(';').map(function(dirName){
                return dirName.trim().replaceAll(/ +/gi, ' ');
            });
            $.ajax({
                method: 'POST',
                url: '/api/directories',
                data: {directoriesNames, currentPath},
                success: function (response) {
                    console.log(response);
                    get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
                    displayMedias();
                },
                error: function (jqXHR, textStatus, errorThrown){
                    console.log(jqXHR, textStatus, errorThrown);
                    get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.msg, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                }
            });
        });
    }

    let emptyTrashBtn = $('.btn-empty-trash');
    if (emptyTrashBtn.length) {
        emptyTrashBtn.on('click', function() {
            if (!confirm("Are you sure ?")) {
                return;
            }
            $.ajax({
                type: 'DELETE',
                url: `/api/directories/storage/trash`,
                success: function (response) {
                    console.log(response);
                    get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
                },
                error: function (jqXHR, textStatus, errorThrown){
                    console.log(jqXHR, textStatus, errorThrown);
                    get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.msg, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                }
            });
        });
    }

    $(document).on('click', '.media-link', function(e) {
        e.preventDefault();
        displayMedias(this.getAttribute('data-href'));
    });

    $(document).on('mousedown', '.media-name', function(e) {
        this.setAttribute('contenteditable', true)
    });
    $(document).on('focusout', '.media-name', function(e) {
        this.setAttribute('contenteditable', false)
    });
    $(document).on('keydown', '.media-name', function(e) {
        if (e.key === 'Enter') {
            if (!confirm("Are you sure ?")) {
                return;
            }
            this.setAttribute('contenteditable', false)
            let new_name = this.innerText.trim();
            let old_name = this.getAttribute('data-media-name').trim();
            if (old_name === '' || new_name === '') {
                get_alert_box({class: 'alert-danger', message: "Names should not be empty", icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                this.innerText = old_name;
                return;
            }
            let data = {
                new_name: new_name,
                old_name: old_name,
                path: $('#current-path').val(),
            }

            $.ajax({
                method: 'POST',
                url: '/api/media/rename',
                data: data,
                success: function (response) {
                    console.log(response);
                    get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
                    displayMedias();
                },
                error: function (jqXHR, textStatus, errorThrown){
                    console.log(jqXHR, textStatus, errorThrown);
                    get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.msg, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                }
            });
        }
    });
}

function displayMedias(pathname = null) {
    if (!pathname) {
        const regex = new RegExp(`/admin/media-manager/\?`, 'g');
        pathname = window.location.pathname.replace(regex, '')
        if (pathname.startsWith('/')) pathname = pathname.replace('/', '')
    } else {
        window.history.pushState(null,null, `/admin/media-manager/${pathname}`);
    }
    let spinner = `<div class="col-12 text-center p-5">
                    <div class="spinner-border" role="status"
                         style="width: 3rem; height: 3rem;
                         border-color: var(--tc-grey-dark) transparent var(--tc-grey-dark) var(--tc-grey-dark);" >
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>`;
    $('#files').html(spinner);
    $('#directories').html(spinner)

    $.ajax({
        type: 'GET',
        url: `/api/medias/${pathname}`,
        success: function (response) {
            let data = response.data;
            $('#current-path').val(data.current_path);
            $('#previous-path').attr('href', `/admin/media-manager/${data.previous_path || ''}`)
                .attr('data-href', data.previous_path);
            $('#breadcrumb').html(data.breadcrumb.breadcrumb);

            let directoriesDOM = '<div class="col-12"><div class="text-center p-5">No directories found</div></div>';
            if(data?.content?.directories && data?.content?.directories?.length) {
                directoriesDOM = '';
                data.content.directories.forEach(function(dir) {
                    directoriesDOM += `<div class="col-6 col-sm-4 col-md-3 mb-4 media-item-wrapper">
                                        <div class="directory media-item mb-2">
                                            <a href="#" class="media-item-link media-link" data-href="${dir.path}" class="media-item-link">
                                                <div class="directory-icon w-100 h-100"><i class="fa-solid fa-folder-open"></i></div>
                                            </a>
                                            <div class="directory-name w-100 h-100">
                                                <span title="${dir.name}" class="media-name capitalize-first-letter"
                                                    data-media-name="${dir.name}">${dir.name}</span>
                                            </div>
                                        </div>
                                        <div class="action-btns">
                                            <button type="submit" class="btn btn-outline-info w-100 file-operation" title="Copy File"
                                                    data-name="${dir.name}" data-action="copy" data-path="${dir.path}"><i class="fa-solid fa-file"></i></button>
                                            <button type="submit" class="btn btn-outline-danger w-100 delete-file" title="Delete File"
                                                    data-name="${dir.name}" data-path="${dir.path}"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </div>`;
                });
            }
            $('#directories').html(directoriesDOM)

            let filesDOM = '<div class="col-12"><div class="text-center p-5">No files found</div></div>';
            if(data?.content?.files && data?.content?.files?.length) {
                filesDOM = '';
                data.content.files.forEach(function(file) {
                    filesDOM += `<div class="col-6 col-sm-4 col-md-3 mb-4 media-item-wrapper">
                                    <div class="file media-item mb-2">
                                        <a href="/${file._pathname }" class="media-item-link" data-href="${file._pathname}" target="_blank" class="media-item-link">`;
                    if (file._mimeType.includes('image')) {
                        filesDOM += `<div class="file-image h-100">
                                        <img src="/${file._pathname}" class="img-fluid w-100 h-100" alt="${file._filename}"/>
                                    </div>`;
                    } else {
                        filesDOM+= `<div class="file-icon w-100 h-100"><i class="fa-solid fa-file"></i></div>`;
                    }
                    filesDOM += `</a><div class="file-name w-100">
                                        <span title="${file._filename}" class="media-name capitalize-first-letter"
                                            data-media-name="${file._filename}">${file._filename}</span>
                                    </div>`;
                    filesDOM += `</div><div class="action-btns">
                                        <button type="submit" class="btn btn-outline-info w-100 file-operation" title="Copy File"
                                                data-name="${file._filename}" data-action="copy" data-path="${file._pathname}"><i class="fa-solid fa-file"></i></button>
                                        <button type="submit" class="btn btn-outline-danger w-100 delete-file" title="Delete File"
                                                data-name="${file._filename}" data-path="${file._pathname}"><i class="fa-solid fa-trash"></i></button>
                                    </div></div>`;
                });
            }
            $('#files').html(filesDOM);
        }
    });
}

export { initDarkMode, initAjaxEvents, shortenTextIfLongByLength, getDomClass, initBlogEvents, initExport, initMediaManagerEvent, displayMedias };
