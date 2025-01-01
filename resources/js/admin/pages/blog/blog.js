import { setUpImagePreviewOnFileInput, getDomClass, configDT, get_alert_box, get_loader, remove_loader, getToken } from "@/admin/tools";
import { shortenTextIfLongByLength } from "@/admin/utilitiy";
import { initCommonFormInputEvents } from "@/admin/pages/blog/helpers";

document.addEventListener("DOMContentLoaded", function () {
    try {

        initCommonFormInputEvents();

        if (document.querySelector('#posts')) {
            let params = {
                first_time: true,
                id: '#posts',
                method: 'POST',
                url: '/api/posts/list',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions',
                        render: function (data, type, row, params) {
                            return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" title="View Post">
                                            <a href="/blog/${row.slug}" target="_blank" class="link-dark">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" title="Edit Post">
                                            <a href="/admin/posts/edit/${row.slug}" class="link-dark">
                                                <i class="fa fa-fw fa-pencil-alt"></i>
                                            </a>
                                        </button>
                                    </div>`;
                    }},
                    { data: 'active', name: 'active', title: 'Active', className: 'fs-sm',
                        render: function (data, type, row, params) {
                            return `<div class="item item-tiny item-circle mx-auto mb-3 ${ row.active ? 'bg-success' : 'bg-danger' }"></div>`;
                    }},
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'title', name: 'title', title: 'Title', className: 'fw-semibold fs-sm',
                        render: function (data, type, row, params) {
                            return `<span title="${row.title}">${shortenTextIfLongByLength(row.title, 20)}</span>`;
                    }},
                    { data: 'published', name: 'published', title: 'Published', domElement: 'select',
                        render: function (data, type, row, params) {
                            let published = getDomClass(row.published);
                            return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3
                                                rounded-pill ${published.class}">${published.text}</span>`;
                    }},
                    { data: 'featured', name: 'featured', title: 'Featured', className: 'fs-sm', domElement: 'select',
                        render: function (data, type, row, params) {
                            return `<div class="item item-tiny item-circle mx-auto mb-3
                                                ${row.featured ? 'bg-success' : 'bg-danger'}"></div>`;
                    }},
                    { data: 'views', name: 'views', title: 'Views' },
                    { data: 'likes', name: 'likes', title: 'Likes' },
                    { data: 'tags_count', name: 'tags_count', title: 'Tags', searchable: false },
                    { data: 'published_at', name: 'published_at', title: 'Published @', className: 'fs-sm',
                        render: function(data, type, row, params) {
                            let published_at_for_humans = row.published_at ? moment(row.published_at).fromNow() : '------';
                            let published_at_formatted = row.published_at ? moment(row.published_at).format('Y-M-D hh:mm') : '------';
                            return `<span title="${published_at_formatted}">${published_at_for_humans}<br/>${published_at_formatted}</span>`;
                    }},
                    { data: 'created_at', name: 'created_at', title: 'Created @', className: 'fs-sm',
                        render: function(data, type, row, params) {
                            let created_at_for_humans = moment(row.created_at).fromNow();
                            let created_at_formatted = moment(row.created_at).format('Y-M-D hh:mm');
                            return `<span title="${created_at_formatted}">${created_at_for_humans}<br/>${created_at_formatted}</span>`;
                    }},
                    { data: 'updated_at', name: 'updated_at', title: 'Updated @', className: 'fs-sm',
                        render: function(data, type, row, params) {
                            let updated_at_for_humans = moment(row.updated_at).fromNow();
                            let updated_at_formatted = moment(row.updated_at).format('Y-M-D hh:mm');
                            return `<span title="${updated_at_formatted}">${updated_at_for_humans}<br/>${updated_at_formatted}</span>`;
                    }},
                ]
            };
            configDT(params);
        }

        if (document.querySelector('#tags')) {
            let params = {
                first_time: true,
                id: '#tags',
                method: 'POST',
                url: '/api/tags/list',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions',
                        render: function (data, type, row, params) {
                            return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" title="View Tag">
                                            <a href="/tags/${row.slug}" target="_blank" class="link-dark">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary display-tags-details" title="Edit Tag">
                                            <a class="link-dark">
                                                <i class="fa fa-fw fa-pencil-alt"></i>
                                            </a>
                                        </button>
                                    </div>`;
                    }},
                    { data: 'active', name: 'active', title: 'Active', className: 'fs-sm',
                        render: function (data, type, row, params) {
                            let element = `<span class="d-inline-block square-15 br-50p ${ row.active ? 'bg-success' : 'bg-danger' }"></span>`;
                            if (row.deleted_at) {
                                element += `<span class="">[ <i class="fa-solid fa-trash"></i> ]</span>`;
                            }
                            return `<div class="d-flex justify-content-center gap-3">${element}</div>`;
                    }},
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'name', name: 'name', title: 'Name', className: 'fw-semibold fs-sm' },
                    { data: 'slug', name: 'slug', title: 'Slug', className: 'fw-semibold fs-sm' },
                    { data: 'color', name: 'color', title: 'Color', className: 'fw-semibold fs-sm',
                        render: function(data, type, row, params) {
                            return `<div class="item item-tiny item-circle mx-auto mb-3"
                                    style="background-color: ${row.color}"></div>`;
                    }},
                    { data: 'posts_count', name: 'posts_count', title: 'Posts', className: 'fw-semibold fs-sm', searchable: false },
                    { data: 'created_at', name: 'created_at', title: 'Created @', className: 'fs-sm',
                        render: function(data, type, row, params) {
                            let created_at_for_humans = moment(row.created_at).fromNow();
                            let created_at_formatted = moment(row.created_at).format('Y-M-D hh:mm');
                            return `<span title="${created_at_formatted}">${created_at_for_humans}<br/>${created_at_formatted}</span>`;
                    }},
                ]
            };
            let tagsDataTable = configDT(params);
            $('#tags').on('click', '.display-tags-details', function(e) {
                const $row = $(this).closest('tr');
                const data = tagsDataTable.row( $row ).data();
                let modal = `
                    <div class="modal-tags-details-wrapper">
                        <div class="modal modal-tags-details d-block" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">${data.name || '??'}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <form id="form-tags" action="/api/tags/${data.slug}">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="example-static-input-plain">Posts tagged : ${data.posts_count}</label>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="form-label" for="tag-name">Name</label>
                                                            <input type="text" class="form-control input-to-slugify" id="tag-name" name="name"
                                                                placeholder="Tag Name" value="${data.name}" required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="form-label" for="tag-slug">Slug</label>
                                                            <input type="text" class="form-control input-slug" id="tag-slug" name="slug"
                                                                placeholder="Tag slug" value="${data.slug}" required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <div class="form-check form-switch form-check-inline">
                                                                <input class="form-check-input" type="checkbox" id="tag-active" name="active" ${data.active ? 'checked' : ''} >
                                                                <label class="form-check-label" for="tag-active">Active</label>
                                                            </div>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="form-label" for="tag-description">Description</label>
                                                            <textarea class="form-control" id="tag-description" name="description" rows="4" placeholder="Tag description..">${data.description}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="tag-color">Color</label>
                                                            <input type="color" class="form-control" id="tag-color" name="color"
                                                                   placeholder="Tag color" value="${data.color}">
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="form-label" for="tag-image">Image</label>
                                                            <input type="file" id="tag-image" name="cover" class="form-control" />
                                                            <div class="mt-4">
                                                                <img id="tag-image-preview" class="image-preview img-fluid w-100 lazyload"
                                                                     src="/${data?.cover?.compressed || 'assets/img/default/missing.webp'}"
                                                                     data-src="/${data?.cover?.original || 'assets/img/default/missing.webp'}"
                                                                     alt="photo" width="200" height="100" loading="lazy">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-between align-items-stretch gap-2 flex-wrap flex-md-nowrap">
                                                        <button type="submit" class="btn-action btn-action-tag btn btn-success
                                                                                d-flex justify-content-center align-items-center w-100">
                                                            <i class="fa fa-fw fa-edit me-1"></i>Update</button>
                                                        <a href="/tags/${data.slug}?forget=1" target="_blank"
                                                           id="link-view-tag" class="btn btn-dark
                                                                                    d-flex justify-content-center align-items-center w-100">
                                                            <i class="fa fa-fw fa-eye me-1"></i>View</a>
                                                        ${data.deleted_at ?
                                    '<button type="submit" class="btn-action btn-action-tag btn btn-secondary d-flex justify-content-center align-items-center w-100" name="restore"><i class="fa fa-fw fa-rotate-left me-1"></i> Restore</button>'
                                    : '<button type="submit" class="btn-action btn-action-tag btn btn-warning d-flex justify-content-center align-items-center w-100" name="delete"><i class="fa fa-fw fa-trash me-1"></i> Delete</button>'}
                                                        <button type="submit" class="btn-action btn-action-tag btn btn-danger
                                                                                    d-flex justify-content-center align-items-center w-100" name="destroy">
                                                            <i class="fa fa-fw fa-trash me-1"></i>Hard Delete</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-backdrop fade show"></div>
                    </div>`;
                $('#page-container').append(modal);
                setUpImagePreviewOnFileInput('tag-image', 'tag-image-preview');
                const modalTagsDetailsWrapper = document.querySelector('.modal-tags-details-wrapper');
                const modalTagsDetails = document.querySelector('.modal-tags-details');
                const closeButton = modalTagsDetailsWrapper.querySelector('.btn-close');
                modalTagsDetails.addEventListener('click', function (e) {
                    if (e.target === modalTagsDetails || e.target === closeButton) {
                        modalTagsDetailsWrapper.remove();
                    }
                });


                function eventHandler(e) {
                    if (e.target.classList.contains('btn-action-tag') || e.target.closest('.btn-action-tag') || e.target.closest('#form-tags')) {
                        e.preventDefault();

                        if (!confirm("Are you sure ?")) {
                            return;
                        }

                        let form = e.target.closest('form');
                        let data = new FormData(form);
                        data.append('_method', 'PUT');
                        const operationName = e.submitter.getAttribute("name");
                        data.append(operationName, true);
                        data.append("_token", getToken());

                        fetch(form.getAttribute('action'), {
                            method: 'POST',
                            body: data
                        }).then(response => response.json())
                            .then(response => {
                                console.log(response);
                                tagsDataTable.ajax.reload(null, false);
                                if (operationName) {
                                    if (operationName === "destroy") {
                                        modalTagsDetailsWrapper.remove();
                                    } else {
                                        if (response.tag.deleted_at) {
                                            const restoreButton = document.createElement('button');
                                            restoreButton.type = 'submit';
                                            restoreButton.className = 'btn-action btn-action-tag btn btn-secondary d-flex justify-content-center align-items-center w-100';
                                            restoreButton.name = 'restore';
                                            restoreButton.innerHTML = '<i class="fa fa-fw fa-rotate-left me-1"></i> Restore';
                                            const deleteButton = document.querySelector('.btn-action-tag[name="delete"]');
                                            if (deleteButton) deleteButton.replaceWith(restoreButton);
                                        } else {
                                            const deleteButton = document.createElement('button');
                                            deleteButton.type = 'submit';
                                            deleteButton.className = 'btn-action btn-action-tag btn btn-warning d-flex justify-content-center align-items-center w-100';
                                            deleteButton.name = 'delete';
                                            deleteButton.innerHTML = '<i class="fa fa-fw fa-trash me-1"></i> Delete';
                                            const restoreButton = document.querySelector('.btn-action-tag[name="restore"]');
                                            if (restoreButton) restoreButton.replaceWith(deleteButton);
                                        }
                                    }
                                } else {
                                    if (response.tag?.slug) {
                                        form.setAttribute('action', `/api/tags/${response.tag.slug}`);
                                        document.getElementById('link-view-tag').setAttribute('href', `/tags/${response.tag.slug}?forget=1`);
                                    }
                                }
                                get_alert_box({ class: response.class, message: response.message, icon: response.icon });
                            })
                            .catch(async (error) => {
                                const response = await error.json();
                                console.log(error, response);
                                get_alert_box({ class: response.class, message: response.message, icon: response.icon });
                            });
                    }
                }

                document.removeEventListener('submit', eventHandler);
                document.addEventListener('submit', eventHandler);

            });

            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('btn-new')) {
                    let modal = `
                        <div class="modal-tags-details-wrapper">
                            <div class="modal modal-tags-details d-block" tabindex="-1" style="display: block;">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">New Tag</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <form id="form-tags" action="/api/tags">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <div class="mb-4">
                                                                <label class="form-label" for="tag-name">Name</label>
                                                                <input type="text" class="form-control input-to-slugify" id="tag-name" name="name"
                                                                    placeholder="Tag Name" required>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label class="form-label" for="tag-slug">Slug</label>
                                                                <input type="text" class="form-control input-slug" id="tag-slug" name="slug"
                                                                    placeholder="Tag slug" required>
                                                            </div>
                                                            <div class="mb-4">
                                                                <div class="form-check form-switch form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="tag-active" name="active" >
                                                                    <label class="form-check-label" for="tag-active">Active</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label class="form-label" for="tag-description">Description</label>
                                                                <textarea class="form-control" id="tag-description" name="description" rows="4" placeholder="Tag description.."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="mb-4">
                                                                <label class="form-label" for="tag-color">Color</label>
                                                                <input type="color" class="form-control" id="tag-color" name="color"
                                                                       placeholder="Tag color">
                                                            </div>
                                                            <div class="mb-4">
                                                                <label class="form-label" for="tag-image">Image</label>
                                                                <input type="file" id="tag-image" name="cover" class="form-control" />
                                                                <div class="mt-2">
                                                                    <img id="tag-image-preview" class="img-fluid image-preview w-100"
                                                                         src="/assets/img/default/landscape.webp"
                                                                         alt="photo" width="200" height="100" loading="lazy">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-success btn-action me-1 mb-3 w-100">
                                                                    <i class="fa fa-fw fa-plus me-1"></i>Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-backdrop fade show"></div>
                        </div>`;
                    document.getElementById('page-container').insertAdjacentHTML('beforeend', modal);
                    setUpImagePreviewOnFileInput('tag-image', 'tag-image-preview');

                    const modalTagsDetailsWrapper = document.querySelector('.modal-tags-details-wrapper');
                    const modalTagsDetails = document.querySelector('.modal-tags-details');
                    const closeButton = modalTagsDetailsWrapper.querySelector('.btn-close');
                    modalTagsDetails.addEventListener('click', function (e) {
                        if (e.target === modalTagsDetails || e.target === closeButton) {
                            modalTagsDetailsWrapper.remove();
                        }
                    });

                    const formTags = document.getElementById('form-tags');
                    formTags.addEventListener('submit', function (e) {
                        e.preventDefault();

                        if (!confirm("Are you sure?")) {
                            return;
                        }

                        const data = new FormData(formTags);
                        data.append("_token", getToken());

                        get_loader();
                        fetch('/api/tags', {
                            method: 'POST',
                            body: data
                        })
                            .then(response => response.json())
                            .then(data => {
                                remove_loader();
                                console.log(data);
                                tagsDataTable.ajax.reload(null, false);
                                get_alert_box({ class: data.class || 'alert-info', message: data.message, icon: data.icon || '<i class="fa-solid fa-check-circle"></i>' });
                            })
                            .catch(err => {
                                remove_loader();
                                console.error(err);
                                get_alert_box({ class: err.class || 'alert-danger', message: err.message || 'An error occurred', icon: err.icon || '<i class="fa-solid fa-triangle-exclamation"></i>' });
                            });
                    });
                }
            });

        }
    } catch (error) {
        console.log(error);
    }
});
