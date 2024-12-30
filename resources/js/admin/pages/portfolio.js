import { get_alert_box } from "@/shared/functions";
import { setUpImagePreviewOnFileInput } from "@/shared/helpers";
import { configDT } from "@/admin/functions";

document.addEventListener("DOMContentLoaded", function () {
    try {

        if (document.querySelector('#testimonials')) {
            let params = {
                first_time: true,
                id: '#testimonials',
                method: 'POST',
                url: '/api/testimonials/list',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions' ,
                        render: function (data, type, row, params) {
                            return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm display-testimonials-details" title="View Testimonial">
                                            <i class="fa fs-3 fa-eye"></i>
                                        </button>
                                    </div>`;
                        }
                    },
                    { data: 'active', name: 'active', title: 'Active', className: 'fs-sm',
                        render: function (data, type, row) {
                            let element = `<span class="d-inline-block square-15 br-50p ${ row.active ? 'bg-success' : 'bg-danger' }"></span>`;
                            if (row.deleted_at) {
                                element += `<span class="">[ <i class="fa-solid fa-trash"></i> ]</span>`;
                            }
                            return `<div class="d-flex justify-content-center gap-3">${element}</div>`;
                    }},
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'order', name: 'order', title: 'Order' },
                    { data: 'author', name: 'author', title: 'Author' },
                    { data: 'position', name: 'position', title: 'Position' },
                ]
            };
            let testimonialsDataTable = configDT(params);
            $('#testimonials').on('click', '.display-testimonials-details', function(e) {
                const $row = $(this).closest('tr');
                const data = testimonialsDataTable.row( $row ).data();
                let dataFilteredCount = testimonialsDataTable.ajax.json().recordsTotal;
                let modal = `
        <div class="modal modal-testimonials-details" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${data.author || '??'}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="form-testimonials" data-testimonials-id="${data.id}">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="author">Author</label>
                                            <input type="text" class="form-control" id="author" name="author"
                                                value="${data.author || ''}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="position">Position</label>
                                            <input type="text" class="form-control" id="position" name="position"
                                                value="${data.position || ''}" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="testimonial-image">Image</label>
                                            <input type="file" id="testimonial-image" name="testimonial-image" class="form-control" />
                                            <div class="mt-2">
                                                <img id="testimonial-image-preview"
                                                    class="image-preview img-fluid w-100 br-5px d-block m-auto"
                                                    src="/${data.image?.original || 'assets/img/default/missing.webp'}"
                                                    alt="photo" width="200" height="100" loading="lazy">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label" for="order">Order</label>
                                          <input class="form-control" type="number" value="${ data.order || '1' }"
                                            min="1" max="${dataFilteredCount}" id="order" name="order" required>
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                          <label class="form-check-label" for="active">Active</label>
                                          <input class="form-check-input" id="active" name="active"
                                                  type="checkbox" ${ data.active ? "checked" : "" }>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="content">Content</label>
                                            <textarea class="form-control" id="content" name="content" rows="7"
                                                    required>${data.content || ''}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="note">Note</label>
                                            <textarea class="form-control" id="note"
                                                name="note" rows="4">${data.note || ''}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between gap-2 flex-wrap flex-md-nowrap">
                                        <button type="submit" class="btn btn-outline-info w-100">Update</button>
                                        ${data.deleted_at ?
                                            '<button type="submit" class="btn btn-outline-secondary w-100" name="restore">Restore</button>'
                                            : '<button type="submit" class="btn btn-outline-warning w-100" name="delete">Delete</button>'
                                        }
                                        <button type="submit" class="btn btn-danger w-100" name="destroy">Hard Delete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>`;
                $('#page-container').append(modal);
                setUpImagePreviewOnFileInput('testimonial-image', 'testimonial-image-preview');
                let modalTestimonialsDetails = $('.modal-testimonials-details');
                $('.btn-close').add('.modal-testimonials-details').on('click', function(e) {
                    if (e.target !== modalTestimonialsDetails[0] && e.target !== $('.btn-close')[0]) {
                        return;
                    }
                    modalTestimonialsDetails.remove();
                    $('.modal-backdrop').remove();
                });
                modalTestimonialsDetails.show()

                $(document).off('submit', '#form-testimonials').on('submit', '#form-testimonials', function(e) {
                    e.preventDefault();
                    if (!confirm("Are you sure ?")) {
                        return;
                    }
                    let _this = $(this);
                    let action = e.originalEvent.submitter.getAttribute("name");
                    let data = new FormData(this);
                    data.append(action, true);
                    data.append('_method', 'PUT');
                    $.ajax({
                        type: 'POST',
                        url: `/api/testimonials/${_this.data('testimonials-id')}`,
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            testimonialsDataTable.ajax.reload(null, false);
                            get_alert_box({class: 'alert-info', message: response.message, icon: '<i class="fa-solid fa-check-circle"></i>'});
                        },
                        error: function (jqXHR, textStatus, errorThrown){
                            console.log(jqXHR, textStatus, errorThrown);
                            get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.message, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                        }
                    });
                });

            });

            $(document).on('click', '.btn-new', function(e) {
                let dataFilteredCount = testimonialsDataTable.ajax.json().recordsTotal + 1;
                let modal = `
        <div class="modal modal-testimonials-details" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Testimonial</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="form-testimonials">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="author">Author</label>
                                            <input type="text" class="form-control" id="author" name="author" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="position">Position</label>
                                            <input type="text" class="form-control" id="position" name="position" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="testimonial-image">Image</label>
                                            <input type="file" id="testimonial-image" name="testimonial-image" class="form-control" />
                                            <div class="mt-2">
                                                <img id="testimonial-image-preview"
                                                    src="/assets/img/default/landscape.webp"
                                                    class="image-preview img-fluid w-100 br-5px d-block m-auto"
                                                    alt="photo" width="200" height="100" loading="lazy">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label" for="order">Order</label>
                                          <input class="form-control" type="number"
                                            min="1" max="${dataFilteredCount}" id="order" name="order" required>
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                          <label class="form-check-label" for="active">Active</label>
                                          <input class="form-check-input" type="checkbox" id="active" name="active">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="content">Content</label>
                                            <textarea class="form-control" id="content" name="content" rows="7"
                                                    required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="note">Note</label>
                                            <textarea class="form-control" id="note" name="note" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-outline-info w-100">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>`;
                $('#page-container').append(modal);
                setUpImagePreviewOnFileInput('testimonial-image', 'testimonial-image-preview');
                let modalTestimonialsDetails = $('.modal-testimonials-details');
                $('.btn-close').add('.modal-testimonials-details').on('click', function(e) {
                    if (e.target !== modalTestimonialsDetails[0] && e.target !== $('.btn-close')[0]) {
                        return;
                    }
                    modalTestimonialsDetails.remove();
                    $('.modal-backdrop').remove();
                });
                modalTestimonialsDetails.show();
                $(document).off('submit', '#form-testimonials').on('submit', '#form-testimonials', function(e) {
                    e.preventDefault();
                    if (!confirm("Are you sure ?")) {
                        return;
                    }
                    let _this = $(this);
                    let data = new FormData(this);

                    $.ajax({
                        type: 'POST',
                        url: '/api/testimonials',
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            testimonialsDataTable.ajax.reload(null, false);
                            get_alert_box({class: 'alert-info', message: response.message, icon: '<i class="fa-solid fa-check-circle"></i>'});
                        },
                        error: function (jqXHR, textStatus, errorThrown){
                            console.log(jqXHR, textStatus, errorThrown);
                            get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.message, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                        }
                    });
                });
            });
        }
        if (document.querySelector('#projects')) {
            let params = {
                first_time: true,
                id: '#projects',
                method: 'POST',
                url: '/api/projects/list',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions' ,
                        render: function (data, type, row, params) {
                            return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm display-projects-details" title="View Project">
                                            <i class="fa fs-3 fa-eye"></i>
                                        </button>
                                    </div>`;
                        }
                    },
                    { data: 'active', name: 'active', title: 'Active', className: 'fs-sm',
                        render: function (data, type, row) {
                            let element = `<span class="d-inline-block square-15 br-50p ${ row.active ? 'bg-success' : 'bg-danger' }"></span>`;
                            if (row.deleted_at) {
                                element += `<span class="">[ <i class="fa-solid fa-trash"></i> ]</span>`;
                            }
                            return `<div class="d-flex justify-content-center gap-3">${element}</div>`;
                    }},
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'order', name: 'order', title: 'Order' },
                    { data: 'role', name: 'role', title: 'Role' ,
                        render: function (data, type, row) {
                            const div = document.createElement('div');
                            div.innerHTML = row.role;
                            return div.innerText;
                    }},
                    { data: 'title', name: 'title', title: 'Title' },
                    { data: 'links', name: 'links', title: 'Links', className: 'text-left',
                        render: function (data, type, row) {
                            let dom = '---';
                            if (row.links) {
                                dom = '<div class="d-flex gap-2 flex-column">';
                                if (row.links.repository) {
                                    dom += `<div><a href="${row.links.repository}">Repository <i class="fa-solid fa-up-right-from-square"></i></a></div>`;
                                }
                                if (row.links.website) {
                                    dom += `<div><a href="${row.links.website}">Website <i class="fa-solid fa-up-right-from-square"></i></a></div>`;
                                }
                                dom += '</div>';
                            }
                            return dom;
                    }},
                    { data: 'featured', name: 'featured', title: 'Featured', className: 'fs-sm', domElement: 'select',
                        render: function (data, type, row) {
                            return `<div class="item item-tiny item-circle mx-auto mb-3 ${ row.featured ? 'bg-success' : 'bg-danger' }"></div>`;
                    }},
                ]
            };
            let projectsDataTable = configDT(params);
            $('#projects').on('click', '.display-projects-details', function(e) {
                const $row = $(this).closest('tr');
                const data = projectsDataTable.row( $row ).data();
                let dataFilteredCount = projectsDataTable.ajax.json().recordsTotal;
                let modal = `
        <div class="modal modal-projects-details" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${data.title || data.role || '??'}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="form-projects" data-projects-id="${data.id}">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="role">Role</label>
                                            <input type="text" class="form-control" id="role" name="role"
                                                value="${data.role || ''}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="${data.title || ''}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="repository">Repository</label>
                                            <input type="text" class="form-control" id="repository" name="links[repository]"
                                                value="${data.links?.repository || ''}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="website">Website</label>
                                            <input type="text" class="form-control" id="website" name="links[website]"
                                                value="${data.links?.website || ''}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="project-image">Image</label>
                                            <input type="file" id="project-image" name="project-image" class="form-control" />
                                            <div class="mt-2">
                                                <img id="project-image-preview"
                                                    class="image-preview img-fluid w-100 br-5px d-block m-auto"
                                                    src="/${data.image?.original || 'assets/img/default/missing.webp'}"
                                                    alt="photo" width="200" height="100" loading="lazy">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label" for="order">Order</label>
                                          <input class="form-control" type="number" value="${ data.order || '1' }"
                                            min="1" max="${dataFilteredCount}" id="order" name="order" required>
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                          <label class="form-check-label" for="active">Active</label>
                                          <input class="form-check-input" id="active" name="active"
                                                type="checkbox" ${ data.active ? "checked" : "" }>
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                          <label class="form-check-label" for="featured">Featured</label>
                                          <input class="form-check-input" id="featured" name="featured"
                                                type="checkbox" ${ data.featured ? "checked" : "" }>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4"
                                                required>${data.description || ''}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="note">Note</label>
                                            <textarea class="form-control" id="note"
                                                name="note" rows="4">${data.note || ''}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between gap-2 flex-wrap flex-md-nowrap">
                                        <button type="submit" class="btn btn-outline-info w-100">Update</button>
                                        ${data.deleted_at ?
                                            '<button type="submit" class="btn btn-outline-secondary w-100" name="restore">Restore</button>'
                                            : '<button type="submit" class="btn btn-outline-warning w-100" name="delete">Delete</button>'
                                        }
                                        <button type="submit" class="btn btn-danger w-100" name="destroy">Hard Delete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>`;
                $('#page-container').append(modal);
                setUpImagePreviewOnFileInput('project-image', 'project-image-preview');
                let modalProjectsDetails = $('.modal-projects-details');
                $('.btn-close').add('.modal-projects-details').on('click', function(e) {
                    if (e.target !== modalProjectsDetails[0] && e.target !== $('.btn-close')[0]) {
                        return;
                    }
                    modalProjectsDetails.remove();
                    $('.modal-backdrop').remove();
                });
                modalProjectsDetails.show();
                $(document).off('submit', '#form-projects').on('submit', '#form-projects', function(e) {
                    e.preventDefault();
                    if (!confirm("Are you sure ?")) {
                        return;
                    }
                    let _this = $(this);
                    let action = e.originalEvent.submitter.getAttribute("name");
                    let data = new FormData(this);
                    data.append(action, true);
                    data.append('_method', 'PUT');
                    $.ajax({
                        type: 'POST',
                        url: `/api/projects/${_this.data('projects-id')}`,
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            projectsDataTable.ajax.reload(null, false);
                            get_alert_box({class: 'alert-info', message: response.message, icon: '<i class="fa-solid fa-check-circle"></i>'});
                        },
                        error: function (jqXHR, textStatus, errorThrown){
                            console.log(jqXHR, textStatus, errorThrown);
                            get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.message, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                        }
                    });
                });

            });

            $(document).on('click', '.btn-new', function(e) {
                let dataFilteredCount = projectsDataTable.ajax.json().recordsTotal + 1;
                let modal = `
        <div class="modal modal-projects-details" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="form-projects">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="role">Role</label>
                                            <input type="text" class="form-control" id="role" name="role" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="repository">Repository</label>
                                            <input type="text" class="form-control" id="repository" name="links[repository]">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="website">Website</label>
                                            <input type="text" class="form-control" id="website" name="links[website]">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="project-image">Image</label>
                                            <input type="file" id="project-image" name="project-image" class="form-control" />
                                            <div class="mt-2">
                                                <img id="project-image-preview"
                                                    src="/assets/img/default/landscape.webp"
                                                    class="image-preview img-fluid w-100 br-5px d-block m-auto"
                                                    alt="photo" width="200" height="100" loading="lazy">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label" for="order">Order</label>
                                          <input class="form-control" type="number"
                                            min="1" max="${dataFilteredCount}" id="order" name="order" required>
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                          <label class="form-check-label" for="active">Active</label>
                                          <input class="form-check-input" type="checkbox" id="active" name="active">
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                          <label class="form-check-label" for="featured">Featured</label>
                                          <input class="form-check-input" type="checkbox" id="featured" name="featured">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4"
                                                    required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="note">Note</label>
                                            <textarea class="form-control" id="note" name="note" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-outline-info w-100">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>`;
                $('#page-container').append(modal);
                setUpImagePreviewOnFileInput('project-image', 'project-image-preview');
                let modalProjectsDetails = $('.modal-projects-details');
                $('.btn-close').add('.modal-projects-details').on('click', function(e) {
                    if (e.target !== modalProjectsDetails[0] && e.target !== $('.btn-close')[0]) {
                        return;
                    }
                    modalProjectsDetails.remove();
                    $('.modal-backdrop').remove();
                });
                modalProjectsDetails.show();
                $(document).off('submit', '#form-projects').on('submit', '#form-projects', function(e) {
                    e.preventDefault();
                    if (!confirm("Are you sure ?")) {
                        return;
                    }
                    let _this = $(this);
                    let data = new FormData(this);

                    $.ajax({
                        type: 'POST',
                        url: '/api/projects',
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            projectsDataTable.ajax.reload(null, false);
                            get_alert_box({class: 'alert-info', message: response.message, icon: '<i class="fa-solid fa-check-circle"></i>'});
                        },
                        error: function (jqXHR, textStatus, errorThrown){
                            console.log(jqXHR, textStatus, errorThrown);
                            get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.message, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                        }
                    });
                });
            });
        }
        if (document.querySelector('#services')) {
            let params = {
                first_time: true,
                id: '#services',
                method: 'POST',
                url: '/api/services/list',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions' ,
                        render: function (data, type, row, params) {
                            return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm display-services-details" title="View Service">
                                            <i class="fa fs-3 fa-eye"></i>
                                        </button>
                                    </div>`;
                        }
                    },
                    { data: 'active', name: 'active', title: 'Active', className: 'fs-sm',
                        render: function (data, type, row) {
                            let element = `<span class="d-inline-block square-15 br-50p ${ row.active ? 'bg-success' : 'bg-danger' }"></span>`;
                            if (row.deleted_at) {
                                element += `<span class="">[ <i class="fa-solid fa-trash"></i> ]</span>`;
                            }
                            return `<div class="d-flex justify-content-center gap-3">${element}</div>`;
                    }},
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'order', name: 'order', title: 'Order' },
                    { data: 'slug', name: 'slug', title: 'Slug' },
                    { data: 'title', name: 'title', title: 'Title' },
                    { data: 'icon', name: 'icon', title: 'Icon' ,
                        render: function (data, type, row) {
                            const div = document.createElement('div');
                            div.innerHTML = row.icon;
                            return div.innerText;
                        }
                    },
                    { data: 'link', name: 'link', title: 'Link' ,
                        render: function (data, type, row) {
                            return `<a href="${row.link}" target="_blank">${row.link}</a>`;
                    }},
                ]
            };
            let servicesDataTable = configDT(params);

            $('#services').on('click', '.display-services-details', function(e) {
                const $row = $(this).closest('tr');
                const data = servicesDataTable.row( $row ).data();
                let dataFilteredCount = servicesDataTable.ajax.json().recordsTotal;
                let modal = `
        <div class="modal modal-services-details" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${data.title || '??'}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="form-services" data-services-id="${data.id}">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="slug">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                value="${data.slug || ''}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="${data.title || ''}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="link">Link</label>
                                            <input type="text" class="form-control" id="link" name="link"
                                                value="${data.link || ''}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="icon">Icon</label>
                                            <input type="text" class="form-control" id="icon" name="icon"
                                                value="${data.icon || ''}" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="service-image">Image</label>
                                            <input type="file" id="service-image" name="service-image" class="form-control" />
                                            <div class="mt-2">
                                                <img id="service-image-preview"
                                                    class="image-preview img-fluid w-100 br-5px d-block m-auto"
                                                    src="/${data.image?.original || 'assets/img/default/missing.webp'}"
                                                    alt="photo" width="200" height="100" loading="lazy">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label" for="order">Order</label>
                                          <input class="form-control" type="number" value="${ data.order || '1' }"
                                            min="1" max="${dataFilteredCount}" id="order" name="order" required>
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                          <label class="form-check-label" for="active">Active</label>
                                          <input class="form-check-input" id="active" name="active"
                                                type="checkbox" ${ data.active ? "checked" : "" }>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="description">Description</label>
                                            <textarea class="form-control" id="description"
                                                name="description" rows="4" required>${data.description || ''}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="note">Note</label>
                                            <textarea class="form-control" id="note"
                                                name="note" rows="4">${data.note || ''}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between gap-2 flex-wrap flex-md-nowrap">
                                        <button type="submit" class="btn btn-outline-info w-100">Update</button>
                                        ${data.deleted_at ?
                                            '<button type="submit" class="btn btn-outline-secondary w-100" name="restore">Restore</button>'
                                            : '<button type="submit" class="btn btn-outline-warning w-100" name="delete">Delete</button>'
                                        }
                                        <button type="submit" class="btn btn-danger w-100" name="destroy">Hard Delete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>`;
                $('#page-container').append(modal);
                setUpImagePreviewOnFileInput('service-image', 'service-image-preview');
                let modalServicesDetails = $('.modal-services-details');
                $('.btn-close').add('.modal-services-details').on('click', function(e) {
                    if (e.target !== modalServicesDetails[0] && e.target !== $('.btn-close')[0]) {
                        return;
                    }
                    modalServicesDetails.remove();
                    $('.modal-backdrop').remove();
                });
                modalServicesDetails.show();

                $(document).off('submit', '#form-services').on('submit', '#form-services', function(e) {
                    e.preventDefault();
                    if (!confirm("Are you sure ?")) {
                        return;
                    }
                    let _this = $(this);
                    let action = e.originalEvent.submitter.getAttribute("name");
                    let data = new FormData(this);
                    data.append(action, true);
                    data.append('_method', 'PUT');
                    $.ajax({
                        type: 'POST',
                        url: `/api/services/${_this.data('services-id')}`,
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            servicesDataTable.ajax.reload(null, false);
                            get_alert_box({class: 'alert-info', message: response.message, icon: '<i class="fa-solid fa-check-circle"></i>'});
                        },
                        error: function (jqXHR, textStatus, errorThrown){
                            console.log(jqXHR, textStatus, errorThrown);
                            get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.message, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                        }
                    });
                });

            });

            $(document).on('click', '.btn-new', function(e) {
                let dataFilteredCount = servicesDataTable.ajax.json().recordsTotal + 1;
                let modal = `
        <div class="modal modal-services-details" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="form-services">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="slug">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="link">Link</label>
                                            <input type="text" class="form-control" id="link" name="link" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="icon">Icon</label>
                                            <input type="text" class="form-control" id="icon" name="icon" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="service-image">Image</label>
                                            <input type="file" id="service-image" name="service-image" class="form-control" />
                                            <div class="mt-2">
                                                <img id="service-image-preview"
                                                    src="/assets/img/default/landscape.webp"
                                                    class="image-preview img-fluid w-100 br-5px d-block m-auto"
                                                    alt="photo" width="200" height="100" loading="lazy">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label" for="order">Order</label>
                                          <input class="form-control" type="number"
                                            min="1" max="${dataFilteredCount}" id="order" name="order" required>
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                          <label class="form-check-label" for="active">Active</label>
                                          <input class="form-check-input" type="checkbox" id="active" name="active">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4"
                                                required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="note">Note</label>
                                            <textarea class="form-control" id="note" name="note" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-outline-info w-100">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>`;
                $('#page-container').append(modal);
                setUpImagePreviewOnFileInput('service-image', 'service-image-preview');
                let modalServicesDetails = $('.modal-services-details');
                $('.btn-close').add('.modal-services-details').on('click', function(e) {
                    if (e.target !== modalServicesDetails[0] && e.target !== $('.btn-close')[0]) {
                        return;
                    }
                    modalServicesDetails.remove();
                    $('.modal-backdrop').remove();
                });
                modalServicesDetails.show();

                $(document).off('submit', '#form-services').on('submit', '#form-services', function(e) {
                    e.preventDefault();
                    if (!confirm("Are you sure ?")) {
                        return;
                    }
                    let _this = $(this);
                    let data = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: '/api/services',
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            servicesDataTable.ajax.reload(null, false);
                            get_alert_box({class: 'alert-info', message: response.message, icon: '<i class="fa-solid fa-check-circle"></i>'});
                        },
                        error: function (jqXHR, textStatus, errorThrown){
                            console.log(jqXHR, textStatus, errorThrown);
                            get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.message, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                        }
                    });
                });
            });
        }

    } catch (error) {
        console.log(error);
    }
});
