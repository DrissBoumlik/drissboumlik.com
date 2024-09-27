// import 'bootstrap';
import {get_alert_box, get_loader, toggleDarkMode} from "../shared/functions";
import { initPostEditor } from "../admin/pages/post";

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

        initPostEditor();
    });
}

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

function shortenTextIfLongByLength(text, length, end = '...'){
    return text.length < length ? text : text.substring(0, length) + end;
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
    return table;
}


export { initDarkMode, initAjaxEvents, shortenTextIfLongByLength, getDomClass, string_to_slug, configDT };
