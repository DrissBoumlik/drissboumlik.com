
function setUpImagePreviewOnFileInput(inputFileElementID, imageElementID) {
    let imageElement = document.getElementById(inputFileElementID)
    if (imageElement) {
        imageElement.onchange = (event) => {
            if (event.target.files.length > 0) {
                let src = URL.createObjectURL(event.target.files[0]);
                let preview = document.getElementById(imageElementID);
                preview.src = src;
            }
        };
    }
}

function getDomClass(status) {
    let classes = {
        0: {'value' : 0, 'class' : 'bg-gray text-gray-dark', 'text' : 'Draft'},
        1: {'value' : 1, 'class' : 'bg-success-light text-success', 'text' : 'Published'},
    }
    return classes[status];
}


function configDT(params) {

    if ( $.fn.DataTable.isDataTable(params.id) ) {
        $(params.id).DataTable().destroy();
    }

    let table = new DataTable(params.id, {
        pageLength: 50,
        lengthMenu: [5, 10, 25, 50, 75, 100, 200],
        language: {
            // select: {
            //     style: 'single',
            //     info: false
            // },
            // sWrapper: "dataTables_wrapper dt-bootstrap5",
            // sFilterInput: "form-control form-control-sm",
            // sLengthSelect: "form-select form-select-sm",
            // lengthMenu: "_MENU_",
            // search: "_INPUT_",
            // searchPlaceholder: "Search..",
            // info: "Page <strong>_PAGE_</strong> of <strong>_PAGES_</strong>",
            fnInfoCallback: function( settings, start, end, max, total, pre ) {
                return `${start} <i class="fa-solid fa-arrow-right-long"></i> ${end} | ${total} (Total : ${max})`;
            },
            paginate: {
                first: '<i class="fa fa-angle-double-left"></i>',
                previous: '<i class="fa fa-angle-left"></i>',
                next: '<i class="fa fa-angle-right"></i>',
                last: '<i class="fa fa-angle-double-right"></i>'
            },
            pagingType: "full_numbers",
            pageLength: 5,
        },
        searching: true,
        responsive: true,
        pagingType: 'full_numbers', //'full',
        // autoWidth: true,
        processing: true,
        serverSide: true,
        ajax: {
            type: params.method,
            url: params.url,
            data: function(data) {
                if ( params.data ) {
                    for (const dataKey in params.data) {
                        data[dataKey] = params.data[dataKey];
                    }
                }
                data._token = $('meta[name="csrf-token"]').attr('content');
                data.first_time = params.first_time;
            }
            , error: function (jqXHR, textStatus, errorThrown) {
                get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.message, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                if (jqXHR.responseJSON.message.toLowerCase().includes("csrf")) {
                    location.reload(true);
                }
            }
        },
        columns: params.columns,
        initComplete: function (settings, json) {
            delete params.first_time;
            if (params.onComplete) {
                params.onComplete(settings, json);
            }
            $('#search-row').remove();
            this.find('thead').prepend('<tr id="search-row" class="search-row"></tr>');
            this.api().columns().every(function (index) {
                let column = this;
                let dataTitle = column.dataSrc();
                let currentColumn = params.columns[index];
                let title = currentColumn.title;
                if (title.toLowerCase() === "actions") {
                    $('#search-row').append('<th></th>');
                    return;
                }
                // Create input element
                if (currentColumn.domElement === "select" || currentColumn.data === 'active') {
                    let items = json.data.map( function (item) {
                        let _item = {};
                        if (currentColumn.data === 'active') {
                            _item.active = item.active;
                        } else {
                            _item[currentColumn.data] = item[currentColumn.data] ;
                        }
                        if (currentColumn.optionTextField) {
                            _item[currentColumn.optionTextField] = item[currentColumn.optionTextField];
                        }
                        return _item;
                    }).reduce((acc, current) => {
                        let exists = acc.find(item => {
                            return item[currentColumn.data] === current[currentColumn.data]
                        });
                        if (!exists) {
                            acc.push(current);
                        }
                        return acc;
                    }, []);
                    let domSelectOptions = `<option value="">${title}</option>`;

                    items.forEach(function(item) {
                        domSelectOptions += `<option value="${item[currentColumn.data]}">${item[currentColumn.optionTextField || currentColumn.data]}</option>`;
                    });
                    let headerSearchItem = `<th><select id="${dataTitle}-dt-search" title="${title}"
                                                            placeholder="${title}" type="search"
                                                            style="min-width: 100px"
                                                            class="form-control form-control-sm text-center"
                                                            >${domSelectOptions}</select></th>`;
                    $('#search-row').append(headerSearchItem);
                    let select = document.getElementById(`${dataTitle}-dt-search`);
                    // Event listener for user input
                    let start = undefined;
                    select.addEventListener('change', (e) => {
                        clearTimeout(start);
                        start = setTimeout(function () {
                            if (column.search() !== this.value) {
                                column.search(select.value).draw();
                            }
                        }, 1000 );
                    });
                } else {
                    let headerSearchItem = `<th><input id="${dataTitle}-dt-search" title="${title}"
                                                            placeholder="${title}" type="search"
                                                            style="min-width: 100px"
                                                            class="form-control form-control-sm text-center"></th>`;
                    $('#search-row').append(headerSearchItem);
                    let input = document.getElementById(`${dataTitle}-dt-search`);

                    // Event listener for user input
                    let start = undefined;
                    input.addEventListener('input', (e) => {
                        clearTimeout(start);
                        start = setTimeout(function () {
                            if (column.search() !== this.value) {
                                column.search(input.value).draw();
                            }
                        }, 1000 );
                    });
                }
            });
        }
    });
    $('.btn-refresh').on('click', function (e) {
        table.ajax.reload(null, false);
    });
    $(document).on('click', '.btn-clear', function (e) {
        clearDtSearchInput('search-row', table);
    });
    return table;
}

