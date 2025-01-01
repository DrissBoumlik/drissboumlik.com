import { get_alert_box, getToken } from "@/admin/tools";

document.addEventListener('DOMContentLoaded', function () {
    try {

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('file-operation') || e.target.closest('.file-operation')) {
                const target = e.target.closest('.file-operation');
                const operation = target.getAttribute('data-action');
                const fileName = target.getAttribute('data-name');
                const filePath = target.getAttribute('data-path').replace('\\', '/');

                const modal = `
                <div class="modal modal-operation-details" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title capitalize-first-letter">${operation} file : ${fileName}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="file-operation-form" class="file-operation-form">
                                    <input type="hidden" name="file_name" value="${fileName}" />
                                    <div class="mb-3">
                                        <label for="src-path" class="form-label">Source :</label>
                                        <input type="text" class="form-control" id="src-path" name="src-path"
                                                readonly value="${filePath}">
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

                document.body.insertAdjacentHTML('beforeend', modal);

                const modalOperationDetails = document.querySelector('.modal-operation-details');
                const closeModal = () => {
                    modalOperationDetails.remove();
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                };

                modalOperationDetails.style.display = 'block';

                // Close modal on button click or clicking outside the modal
                modalOperationDetails.addEventListener('click', function (event) {
                    if (event.target === modalOperationDetails || event.target.classList.contains('btn-close')) {
                        closeModal();
                    }
                });
            }

            if (e.target.classList.contains('delete-file') || e.target.closest('.delete-file')) {
                if (!confirm("Are you sure ?")) {
                    return;
                }

                const target = e.target.closest('.delete-file');
                const path = target.getAttribute('data-path');
                const name = target.getAttribute('data-name');

                fetch(`/api/path/${path}/name/${name}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getToken()
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        get_alert_box({ class: 'alert-info', message: data.message, icon: '<i class="fa-solid fa-check-circle"></i>' });
                        displayFiles();
                    })
                    .catch(error => {
                        console.error(error);
                        get_alert_box({ class: 'alert-danger', message: error.message, icon: '<i class="fa-solid fa-triangle-exclamation"></i>' });
                    });
            }

            if (e.target.classList.contains('file-link') || e.target.closest('.file-link')) {
                e.preventDefault();
                displayFiles(e.target.closest('.file-link').getAttribute('data-href'));
            }

            if (e.target.classList.contains('submit-new-file-name') || e.target.closest('.submit-new-file-name')) {
                renameItem(e.target.closest('.submit-new-file-name').nextElementSibling);
            }
        });


        document.addEventListener('submit', function (e) {
            if (e.target.classList.contains('file-operation-form')) {
                e.preventDefault();
                if (!confirm("Are you sure ?")) {
                    return;
                }

                const formData = new FormData(e.target);
                formData.append('operation', e.submitter.value);
                formData.append('_token', getToken());

                fetch('/api/file/copy', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        get_alert_box({ class: 'alert-info', message: data.message, icon: '<i class="fa-solid fa-check-circle"></i>' });
                        displayFiles();
                    })
                    .catch(error => {
                        console.error(error);
                        get_alert_box({ class: 'alert-danger', message: error.message, icon: '<i class="fa-solid fa-triangle-exclamation"></i>' });
                    });
            }
        });




        const formUploadFiles = document.getElementById('form-upload-files');
        formUploadFiles.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!confirm("Are you sure ?")) {
                return;
            }
            const formData = new FormData(formUploadFiles);
            const currentPath = document.getElementById('current-path').value;
            formData.append('path', currentPath);
            formData.append('_token', getToken());

            fetch('/api/file', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(response => {
                    console.log(response);
                    get_alert_box({
                        class: 'alert-info',
                        message: response.message,
                        icon: '<i class="fa-solid fa-check-circle"></i>'
                    });
                    displayFiles();
                })
                .catch(error => {
                    console.error(error);
                    get_alert_box({
                        class: 'alert-danger',
                        message: error.message || 'An error occurred',
                        icon: '<i class="fa-solid fa-triangle-exclamation"></i>'
                    });
                });
        });


        const formCreateDirectories = document.querySelector('#form-create-directories');
        if (formCreateDirectories) {
            formCreateDirectories.addEventListener('submit', function (e) {
                e.preventDefault();
                if (!confirm("Are you sure ?")) {
                    return;
                }
                const regex = new RegExp(`/admin/file-manager/\\?`, 'g');
                let currentPath = window.location.pathname.replace(regex, '');
                if (currentPath === "") {
                    currentPath = "storage";
                }
                const directoriesInput = document.querySelector('#directories-names');
                let directoriesNames = directoriesInput.value.trim();
                if (directoriesNames === "") {
                    get_alert_box({
                        class: 'alert-warning',
                        message: "Empty inputs !!",
                        icon: '<i class="fa-solid fa-triangle-exclamation"></i>'
                    });
                    return;
                }
                directoriesNames = directoriesNames.split(';').map(dirName =>
                    dirName.trim().replace(/ +/g, ' ')
                );

                let data = { directoriesNames, currentPath };

                fetch('/api/directories', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getToken()
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(response => {
                        console.log(response);
                        get_alert_box({
                            class: response.class || 'alert-info',
                            message: response.message,
                            icon: response.icon || '<i class="fa-solid fa-check-circle"></i>'
                        });
                        displayFiles();
                    })
                    .catch(error => {
                        console.error(error);
                        get_alert_box({
                            class: error.class || 'alert-danger',
                            message: error.message || 'An error occurred',
                            icon: error.icon || '<i class="fa-solid fa-triangle-exclamation"></i>'
                        });
                    });
            });
        }


        const emptyTrashBtn = document.querySelector('.btn-empty-trash');
        if (emptyTrashBtn) {
            emptyTrashBtn.addEventListener('click', function () {
                if (!confirm("Are you sure ?")) {
                    return;
                }
                fetch(`/api/directories/storage/trash`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getToken()
                    },
                })
                    .then(response => response.json())
                    .then(response => {
                        console.log(response);
                        get_alert_box({
                            class: response.class || 'alert-info',
                            message: response.message,
                            icon: response.icon || '<i class="fa-solid fa-check-circle"></i>'
                        });
                        displayFiles();
                    })
                    .catch(error => {
                        console.error(error);
                        get_alert_box({
                            class: error.class || 'alert-danger',
                            message: error.message || 'An error occurred',
                            icon: error.icon || '<i class="fa-solid fa-triangle-exclamation"></i>'
                        });
                    });
            });
        }




        document.addEventListener('mousedown', function (e) {
            if (e.target.classList.contains('file-name-text')) {
                e.target.setAttribute('contenteditable', true);

                let btn = document.querySelector('.submit-new-file-name');
                if (btn) {
                    btn.remove();
                }
                const button = document.createElement('button');
                button.type = 'button';
                button.classList.add('submit-new-file-name', 'p-0', 'btn', 'rounded-pill', 'btn-success', 'me-1');
                const icon = document.createElement('i');
                icon.classList.add('fa', 'fa-fw', 'fa-pencil-alt');
                button.appendChild(icon);

                e.target.parentNode.insertBefore(button, e.target);
            }
        });

        document.addEventListener('focusout', function (e) {
            if (e.target.classList.contains('file-name-text')) {
                e.target.setAttribute('contenteditable', false);
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.target.classList.contains('file-name-text') && e.key === 'Enter') {
                renameItem(e.target);
            }
        });


        displayFiles();
    } catch (error) {
        // console.log(error);
    }
});

