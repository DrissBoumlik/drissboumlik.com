import {get_alert_box} from "../../shared/functions";

$(function () {
    try {

        $(document).on('click', '.file-operation', function() {

            let operation = this.getAttribute('data-action');
            let file_name = this.getAttribute('data-name');
            let file_path = this.getAttribute('data-path').replace('\\', '/');

            let modal = `
                <div class="modal modal-operation-details" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title capitalize-first-letter">${operation} file : ${file_name}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="file-operation-form" class="file-operation-form">
                                    <input type="hidden" name="file_name" value="${file_name}" />
                                    <div class="mb-3">
                                        <label for="src-path" class="form-label">Source :</label>
                                        <input type="text" class="form-control" id="src-path" name="src-path"
                                                readonly value="${file_path}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="dest-path" class="form-label">Destination :</label>
                                        <div class="input-group mb-3">
                                          <span class="input-group-text" id="basic-addon3">storage/</span>
                                            <input type="text" class="form-control" id="dest-path" name="dest-path"
                                                   placeholder="new/directory" aria-describedby="basic-addon3">
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
                url: '/api/file/copy',
                data: data,
                success: function (response) {
                    console.log(response);
                    get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
                    displayFiles();
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
                    displayFiles();
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
                url: '/api/file',
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
                    displayFiles();
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
                const regex = new RegExp(`/admin/file-manager/\?`, 'g');
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
                        displayFiles();
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
                        displayFiles();
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        console.log(jqXHR, textStatus, errorThrown);
                        get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.msg, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                    }
                });
            });
        }

        $(document).on('click', '.file-link', function(e) {
            e.preventDefault();
            displayFiles(this.getAttribute('data-href'));
        });

        $(document).on('mousedown', '.file-name-text', function(e) {
            this.setAttribute('contenteditable', true)
        });
        $(document).on('focusout', '.file-name-text', function(e) {
            this.setAttribute('contenteditable', false)
        });
        $(document).on('keydown', '.file-name-text', function(e) {
                if (e.key === 'Enter') {
                    if (!confirm("Are you sure ?")) {
                        return;
                    }
                    this.setAttribute('contenteditable', false)
                    let new_name = this.innerText.trim();
                    let old_name = this.getAttribute('data-file-name').trim();
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
                        url: '/api/file/rename',
                        data: data,
                        success: function (response) {
                            console.log(response);
                            get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
                            displayFiles();
                        },
                        error: function (jqXHR, textStatus, errorThrown){
                            console.log(jqXHR, textStatus, errorThrown);
                            get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.msg, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                        }
                    });
                }
            });

        displayFiles();
    } catch (error) {
        // console.log(error);
    }
});

function displayFiles(pathname = null) {
    if (!pathname) {
        const regex = new RegExp(`/admin/file-manager/\?`, 'g');
        pathname = window.location.pathname.replace(regex, '')
        if (pathname.startsWith('/')) pathname = pathname.replace('/', '')
    } else {
        window.history.pushState(null,null, `/admin/file-manager/${pathname}`);
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
        url: `/api/files/${pathname}`,
        success: function (response) {
            let data = response.data;
            $('#current-path').val(data.current_path);
            $('#previous-path').attr('href', `/admin/file-manager/${data.previous_path || ''}`)
                .attr('data-href', data.previous_path);
            $('#breadcrumb').html(data.breadcrumb.breadcrumb);

            let directoriesDOM = '<div class="col-12"><div class="text-center p-5">No directories found</div></div>';
            if(data?.content?.directories && data?.content?.directories?.length) {
                directoriesDOM = '';
                data.content.directories.forEach(function(dir) {
                    directoriesDOM += `<div class="col-6 col-sm-4 col-md-3 mb-4 file-item-wrapper">
                                        <div class="directory file-item mb-2">
                                            <a href="#" class="file-item-link file-link" data-href="${dir.path}" class="file-item-link">
                                                <div class="directory-icon w-100 h-100"><i class="fa-solid fa-folder-open"></i></div>
                                            </a>
                                            <div class="directory-name w-100 h-100">
                                                <span title="${dir.name}" class="file-name-text"
                                                    data-file-name="${dir.name}">${dir.name}</span>
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
                    filesDOM += `<div class="col-6 col-sm-4 col-md-3 mb-4 file-item-wrapper">
                                    <div class="file file-item mb-2">
                                        <a href="/${file._pathname }" class="file-item-link" data-href="${file._pathname}" target="_blank" class="file-item-link">`;
                    if (file._mimeType.includes('image')) {
                        filesDOM += `<div class="file-image h-100">
                                        <img src="/${file._pathname}" class="img-fluid w-100 h-100" alt="${file._filename}"/>
                                    </div>`;
                    } else {
                        filesDOM+= `<div class="file-icon w-100 h-100"><i class="fa-solid fa-file"></i></div>`;
                    }
                    filesDOM += `</a><div class="file-name w-100">
                                        <span title="${file._filename}" class="file-name-text"
                                            data-file-name="${file._filename}">${file._filename}</span>
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