function clearDtSearchInput(searchElementID, table) {
    const searchRow = document.getElementById(searchElementID);

    const inputs = searchRow.querySelectorAll('input');
    const selects = searchRow.querySelectorAll('select');

    inputs.forEach(input => {
        input.value = '';
    });

    selects.forEach(select => {
        select.selectedIndex = 0; // Resets to the first option
    });

    table.search( '' ).columns().search( '' ).draw();
}

function remove_loader() {
    const loader = document.querySelector('.spinner-global');
    if (loader) {
        loader.remove();
    }
}

function get_loader() {
    remove_loader();

    const loader = `<div class="spinner-global spinner-border" role="status"
                                style="width: 3rem; height: 3rem; position: fixed; bottom: 1rem; right: 1rem;
                                border-color: var(--tc-grey-dark) transparent var(--tc-grey-dark) var(--tc-grey-dark);">
                            <span class="visually-hidden">Loading...</span>
                        </div>`;

    document.body.insertAdjacentHTML('beforeend', loader);
}

function get_alert_box(params, removeLoader = true) {
    if (removeLoader) {
        let loader = document.querySelector('.spinner-border');
        if (loader) {
            loader.remove();
        }
    }

    let alertElement = document.querySelector('.alert.alert-dismissible');
    if (alertElement) {
        alertElement.remove();
    }

    let alertElementHTML = `
        <div data-notify="container" class="col-11 col-sm-8 col-md-5 col-lg-4 alert ${params.class}
            alert-dismissible animated fadeIn" role="alert" data-notify-position="bottom-right"
            style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1060; bottom: 20px; right: 20px; animation-iteration-count: 1;">
            <p class="mb-0">
                <span data-notify="icon">${params.icon}</span>
                <span data-notify="title"></span>
                <span data-notify="message">${params.message}</span>
            </p>
            <a class="p-2 m-1 text-dark" href="javascript:void(0)" aria-label="Close" data-notify="dismiss"
                data-bs-dismiss="alert"
                style="position: absolute; right: 10px; top: 5px; z-index: 1035;">
                <i class="fa fa-times"></i>
            </a>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', alertElementHTML);

}

function getToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

export { setUpImagePreviewOnFileInput, getDomClass, configDT, get_alert_box, get_loader, remove_loader, getToken };
