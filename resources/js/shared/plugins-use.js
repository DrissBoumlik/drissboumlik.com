import {shortenTextIfLongByLength, getDomClass} from "../admin/functions";

function initChart() {
    const ctx = document.getElementById('myChart');
    if (ctx === null) {
        return;
    }
    $.ajax({
        type: 'GET',
        url: '/api/visitors/columns',
        success: function(response) {
            let html = '';
            response.forEach(function(k,i) {
                html += `<option value="${k}" ${k === 'countryName' ? 'selected' : ''}>${k}</option>`;
            });
            let columnsList = $('#columns-list')
            let pagesList = $('#pages-list');
            columnsList.html(html);
            let params = {columnSelected: 'countryName', pagesList, visitsChart: null, ctx, page: 1};
            getColumnStats(params);
            columnsList.on('change', function() {
                let columnSelected = $("option:selected", this).val();
                params.columnSelected = columnSelected;
                params.page = 1;
                getColumnStats(params);
            });

            pagesList.on('change', function() {
                let columnSelected = columnsList.val();
                let pageSelected = $("option:selected", this).val();
                params.columnSelected = columnSelected;
                params.page = pageSelected;
                getColumnStats(params);
            });
        }
    });
}

function getColumnStats(params) {
    $.ajax({
        type: 'GET',
        url: `/api/stats/visitors/${params.columnSelected}?page=${params.page}`,
        success: function(response) {

            if (params.page === 1) {
                let html = '';
                for (let i = 1; i <= response.last_page; i++) {
                    html += `<option value="${i}">Page ${i}</option>`;
                }
                params.pagesList.html(html);
            }

            let responseData = response.data;
            let _labels = responseData.map(a => a[params.columnSelected]);
            let _data = responseData.map(a => a.visits);
            if (params.visitsChart) { params.visitsChart.destroy(); }
            params.visitsChart = new Chart(params.ctx, {
                type: 'bar',
                data: {
                    labels: _labels,
                    datasets: [{
                        label: `Number of visits by ${params.columnSelected}`,
                        data: _data,
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        zoom: {
                            zoom: {
                                drag: {
                                    enabled: true,
                                },
                                wheel: {
                                    enabled: true,
                                },
                                pinch: {
                                    enabled: true
                                },
                                mode: 'xy',
                            }
                        }
                    }
                }
            });
        }
    });
}

function initPostEditor() {
    if ($('#post_body').length == 0) return;
    tinymce.init({
        selector: 'textarea#post_body', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'code link table lists codesample image preview pagebreak',
        toolbar: 'code codesample link image | undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | table | pagebreak preview',
        pagebreak_separator: '<hr/>',
        height: 700,
        fixed_toolbar_container: '.tox-editor-header',
        codesample_languages: [
            { text: 'Bash', value: 'bash' },
            { text: 'Typscript', value: 'typscript' },
            { text: 'Markdown', value: 'markdown' },
            { text: 'Pug', value: 'pug' },
            { text: 'Sass', value: 'sass' },
            { text: 'Yaml', value: 'yaml' },
            { text: 'SQL', value: 'sql' },

            { text: 'HTML/XML', value: 'markup' },
            { text: 'CSS', value: 'css' },
            { text: 'JavaScript', value: 'javascript' },
            { text: 'PHP', value: 'php' },
            { text: 'Ruby', value: 'ruby' },
            { text: 'Python', value: 'python' },
            { text: 'Java', value: 'java' },
            { text: 'C', value: 'c' },
            { text: 'C#', value: 'csharp' },
            { text: 'C++', value: 'cpp' }
        ],
    });
    // let options = { };
    // Laraberg.init('post_body', options)
}

function initSelect2() {
    if ($('.js-select2').length == 0) return;
    One.helpersOnLoad(['jq-select2']);
}
let t = null;

function initDatatable() {
    if ($('#posts').length) {
        let params = {
            first_time: true,
            id: '#posts',
            method: 'POST',
            url: '/api/posts',
            columns: [
                { data: 'id', name: 'id', title: 'Actions', className: 'text-center',
                    render: function (data, type, row, params) {
                        return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Edit Client" data-bs-original-title="Edit Client">
                                <a href="/blog/${row.slug}" target="_blank" class="link-dark">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Edit Client" data-bs-original-title="Edit Client">
                                <a href="/admin/posts/edit/${row.slug}" target="_blank" class="link-dark">
                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                </a>
                            </button>
                        </div>
                    `;
                    }},
                { data: 'id', name: 'id', title: 'ID', className: 'text-center'},
                { data: 'title', name: 'title', title: 'Title', className: 'fw-semibold fs-sm',
                    render: function (data, type, row, params) {
                        return `<span data-bs-toggle="tooltip" title="${row.title}">${shortenTextIfLongByLength(row.title,20)}</span>`;
                    }},
                { data: 'status', name: 'status', title: 'Status',
                    render: function (data, type, row, params) {
                        let status = getDomClass(row.status);
                        return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill ${status.class}">${status.text}</span`;
                    }},
                { data: 'featured', name: 'featured', title: 'Featured', className: 'fs-sm',
                    render: function (data, type, row, params) {
                        return `<div class="item item-tiny item-circle mx-auto mb-3
                        ${row.featured ? 'bg-success' : 'bg-danger' }"></div>`;
                }},
                { data: 'views', name: 'views', title: '<i class="fa-solid fa-eye"></i>', className: 'text-center'},
                { data: 'likes', name: 'likes', title: '<i class="fa-solid fa-thumbs-up"></i>', className: 'text-center'},
                { data: 'tags_count', name: 'tags_count', title: 'tags', className: 'text-center', searchable: false},
                { data: 'published_at', name: 'published_at', title: 'Published @', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        let published_at_for_humans = moment(row.published_at).fromNow();
                        let published_at_formatted = moment(row.published_at).format('Y-M-d hh:mm');
                        return `<span title="${published_at_formatted}">${published_at_for_humans}</span>`;
                    }},
                { data: 'created_at', name: 'created_at', title: 'Created @', clasxsName: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        let created_at_for_humans = moment(row.created_at).fromNow();
                        let created_at_formatted = moment(row.created_at).format('Y-M-d hh:mm');
                        return `<span title="${created_at_formatted}">${created_at_for_humans}</span>`;
                    }},
                { data: 'updated_at', name: 'updated_at', title: 'Updated @', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        let updated_at_for_humans = moment(row.updated_at).fromNow();
                        let updated_at_formatted = moment(row.updated_at).format('Y-M-d hh:mm');
                        return `<span title="${updated_at_formatted}">${updated_at_for_humans}</span>`;
                    }},
                { data: 'deleted_at', name: 'deleted_at', title: 'Active', className: 'fs-sm',
                    render: function (data, type, row, params) {
                        return `<div class="item item-tiny item-circle mx-auto mb-3 ${!row.deleted_at ? 'bg-success' : 'bg-danger' }"></div>`;
                }},
            ]
        };
        configDT(params);
    }
    if ($('#tags').length) {
        let params = {
            first_time: true,
            id: '#tags',
            method: 'POST',
            url: '/api/tags',
            columns: [
                { data: 'id', name: 'id', title: 'Actions', className: 'text-center',
                    render: function (data, type, row, params) {
                        return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Edit Client" data-bs-original-title="Edit Client">
                                <a href="/tags/${row.slug}" target="_blank" class="link-dark">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Edit Client" data-bs-original-title="Edit Client">
                                <a href="/admin/tags/edit/${row.slug}" target="_blank" class="link-dark">
                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                </a>
                            </button>
                        </div>
                    `;
                }},
                { data: 'id', name: 'id', title: 'ID', className: 'text-center'},
                { data: 'name', name: 'name', title: 'Name', className: 'fw-semibold fs-sm'},
                { data: 'slug', name: 'slug', title: 'Slug', className: 'fw-semibold fs-sm'},
                { data: 'color', name: 'color', title: 'Color', className: 'fw-semibold fs-sm',
                    render: function(data, type, row, params) {
                        return `<div class="item item-tiny item-circle mx-auto mb-3"
                             style="background-color: ${row.color}"></div>`;
                    }
                },
                { data: 'posts_count', name: 'posts_count', title: 'Posts', className: 'fw-semibold fs-sm', searchable: false},
                { data: 'created_at', name: 'created_at', title: 'created @', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        let created_at_for_humans = moment(row.created_at).fromNow();
                        let created_at_formatted = moment(row.created_at).format('Y-M-d hh:mm');
                        return `<span title="${created_at_formatted}">${created_at_for_humans}</span>`;
                }},
                { data: 'deleted_at', name: 'deleted_at', title: 'Active', className: 'fs-sm',
                    render: function (data, type, row, params) {
                        return `<div class="item item-tiny item-circle mx-auto mb-3 ${!row.deleted_at ? 'bg-success' : 'bg-danger' }"></div>`;
                }},
            ]
        };
        configDT(params);
    }
    if ($('#visitors').length) {
        let params = {
            first_time: true,
            id: '#visitors',
            method: 'POST',
            url: '/api/visitors',
            columns: [
                { data: 'id', name: 'id', title: 'ID', className: 'text-center'},
                { data: 'ip', name: 'ip', title: 'IP', className: 'text-center'},
                { data: 'url', name: 'url', title: 'URL', className: 'text-left'},
                { data: 'updated_at', name: 'updated_at', title: 'updated @', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        let updated_at_for_humans = moment(row.updated_at).fromNow();
                        let updated_at_formatted = moment(row.updated_at).format('Y-M-d hh:mm');
                        return `<span title="${updated_at_formatted}">${updated_at_for_humans}</span>`;
                    }
                },
                { data: 'countryCode', name: 'countryCode', title: 'Country Code', className: 'fw-semibold fs-sm'},
                { data: 'countryName', name: 'countryName', title: 'Country Name', className: 'fw-semibold fs-sm'},
                { data: 'regionName', name: 'regionName', title: 'Region Name', className: 'fw-semibold fs-sm'},
                { data: 'cityName', name: 'cityName', title: 'City Name', className: 'fw-semibold fs-sm'},
                { data: 'latitude', name: 'latitude', title: 'latitude', className: 'fw-semibold fs-sm'},
                { data: 'longitude', name: 'longitude', title: 'longitude', className: 'fw-semibold fs-sm'},
                { data: 'regionCode', name: 'regionCode', title: 'Region Code', className: 'fw-semibold fs-sm'},
                { data: 'zipCode', name: 'zipCode', title: 'Zip Code', className: 'fw-semibold fs-sm'},
                { data: 'isoCode', name: 'isoCode', title: 'Iso Code', className: 'fw-semibold fs-sm'},
                { data: 'postalCode', name: 'postalCode', title: 'Postal Code', className: 'fw-semibold fs-sm'},
                { data: 'metroCode', name: 'metroCode', title: 'Metro Code', className: 'fw-semibold fs-sm'},
                { data: 'areaCode', name: 'areaCode', title: 'Area Code', className: 'fw-semibold fs-sm'},
                { data: 'timezone', name: 'timezone', title: 'timezone', className: 'fw-semibold fs-sm'},
                { data: 'driver', name: 'driver', title: 'driver', className: 'fw-semibold fs-sm'},
            ]
        };
        configDT(params);
    }
    if ($('#messages').length) {
        let params = {
            first_time: true,
            id: '#messages',
            method: 'POST',
            url: '/api/messages',
            columns: [
                { data: 'id', name: 'id', title: 'Actions', className: 'text-center',
                    render: function (data, type, row, params) {
                        return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm js-bs-tooltip-enabled display-email-details">
                                <i class="fa fs-3 fa-eye"></i>
                            </button>
                        </div>
                    `;
                    }
                },
                { data: 'id', name: 'id', title: 'ID', className: 'text-center'},
                { data: 'name', name: 'name', title: 'Name', className: 'text-center'},
                { data: 'email', name: 'email', title: 'Email', className: 'text-center'},
                { data: 'body', name: 'body', title: 'Body', className: 'text-center',
                    render: function(data, type, row, params) {
                        return data.substring(0, 30) + '...';
                    }
                },
                { data: 'created_at', name: 'created_at', title: 'created @', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        let created_at_for_humans = moment(row.created_at).fromNow();
                        let created_at_formatted = moment(row.created_at).format('Y-M-d hh:mm');
                        return `<span title="${created_at_formatted}">${created_at_for_humans}</span>`;
                    }
                },
            ]
        };
        let messagesDataTable = configDT(params);
        $('#messages').on('click', '.display-email-details', function(e) {
            const $row = $(this).closest('tr');
            const data = messagesDataTable.row( $row ).data();

            let created_at = moment(data.created_at);

            let modal = `
            <div class="modal modal-email-details" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">${data.name}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Sender : ${data.name}</label>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Email : ${data.email}</label>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Message : <br/>${data.body}</label>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Created @ : ${created_at.format('Y-M-d hh:mm')} / ${created_at.fromNow()}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>`;
            $('body').append(modal);
            let modalEmailDetails = $('.modal-email-details');
            $('.btn-close').add('.modal-email-details').on('click', function(e) {
                if (e.target != modalEmailDetails[0] && e.target != $('.btn-close')[0]) {
                    return;
                }
                modalEmailDetails.remove();
                $('.modal-backdrop').remove();
            });
            modalEmailDetails.show()
        });
    }
}

function configDT(params) {
    let table = new DataTable(params.id, {
        pageLength: 50,
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
                data._token = $('meta[name="csrf-token"]').attr('content');
                data.first_time = params.first_time;
            }
        },
        columns: params.columns,
        initComplete: function (settings, json) {
            delete params.first_time;
            if (params.onComplete) {
                params.onComplete(settings, json);
            }
        }
    });
    $('.btn-refresh').on('click', function (e) {
        table.ajax.reload(null, false);
    });
    return table;
}

export { initPostEditor, initSelect2, initDatatable, initChart };