function renameItem(target) {
    if (!confirm("Are you sure ?")) {
        return;
    }
    target.setAttribute('contenteditable', false);
    const newName = target.innerText.trim();
    const oldName = target.getAttribute('data-file-name').trim();

    if (oldName === '' || newName === '') {
        get_alert_box({ class: 'alert-danger', message: "Names should not be empty", icon: '<i class="fa-solid fa-triangle-exclamation"></i>' });
        target.innerText = oldName;
        return;
    }

    let btn = document.querySelector('.submit-new-file-name');
    if (btn) {
        btn.remove();
    }

    fetch('/api/file/rename', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getToken()
        },
        body: JSON.stringify({
            new_name: newName,
            old_name: oldName,
            path: document.querySelector('#current-path').value
        })
    })
        .then(response => response.json())
        .then(response => {
            console.log(response);
            target.setAttribute('data-file-name', newName)
            get_alert_box({ class: response.class || 'alert-info',message: response.message,icon: response.icon || '<i class="fa-solid fa-check-circle"></i>' });
            // displayFiles();
        })
        .catch(error => {
            console.error(error);
            target.innerText = oldName;
            get_alert_box({
                class: error.class || 'alert-danger',
                message: error.message || 'An error occurred',
                icon: error.icon || '<i class="fa-solid fa-triangle-exclamation"></i>'
            });
        });
}

