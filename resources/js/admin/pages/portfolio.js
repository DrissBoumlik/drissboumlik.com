import { get_alert_box } from "../../shared/functions";
import { configDT } from "../functions";

$(function () {
    try {

        if ($('#testimonials').length) {
            let params = {
                first_time: true,
                id: '#testimonials',
                method: 'POST',
                url: '/api/testimonials/list',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions' ,
                        render: function (data, type, row, params) {
                            return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm js-bs-tooltip-enabled display-testimonials-details">
                                            <i class="fa fs-3 fa-eye"></i>
                                        </button>
                                    </div>`;
                        }
                    },
                    { data: 'active', name: 'active', title: 'Active', className: 'fs-sm',
                        render: function (data, type, row) {
                            return `<div class="item item-tiny item-circle mx-auto mb-3 ${ row.active ? 'bg-success' : 'bg-danger' }"></div>`;
                    }},
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'order', name: 'order', title: 'Order' },
                    { data: 'author', name: 'author', title: 'Author' },
                    { data: 'content', name: 'content', title: 'Content' ,
                        render: function(data, type, row) {
                            var div = document.createElement('div');
                            div.innerHTML = row.content.substring(0, 100) + "...";
                            return div.innerText;
                        }
                    },
                    { data: 'image', name: 'image', title: 'Image' ,
                        render: function (data, type, row) {
                            return `<div class="square-60 m-auto">
                                        <img class="img-fluid" src="/${row.image?.original}" /></div>`;
                        }
                    },
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
                        <h5 class="modal-title">${data.author}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="form-testimonials" data-testimonials-id="${data.id}">
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label" for="author">Author</label>
                                            <input type="text" class="form-control" id="author" name="author"
                                                value="${data.author}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="position">Position</label>
                                            <input type="text" class="form-control" id="position" name="position"
                                                value="${data.position}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="mb-3">
                                            <div class="img-container"><img class="img-fluid br-5px d-block m-auto"
                                                src="/${data.image?.original}" /></div>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label" for="order">Order</label>
                                          <input class="form-control" type="number" value="${ data.order }"
                                            min="1" max="${dataFilteredCount}" id="order" name="order">
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                          <label class="form-check-label" for="active">Active</label>
                                          <input class="form-check-input" type="checkbox" ${ data.active ? "checked" : "" } id="active" name="active">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="content">Content</label>
                                            <textarea class="form-control" id="content" name="content" rows="7"
                                                placeholder="Textarea content..">${data.content}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between gap-2 flex-wrap flex-md-nowrap">
                                        <button type="submit" class="btn btn-outline-info w-100">Update</button>
                                        ${data.deleted_at ?
                                            '<button type="submit" class="btn btn-outline-secondary w-100" name="restore">Restore</button>'
                                            : '<button type="submit" class="btn btn-outline-warning w-100" name="delete">Delete</button>'
                                        }
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
                let modalTestimonialsDetails = $('.modal-testimonials-details');
                $('.btn-close').add('.modal-testimonials-details').on('click', function(e) {
                    if (e.target != modalTestimonialsDetails[0] && e.target != $('.btn-close')[0]) {
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
                    let data = _this.serializeArray();
                    let action = e.originalEvent.submitter.getAttribute("name");
                    data.push({name: action, value: true});
                    $.ajax({
                        type: 'PUT',
                        url: `/api/testimonials/${_this.data('testimonials-id')}`,
                        data: data,
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
                                    <div class="col-12 col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label" for="author">Author</label>
                                            <input type="text" class="form-control" id="author" name="author" >
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="position">Position</label>
                                            <input type="text" class="form-control" id="position" name="position" >
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="mb-3">
                                            <div class="img-container"><img class="img-fluid br-5px d-block m-auto" /></div>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label" for="order">Order</label>
                                          <input class="form-control" type="number"
                                            min="1" max="${dataFilteredCount}" id="order" name="order">
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
                                                placeholder="Content.."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-outline-info w-100">Update</button>
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
                let modalTestimonialsDetails = $('.modal-testimonials-details');
                $('.btn-close').add('.modal-projects-details').on('click', function(e) {
                    if (e.target != modalTestimonialsDetails[0] && e.target != $('.btn-close')[0]) {
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
                    let data = _this.serializeArray();

                    $.ajax({
                        type: 'POST',
                        url: '/api/testimonials',
                        data: data,
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
        if ($('#projects').length) {
            let params = {
                first_time: true,
                id: '#projects',
                method: 'POST',
                url: '/api/projects/list',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions' ,
                        render: function (data, type, row, params) {
                            return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm js-bs-tooltip-enabled display-projects-details">
                                            <i class="fa fs-3 fa-eye"></i>
                                        </button>
                                    </div>`;
                        }
                    },
                    { data: 'active', name: 'active', title: 'Active', className: 'fs-sm',
                        render: function (data, type, row) {
                            return `<div class="item item-tiny item-circle mx-auto mb-3 ${ row.active ? 'bg-success' : 'bg-danger' }"></div>`;
                    }},
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'order', name: 'order', title: 'Order' },
                    { data: 'role', name: 'role', title: 'Role' ,
                        render: function (data, type, row) {
                            var div = document.createElement('div');
                            div.innerHTML = row.role;
                            return div.innerText;
                    }},
                    { data: 'title', name: 'title', title: 'Title' },
                    { data: 'description', name: 'description', title: 'Description' },
                    { data: 'image', name: 'image', title: 'Image' ,
                        render: function (data, type, row) {
                            return `<div class="square-60 m-auto"><img class="img-fluid" src="/${row.image?.original}" /></div>`;
                        }
                    },
                    { data: 'links', name: 'links', title: 'Links', className: 'text-left',
                        render: function (data, type, row) {
                            let dom = '---';
                            if (row.links) {
                                dom = '<div class="d-flex gap-2 flex-column">';
                                if (row.links?.repository) {
                                    dom += `<div><a href="${row.links?.repository}">Repository <i class="fa-solid fa-up-right-from-square"></i></a></div>`;
                                }
                                if (row.links?.website) {
                                    dom += `<div><a href="${row.links?.website}">Website <i class="fa-solid fa-up-right-from-square"></i></a></div>`;
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
                let created_at = moment(data.updated_at)
                let modal = `
        <div class="modal modal-projects-details" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${data.title || data.role}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="form-projects" data-projects-id="${data.id}">
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label" for="role">Role</label>
                                            <input type="text" class="form-control" id="role" name="role"
                                                value="${data.role || ''}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="${data.title || ''}">
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
                                    <div class="col-12 col-md-4">
                                        <div class="mb-3">
                                            <div class="img-container"><img class="img-fluid br-5px d-block m-auto"
                                                src="/${data.image?.original}" /></div>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label" for="order">Order</label>
                                          <input class="form-control" type="number" value="${ data.order }"
                                            min="1" max="${dataFilteredCount}" id="order" name="order">
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                          <label class="form-check-label" for="active">Active</label>
                                          <input class="form-check-input" type="checkbox" ${ data.active ? "checked" : "" } id="active" name="active">
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                          <label class="form-check-label" for="featured">Featured</label>
                                          <input class="form-check-input" type="checkbox" ${ data.featured ? "checked" : "" } id="featured" name="featured">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4"
                                                placeholder="Textarea content..">${data.description || ''}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between gap-2 flex-wrap flex-md-nowrap">
                                        <button type="submit" class="btn btn-outline-info w-100">Update</button>
                                        ${data.deleted_at ?
                                            '<button type="submit" class="btn btn-outline-secondary w-100" name="restore">Restore</button>'
                                            : '<button type="submit" class="btn btn-outline-warning w-100" name="delete">Delete</button>'
                                        }
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
                let modalProjectsDetails = $('.modal-projects-details');
                $('.btn-close').add('.modal-projects-details').on('click', function(e) {
                    if (e.target != modalProjectsDetails[0] && e.target != $('.btn-close')[0]) {
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
                    let data = _this.serializeArray();
                    let action = e.originalEvent.submitter.getAttribute("name");
                    data.push({name: action, value: true});
                    $.ajax({
                        type: 'PUT',
                        url: `/api/projects/${_this.data('projects-id')}`,
                        data: data,
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
                                    <div class="col-12 col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label" for="role">Role</label>
                                            <input type="text" class="form-control" id="role" name="role">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title">
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
                                    <div class="col-12 col-md-4">
                                        <div class="mb-3">
                                            <div class="img-container"><img class="img-fluid br-5px d-block m-auto" /></div>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label" for="order">Order</label>
                                          <input class="form-control" type="number"
                                            min="1" max="${dataFilteredCount}" id="order" name="order">
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
                                                placeholder="Textarea content.."></textarea>
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
                let modalProjectsDetails = $('.modal-projects-details');
                $('.btn-close').add('.modal-projects-details').on('click', function(e) {
                    if (e.target != modalProjectsDetails[0] && e.target != $('.btn-close')[0]) {
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
                    let data = _this.serializeArray();

                    $.ajax({
                        type: 'POST',
                        url: '/api/projects',
                        data: data,
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
        if ($('#services').length) {
            let params = {
                first_time: true,
                id: '#services',
                method: 'POST',
                url: '/api/services/list',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions' ,
                        render: function (data, type, row, params) {
                            return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm js-bs-tooltip-enabled display-services-details">
                                            <i class="fa fs-3 fa-eye"></i>
                                        </button>
                                    </div>`;
                        }
                    },
                    { data: 'active', name: 'active', title: 'Active', className: 'fs-sm',
                        render: function (data, type, row) {
                            return `<div class="item item-tiny item-circle mx-auto mb-3 ${ row.active ? 'bg-success' : 'bg-danger' }"></div>`;
                    }},
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'order', name: 'order', title: 'Order' },
                    { data: 'slug', name: 'slug', title: 'Slug' },
                    { data: 'title', name: 'title', title: 'Title' },
                    { data: 'description', name: 'description', title: 'Description' ,
                        render: function (data, type, row) {
                            return data.substring(0, 30) + '...';
                        }
                    },
                    { data: 'image', name: 'image', title: 'Image' ,
                        render: function (data, type, row) {
                            return `<div class="square-60 m-auto"><img class="img-fluid" src="/${row.image?.original}" /></div>`;
                        }
                    },
                    { data: 'icon', name: 'icon', title: 'Icon' ,
                        render: function (data, type, row) {
                            var div = document.createElement('div');
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
                        <h5 class="modal-title">${data.title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="form-services" data-services-id="${data.id}">
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label" for="slug">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                value="${data.slug || ''}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="${data.title || ''}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="link">Link</label>
                                            <input type="text" class="form-control" id="link" name="link"
                                                value="${data.link || ''}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="icon">Icon</label>
                                            <input type="text" class="form-control" id="icon" name="icon"
                                                value="${data.icon || ''}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="mb-3">
                                            <div class="img-container"><img class="img-fluid br-5px d-block m-auto"
                                                src="/${data.image?.original}" /></div>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label" for="order">Order</label>
                                          <input class="form-control" type="number" value="${ data.order }"
                                            min="1" max="${dataFilteredCount}" id="order" name="order">
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                          <label class="form-check-label" for="active">Active</label>
                                          <input class="form-check-input" type="checkbox" ${ data.active ? "checked" : "" } id="active" name="active">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4"
                                                placeholder="Textarea content..">${data.description || ''}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between gap-2 flex-wrap flex-md-nowrap">
                                        <button type="submit" class="btn btn-outline-info w-100">Update</button>
                                        ${data.deleted_at ?
                                            '<button type="submit" class="btn btn-outline-secondary w-100" name="restore">Restore</button>'
                                            : '<button type="submit" class="btn btn-outline-warning w-100" name="delete">Delete</button>'
                                        }
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
                let modalServicesDetails = $('.modal-services-details');
                $('.btn-close').add('.modal-services-details').on('click', function(e) {
                    if (e.target != modalServicesDetails[0] && e.target != $('.btn-close')[0]) {
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
                    let data = _this.serializeArray();
                    let action = e.originalEvent.submitter.getAttribute("name");
                    data.push({name: action, value: true});
                    $.ajax({
                        type: 'PUT',
                        url: `/api/services/${_this.data('services-id')}`,
                        data: data,
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
                                    <div class="col-12 col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label" for="slug">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="link">Link</label>
                                            <input type="text" class="form-control" id="link" name="link">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="icon">Icon</label>
                                            <input type="text" class="form-control" id="icon" name="icon">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="mb-3">
                                            <div class="img-container"><img class="img-fluid br-5px d-block m-auto" /></div>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label" for="order">Order</label>
                                          <input class="form-control" type="number"
                                            min="1" max="${dataFilteredCount}" id="order" name="order">
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
                                                placeholder="Content.."></textarea>
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
                let modalServicesDetails = $('.modal-services-details');
                $('.btn-close').add('.modal-services-details').on('click', function(e) {
                    if (e.target != modalServicesDetails[0] && e.target != $('.btn-close')[0]) {
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
                    let data = _this.serializeArray();
                    console.log(data);
                    $.ajax({
                        type: 'POST',
                        url: '/api/services',
                        data: data,
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
