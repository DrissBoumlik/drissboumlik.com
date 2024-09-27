import { get_alert_box } from "../../shared/functions";
import { configDT } from "../functions";

$(function () {
    try {

        if ($('#menus').length) {

            $.ajax({
                type: 'POST',
                url: '/api/menu-types?api',
                success: function(response) {
                    let menuTypesItems = response.data;

                    if (! menuTypesItems || ! menuTypesItems.length) {
                        get_alert_box({class: 'alert-danger', message: "No Menu Types found", icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                        return;
                    }


                    let optionsDom = '';
                    menuTypesItems.forEach(function (item) {
                        optionsDom += `<option value="${item.id}" data-count="${item.menus_count}">${item.name} (${item.menus_count})</option>`;
                    });
                    optionsDom = `<option value="">All Menus</option>` + optionsDom;
                    let menuTypesSelectElement = $('#menu-types-items');
                    menuTypesSelectElement.html(optionsDom);
                    menuTypesSelectElement.on('change', function (e) {
                        let selectedMenuType = menuTypesSelectElement.val();
                        let MenusDataTable = setupDT(menuTypesItems, selectedMenuType);
                    });

                    let MenusDataTable = setupDT(menuTypesItems, null);

                    $(document).off('click', '.btn-new').on('click', '.btn-new', function(e) {

                        let selectedMenuType = parseInt(menuTypesSelectElement.val());
                        let dataFilteredCount = menuTypesSelectElement.find('option:selected').data('count')
                                                || menuTypesItems[0].menus_count;
                        let menuTypesOptions = '';
                        menuTypesItems.forEach(function (item) {
                            menuTypesOptions += `<option value="${item.id}" data-count="${item.menus_count}"
                                                        ${selectedMenuType === item.id ? "selected" : ""}>${item.name}</option>`;
                        });
                        let modal = `
        <div class="modal modal-menus-details" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Menu item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="form-menus">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="slug">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug" >
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="text">Text</label>
                                            <input type="text" class="form-control" id="text" name="text" >
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" >
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="icon">Icon</label>
                                            <input type="text" class="form-control" id="icon" name="icon" >
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="repository">Link</label>
                                            <input type="text" class="form-control" id="link" name="link" >
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="target">Target</label>
                                            <select id="target" name="target" class="form-control">
                                                <option value="_self">_self</option>
                                                <option value="_blank">_blank</option>
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
                                          <input class="form-control" type="number" value="${dataFilteredCount}"
                                            min="1" max="${dataFilteredCount}" id="order" name="order">
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                          <label class="form-check-label" for="active">Active</label>
                                          <input class="form-check-input" type="checkbox" id="active" name="active">
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
                        onMenuTypeSelectChange('#menu-type');
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
                            $.ajax({
                                type: 'POST',
                                url: '/api/menus',
                                data: data,
                                success: function(response) {
                                    MenusDataTable.ajax.reload(null, false);
                                    get_alert_box({class: 'alert-info', message: response.message, icon: '<i class="fa-solid fa-check-circle"></i>'});
                                },
                                error: function (jqXHR, textStatus, errorThrown){
                                    console.log(jqXHR, textStatus, errorThrown);
                                    get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.message, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                                }
                            });
                        });

                    });

                },
                error: function (jqXHR, textStatus, errorThrown){
                    console.log(jqXHR, textStatus, errorThrown);
                }
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


function setupDT(menuTypesItems, menuType = null) {
    let params = {
        first_time: true,
        id: '#menus',
        method: 'POST',
        url: '/api/menus/list',
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
        ]
    };
    if (menuType) {
        params['data'] = { menu_type: menuType };
    }
    let MenusDataTable = configDT(params);

    $('#menus').off('click', '.display-menus-details').on('click', '.display-menus-details', function(e) {
        const $row = $(this).closest('tr');
        const data = MenusDataTable.row( $row ).data();
        let dataFilteredCount = menuTypesItems.find((item) => item.id == data.menu_type_id).menus_count;
        let menuTypesOptions = '';
        menuTypesItems.forEach(function (item) {
            menuTypesOptions += `<option value="${item.id}" data-count="${item.menus_count}" ${data.menu_type_id === item.id ? "selected" : ""}>${item.name}</option>`;
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
        onMenuTypeSelectChange('#menu-type');
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
            let action = e.originalEvent.submitter.getAttribute("name");
            data.push({name: action, value: true});
            $.ajax({
                type: 'PUT',
                url: `/api/menus/${_this.data('menus-id')}`,
                data: data,
                success: function(response) {
                    MenusDataTable.ajax.reload(null, false);
                    get_alert_box({class: 'alert-info', message: response.message, icon: '<i class="fa-solid fa-check-circle"></i>'});
                },
                error: function (jqXHR, textStatus, errorThrown){
                    console.log(jqXHR, textStatus, errorThrown);
                    get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.message, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                }
            });
        });

    });

    return MenusDataTable;
}

function onMenuTypeSelectChange(element_id) {
    $(element_id).on('change', function (e) {
        console.log($(this).find('option:selected').data('count'));
        let menusCount = $(this).find('option:selected').data('count') + 1;
        $('#order').prop('max', menusCount);
        $('#order').prop('value', menusCount);
    });
}