function displayFiles(pathname = null) {
    if (!pathname) {
        const regex = new RegExp(`/admin/file-manager/\?`, 'g');
        pathname = window.location.pathname.replace(regex, '')
        if (pathname.startsWith('/')) pathname = pathname.replace('/', '')
    } else {
        window.history.pushState(null,null, `/admin/file-manager/${pathname}`);
    }
    const spinner = `<div class="col-12 text-center p-5">
                    <div class="spinner-border" role="status"
                         style="width: 3rem; height: 3rem;
                         border-color: var(--tc-grey-dark) transparent var(--tc-grey-dark) var(--tc-grey-dark);">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>`;
    document.getElementById('files').innerHTML = spinner;
    document.getElementById('directories').innerHTML = spinner;

    fetch(`/api/files/${pathname}`)
        .then(response => response.json())
        .then(response => {
            const data = response.data;
            document.getElementById('current-path').value = data.current_path;
            const prevPathLink = document.getElementById('previous-path');
            prevPathLink.setAttribute('href', `/admin/file-manager/${data.previous_path || ''}`);
            prevPathLink.setAttribute('data-href', data.previous_path || '');
            document.getElementById('breadcrumb').innerHTML = data.breadcrumb.breadcrumb;

            let directoriesDOM = '<div class="col-12"><div class="text-center p-5">No directories found</div></div>';
            if(data?.content?.directories?.length) {
                directoriesDOM = data.content.directories.map(dir => `
                    <div class="col-6 col-sm-4 col-md-3 mb-4 file-item-wrapper">
                        <div class="directory file-item mb-2">
                            <a href="#" class="file-item-link file-link" data-href="${dir.path}">
                                <div class="directory-icon w-100 h-100"><i class="fa-solid fa-folder-open"></i></div>
                            </a>
                            <div class="directory-name d-flex gap-1 w-100 h-100">
                                <span title="${dir.name}" class="file-name-text w-100" data-file-name="${dir.name}">${dir.name}</span>
                            </div>
                        </div>
                        <div class="action-btns">
                            <button type="submit" class="btn btn-outline-info w-100 file-operation" title="Copy File"
                                    data-name="${dir.name}" data-action="copy" data-path="${dir.path}">
                                <i class="fa-solid fa-file"></i>
                            </button>
                            <button type="submit" class="btn btn-outline-danger w-100 delete-file" title="Delete File"
                                    data-name="${dir.name}" data-path="${dir.path}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `).join('');
            }
            document.getElementById('directories').innerHTML = directoriesDOM;

            let filesDOM = '<div class="col-12"><div class="text-center p-5">No files found</div></div>';
            if(data?.content?.files?.length) {
                filesDOM = data.content.files.map(file => `
                    <div class="col-6 col-sm-4 col-md-3 mb-4 file-item-wrapper">
                        <div class="file file-item mb-2">
                            <a href="/${file._pathname}" class="file-item-link" data-href="${file._pathname}" target="_blank">
                                ${file._mimeType.includes('image') ? `
                                    <div class="file-image h-100">
                                        <img src="/${file._pathname}" class="img-fluid w-100 h-100" alt="${file._filename}"/>
                                    </div>
                                ` : `
                                    <div class="file-icon w-100 h-100"><i class="fa-solid fa-file"></i></div>
                                `}
                            </a>
                            <div class="file-name w-100">
                                <span title="${file._filename}" class="file-name-text" data-file-name="${file._filename}">${file._filename}</span>
                            </div>
                        </div>
                        <div class="action-btns">
                            <button type="submit" class="btn btn-outline-info w-100 file-operation" title="Copy File"
                                    data-name="${file._filename}" data-action="copy" data-path="${file._pathname}">
                                <i class="fa-solid fa-file"></i>
                            </button>
                            <button type="submit" class="btn btn-outline-danger w-100 delete-file" title="Delete File"
                                    data-name="${file._filename}" data-path="${file._pathname}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `).join('');
            }
            document.getElementById('files').innerHTML = filesDOM;
        });
}
