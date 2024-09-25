import { get_alert_box } from "../../shared/functions";
import { configDT } from "../functions";

$(function () {
    try {

        if ($('#menus').length) {
            let menuTypesCounts = {};
            let params = {
                first_time: true,
                id: '#menus',
                method: 'POST',
                url: '/api/menus',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions' ,
                        render: function (data, type, row, params) {
                            return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm js-bs-tooltip-enabled display-menus-details">
                                            <i class="fa fs-3 fa-eye"></i>
                                        </button>
                                    </div>`;
                        }
                    },
                    { data: 'active', name: 'active', title: 'Active', className: 'fs-sm', inputType: 'select',
                        render: function (data, type, row) {
                            return `<div class="item item-tiny item-circle mx-auto mb-3 ${ row.active ? 'bg-success' : 'bg-danger' }"></div>`;
                        }},
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'order', name: 'order', title: 'Order' },
                    { data: 'slug', name: 'slug', title: 'Slug' },
                    { data: 'text', name: 'text', title: 'Text' ,
                        render: function (data, type, row) {
                            var div = document.createElement('div');
                            div.innerHTML = row.text;
                            return div.innerText;
                        }
                    },
                    { data: 'title', name: 'title', title: 'Title' ,
                        render: function (data, type, row) {
                            var div = document.createElement('div');
                            div.innerHTML = row.title;
                            return div.innerText;
                        }
                    },
                    { data: 'target', name: 'target', title: 'Target' , domElement: 'select'},
                    { data: 'menu_type_id', name: 'menu_type_id', title: 'Type' ,
                        domElement: 'select', optionTextField: 'type_name',
                        render: function (data, type, row) {
                            return row.type_name;
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
                ],
                onComplete: function (settings, json) {
                    json.data.forEach(function (item) {
                        if (! menuTypesCounts[item.type_name]) {
                            menuTypesCounts[item.type_name] = 1;
                        } else {
                            menuTypesCounts[item.type_name] += 1;
                        }
                    });
                }
            };
            let MenusDataTable = configDT(params);

            let menuTypesItems = [];
            // api to fetch menu types for select option
            $.ajax({
                type: 'POST',
                url: '/api/menu-types?api',
                data: {},
                success: function(response) {
                    menuTypesItems = response.data;
                },
                error: function (jqXHR, textStatus, errorThrown){
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });

            $('#menus').on('click', '.display-menus-details', function(e) {
                const $row = $(this).closest('tr');
                const data = MenusDataTable.row( $row ).data();
                let dataFilteredCount = menuTypesCounts[data.type_name];
                let created_at = moment(data.updated_at)
                let menuTypesOptions = '';
                menuTypesItems.forEach(function (item) {
                    menuTypesOptions += `<option value="${item.id}" ${data.menu_type_id === item.id ? "selected" : ""}>${item.name}</option>`;
                });
                let modal = `
        <div class="modal modal-menus-details" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${data.title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="form-menus" data-menus-id="${data.id}" data-menus-type="${data.menu_type_id}">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="slug">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                value="${data.slug || ''}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="text">Text</label>
                                            <input type="text" class="form-control" id="text" name="text"
                                                value="${data.text || ''}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="${data.title || ''}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="icon">Icon</label>
                                            <input type="text" class="form-control" id="icon" name="icon"
                                                value="${data.icon || ''}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="repository">Link</label>
                                            <input type="text" class="form-control" id="link" name="link"
                                                value="${data.link || ''}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="target">Target</label>
                                            <select id="target" name="target" class="form-control">
                                                <option value="_self">Target</option>
                                                <option value="_self" ${data.target == '_self' ? 'selected' : ''}>_self</option>
                                                <option value="_blank" ${data.target == '_blank' ? 'selected' : ''}>_blank</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="menu-type">Type</label>
                                            <select id="menu-type" name="menu-type" class="form-control">
                                                ${menuTypesOptions}
                                            </select>
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
                let modalMenusDetails = $('.modal-menus-details');
                $('.btn-close').add('.modal-menus-details').on('click', function(e) {
                    if (e.target != modalMenusDetails[0] && e.target != $('.btn-close')[0]) {
                        return;
                    }
                    modalMenusDetails.remove();
                    $('.modal-backdrop').remove();
                });
                modalMenusDetails.show();

                $(document).off('submit', '#form-menus').on('submit', '#form-menus', function(e) {
                    e.preventDefault();
                    if (!confirm("Are you sure ?")) {
                        return;
                    }
                    let _this = $(this);
                    let data = _this.serializeArray();
                    data.push({ name: "menu_type", value: _this.data('menus-type') }) ;
                    $.ajax({
                        type: 'PUT',
                        url: `/api/menus/${_this.data('menus-id')}`,
                        data: data,
                        success: function(response) {
                            MenusDataTable.ajax.reload(null, false);
                            get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
                        },
                        error: function (jqXHR, textStatus, errorThrown){
                            console.log(jqXHR, textStatus, errorThrown);
                            get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.message, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                        }
                    });
                });

            });
        }

        if ($('#menu-types').length) {
            let params = {
                first_time: true,
                id: '#menu-types',
                method: 'POST',
                url: '/api/menu-types',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions' ,
                        render: function (data, type, row, params) {
                            return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm js-bs-tooltip-enabled
                                                                        display-menuTypes-details">
                                            <i class="fa fs-3 fa-eye"></i>
                                        </button>
                                    </div>`;
                        }
                    },
                    { data: 'active', name: 'active', title: 'Active', className: 'fs-sm', inputType: 'select',
                        render: function (data, type, row) {
                            return `<div class="item item-tiny item-circle mx-auto mb-3 ${ row.active ? 'bg-success' : 'bg-danger' }"></div>`;
                        }},
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'name', name: 'name', title: 'Name' },
                    { data: 'slug', name: 'slug', title: 'Slug' },
                    { data: 'description', name: 'description', title: 'Description' },
                ]
            };
            let MenuTypesDataTable = configDT(params);

            $('#menu-types').on('click', '.display-menuTypes-details', function(e) {
                const $row = $(this).closest('tr');
                const data = MenuTypesDataTable.row( $row ).data();
                let created_at = moment(data.updated_at)
                let modal = `
        <div class="modal modal-menuTypes-details" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${data.name}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="form-menuTypes" data-menu-types-id="${data.id}">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="${data.name || ''}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="slug">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                value="${data.slug || ''}">
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
                let modalMenuTypesDetails = $('.modal-menuTypes-details');
                $('.btn-close').add('.modal-menuTypes-details').on('click', function(e) {
                    if (e.target != modalMenuTypesDetails[0] && e.target != $('.btn-close')[0]) {
                        return;
                    }
                    modalMenuTypesDetails.remove();
                    $('.modal-backdrop').remove();
                });
                modalMenuTypesDetails.show();

                $(document).off('submit', '#form-menuTypes').on('submit', '#form-menuTypes', function(e) {
                    e.preventDefault();
                    if (!confirm("Are you sure ?")) {
                        return;
                    }
                    let _this = $(this);
                    let data = _this.serializeArray();
                    $.ajax({
                        type: 'PUT',
                        url: `/api/menu-types/${_this.data('menu-types-id')}`,
                        data: data,
                        success: function(response) {
                            MenuTypesDataTable.ajax.reload(null, false);
                            get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
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
