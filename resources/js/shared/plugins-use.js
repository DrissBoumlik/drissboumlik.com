import {getDomClass, shortenTextIfLongByLength} from "../admin/functions";
import {get_alert_box, getCookie} from "./functions";

function initChart() {
    if ($('.charts').length === 0) {
        return;
    }
    let defaultValue = 'countryName';
    initChartByField(defaultValue);
    initChartByYearEvents(defaultValue);
}

function initChartByYearEvents(defaultValue = 'countryName') {
    const ctx = document.getElementById('myChart2');
    if (ctx === null) {
        return;
    }
    let columnsList2 = $('#columns-list2')
    let pagesList2 = $('#pages-list2');
    let yearsList = $('#years-list2');
    let perpageList2 = $('#perpage-list2');
    let params = {
        columnSelected: defaultValue,
        pagesList: pagesList2,
        visitsChart: null,
        ctx,
        page: 1,
        yearSelected: moment().year()
    };
    initChartByYear(params);
    columnsList2.on('change', function() {
        params.columnSelected = columnsList2.val();
        params.page = 1;
        params.yearSelected = yearsList.val();
        initChartByYear(params);
    });
    yearsList.on('change', function() {
        params.columnSelected = columnsList2.val();
        params.page = 1;
        params.yearSelected = yearsList.val();
        initChartByYear(params);
    });
    pagesList2.on('change', function() {
        params.columnSelected = columnsList2.val();
        params.page = pagesList2.val();
        params.yearSelected = yearsList.val();
        initChartByYear(params);
    });
    perpageList2.on('change', function() {
        params.columnSelected = columnsList2.val();
        params.page = 1;
        params.yearSelected = yearsList.val();
        params.perPage = perpageList2.val();
        initChartByYear(params);
    });
}

function initChartByYear(params) {
    $.ajax({
        type: 'POST',
        url: `/api/stats?page=${params.page}`,
        data: {table: 'visitors', column: params.columnSelected, year: params.yearSelected, perPage: params.perPage},
        success: function(response) {
            if (params.page === 1) {
                let html = '';
                for (let i = 1; i <= response.last_page; i++) {
                    html += `<option value="${i}">Page ${i}</option>`;
                }
                params.pagesList.html(html);
            }
            let _datasets = [];
            if (response.data.length === 0) {
                _datasets.push({
                    label: 'NO DATA FOUND',
                    data: null,
                    borderWidth: 1
                });
            } else {
                let monthsData = Object.groupBy(response.data, (item) => item[params.columnSelected]);
                for (let key in monthsData) {
                    let dataTmp = monthsData[key];
                    if (dataTmp) {
                        let _data = [];
                        let labels_tmp = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                        monthsData[key].forEach(function (a) {
                            _data[a.month - 1] = a.visits;
                            delete labels_tmp[a.month - 1];
                        });
                        labels_tmp.forEach(function (k, i) {
                            _data[i] = 0;
                        })
                        _datasets.push({
                            label: key,
                            data: _data,
                            borderWidth: 1
                        });
                    }
                }
            }

            if (params.visitsChart) { params.visitsChart.destroy(); }
            let _labels =["January","February","March","April","May","June","July", "August","September","October","November","December"];
            params.visitsChart = makeChart({
                ctx: params.ctx,
                labels: _labels,
                datasets: _datasets,
                title: `Visits of ${params.yearSelected}`
            });
        }
    });
}
function initChartByField(defaultValue = 'countryName') {
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
                html += `<option value="${k}" ${k === defaultValue ? 'selected' : ''}>${k}</option>`;
            });
            let columnsList = $('#columns-list')
            let columnsList2 = $('#columns-list2')
            let pagesList = $('#pages-list');
            let perpageList = $('#perpage-list');
            columnsList.html(html);
            columnsList2.html(html);
            let params = {columnSelected: defaultValue, pagesList, visitsChart: null, ctx, page: 1};
            getColumnStats(params);
            columnsList.on('change', function() {
                params.columnSelected = columnsList.val();
                params.page = 1;
                getColumnStats(params);
            });

            pagesList.on('change', function() {
                params.columnSelected = columnsList.val();
                params.page = pagesList.val();
                getColumnStats(params);
            });

            perpageList.on('change', function() {
                params.columnSelected = columnsList.val();
                params.page = 1;
                params.perPage = perpageList.val();
                getColumnStats(params);
            });
        }
    });
}

function getColumnStats(params) {
    $.ajax({
        type: 'POST',
        url: `/api/stats?page=${params.page}`,
        data: {table: 'visitors', column: params.columnSelected, perPage: params.perPage},
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

            params.visitsChart = makeChart({
                ctx: params.ctx,
                title: `Visits by ${params.columnSelected}`,
                labels: _labels,
                datasets: [{
                    label: `Visits nb by ${params.columnSelected}`,
                    data: _data,
                    borderWidth: 1
                }]
            });
        }
    });
}

function makeChart(params) {
    return new Chart(params.ctx, {
        type: 'bar',
        data: {
            labels: params.labels,
            datasets: params.datasets
        },
        options: {
            responsive: params.responsive || true,
            maintainAspectRatio: params.maintainAspectRatio || false,
            plugins: {
                title: {
                    display: true,
                    text: params.title
                },
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
                        mode: 'x',
                    }
                }
            }
        }
    });
}


function initPostEditor() {
    if ($('#post_body').length == 0) return;
    let options = {
        selector: 'textarea#post_body',
        plugins: 'searchreplace autolink visualblocks visualchars media charmap nonbreaking anchor insertdatetime advlist wordcount help emoticons autosave code link table lists codesample image preview pagebreak',
        toolbar: 'code codesample link image pagebreak | undo redo restoredraft | bold italic underline | alignleft aligncenter alignright alignjustify lineheight indent outdent | bullist numlist',
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

            { text: 'Batch', value: 'batch' },
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
    };
    let theme = getCookie('theme');
    if (theme === 'dark-mode') {
        options = {...options,  skin: 'oxide-dark', content_css: 'dark'};
    }
    let tinymceDOM = tinymce.get('post_body');
    if(tinymceDOM != null) {
        let _content = tinymceDOM.getContent();
        tinymceDOM.destroy();
        tinymceDOM.setContent(_content);
    }
    tinymce.init(options);
}

function initFlatpickr() {
    if ($('.js-flatpickr').length == 0) return;
    One.helpersOnLoad('js-flatpickr');
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
                                <a href="/blog/${row.slug}" class="link-dark">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Edit Client" data-bs-original-title="Edit Client">
                                <a href="/admin/posts/edit/${row.slug}" class="link-dark">
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
                { data: 'published', name: 'published', title: 'Published',
                    render: function (data, type, row, params) {
                        let published = getDomClass(row.published);
                        return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill ${published.class}">${published.text}</span`;
                    }},
                { data: 'featured', name: 'featured', title: 'Featured', className: 'fs-sm',
                    render: function (data, type, row, params) {
                        return `<div class="item item-tiny item-circle mx-auto mb-3
                        ${row.featured ? 'bg-success' : 'bg-danger' }"></div>`;
                }},
                { data: 'views', name: 'views', title: '<i class="fa-solid fa-eye"></i>', className: 'text-center'},
                { data: 'likes', name: 'likes', title: '<i class="fa-solid fa-thumbs-up"></i>', className: 'text-center'},
                { data: 'tags_count', name: 'tags_count', title: 'Tags', className: 'text-center', searchable: false},
                { data: 'published_at', name: 'published_at', title: 'Published @', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        let published_at_for_humans = row.published_at ? moment(row.published_at).fromNow() : '------';
                        let published_at_formatted = row.published_at ? moment(row.published_at).format('Y-M-D hh:mm') : '------';
                        return `<span title="${published_at_formatted}">${published_at_for_humans}<br/>${published_at_formatted}</span>`;
                    }},
                { data: 'created_at', name: 'created_at', title: 'Created @', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        let created_at_for_humans = moment(row.created_at).fromNow();
                        let created_at_formatted = moment(row.created_at).format('Y-M-D hh:mm');
                        return `<span title="${created_at_formatted}">${created_at_for_humans}<br/>${created_at_formatted}</span>`;
                    }},
                { data: 'updated_at', name: 'updated_at', title: 'Updated @', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        let updated_at_for_humans = moment(row.updated_at).fromNow();
                        let updated_at_formatted = moment(row.updated_at).format('Y-M-D hh:mm');
                        return `<span title="${updated_at_formatted}">${updated_at_for_humans}<br/>${updated_at_formatted}</span>`;
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
                                <a href="/tags/${row.slug}" class="link-dark">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Edit Client" data-bs-original-title="Edit Client">
                                <a href="/admin/tags/edit/${row.slug}" class="link-dark">
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
                { data: 'created_at', name: 'created_at', title: 'Created @', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        let created_at_for_humans = moment(row.created_at).fromNow();
                        let created_at_formatted = moment(row.created_at).format('Y-M-D hh:mm');
                        return `<span title="${created_at_formatted}">${created_at_for_humans}<br/>${created_at_formatted}</span>`;
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
                { data: 'id', name: 'id', title: 'Actions', className: 'text-center',
                    render: function (data, type, row, params) {
                        return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm js-bs-tooltip-enabled display-visitor-details">
                                <i class="fa fs-3 fa-eye"></i>
                            </button>
                        </div>
                    `;
                    }
                },
                { data: 'id', name: 'id', title: 'ID', className: 'text-center'},
                { data: 'ip', name: 'ip', title: 'IP', className: 'text-center'},
                { data: 'url', name: 'url', title: 'URL', className: 'text-left'},
                { data: 'ref_source', name: 'ref_source', title: 'Source', className: 'text-left'},
                { data: 'ref_medium', name: 'ref_medium', title: 'Medium', className: 'text-left'},
                { data: 'updated_at', name: 'updated_at', title: 'Updated @', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        let updated_at_for_humans = moment(row.updated_at).fromNow();
                        let updated_at_formatted = moment(row.updated_at).format('Y-M-D hh:mm');
                        return `<span title="${updated_at_formatted}">${updated_at_for_humans}<br/>${updated_at_formatted}</span>`;
                    }
                },
                { data: 'countryCode', name: 'countryCode', title: 'Country Code', className: 'fw-semibold fs-sm'},
                { data: 'currencyCode', name: 'currencyCode', title: 'Currency Code', className: 'fw-semibold fs-sm'},
                { data: 'countryName', name: 'countryName', title: 'Country Name', className: 'fw-semibold fs-sm'},
                { data: 'regionName', name: 'regionName', title: 'Region Name', className: 'fw-semibold fs-sm'},
                { data: 'cityName', name: 'cityName', title: 'City Name', className: 'fw-semibold fs-sm'},
                { data: 'latitude', name: 'latitude', title: 'Latitude', className: 'fw-semibold fs-sm'},
                { data: 'longitude', name: 'longitude', title: 'Longitude', className: 'fw-semibold fs-sm'},
                { data: 'regionCode', name: 'regionCode', title: 'Region Code', className: 'fw-semibold fs-sm'},
                { data: 'zipCode', name: 'zipCode', title: 'Zip Code', className: 'fw-semibold fs-sm'},
                { data: 'isoCode', name: 'isoCode', title: 'Iso Code', className: 'fw-semibold fs-sm'},
                { data: 'postalCode', name: 'postalCode', title: 'Postal Code', className: 'fw-semibold fs-sm'},
                { data: 'metroCode', name: 'metroCode', title: 'Metro Code', className: 'fw-semibold fs-sm'},
                { data: 'areaCode', name: 'areaCode', title: 'Area Code', className: 'fw-semibold fs-sm'},
                { data: 'timezone', name: 'timezone', title: 'Timezone', className: 'fw-semibold fs-sm'},
                { data: 'driver', name: 'driver', title: 'Driver', className: 'fw-semibold fs-sm'},
            ]
        };
        let visitorsDataTable = configDT(params);
        $('#visitors').on('click', '.display-visitor-details', function(e) {
            const $row = $(this).closest('tr');
            const data = visitorsDataTable.row( $row ).data();
            let created_at = moment(data.updated_at)
            let modal = `
            <div class="modal modal-visitor-details" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">${data.countryName}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <form id="form-visitor" data-visitor-id="${data.id}">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="country-name">Country</label>
                                                <input type="text" class="form-control" id="country-name" name="countryName"
                                                    value="${data.countryName}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="country-code">Country Code</label>
                                                <input type="text" class="form-control" id="country-code" name="countryCode"
                                                    value="${data.countryCode}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="region-name">Region</label>
                                                <input type="text" class="form-control" id="region-name" name="regionName"
                                                    value="${data.regionName}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="city-name">City</label>
                                                <input type="text" class="form-control" id="city-name" name="cityName"
                                                    value="${data.cityName}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">IP : ${data.ip}</label>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">URL : ${data.url}</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Source : ${data.ref_source}</label>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Medium : ${data.ref_medium}</label>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Created @ : ${created_at.format('Y-M-D hh:mm')} / ${created_at.fromNow()}</label>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Zip Code : ${data.zipCode}</label>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Latitude : ${data.latitude}</label>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Logitude : ${data.longitude}</label>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">TimeZone : ${data.timezone}</label>
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
            let modalVisitorDetails = $('.modal-visitor-details');
            $('.btn-close').add('.modal-visitor-details').on('click', function(e) {
                if (e.target != modalVisitorDetails[0] && e.target != $('.btn-close')[0]) {
                    return;
                }
                modalVisitorDetails.remove();
                $('.modal-backdrop').remove();
            });
            modalVisitorDetails.show()

            $(document).off('submit', '#form-visitor').on('submit', '#form-visitor', function(e) {
                e.preventDefault();
                if (!confirm("Are you sure ?")) {
                    return;
                }
                let _this = $(this);
                let data = _this.serializeArray();
                $.ajax({
                    type: 'PUT',
                    url: `/api/visitors/${_this.data('visitor-id')}`,
                    data: data,
                    success: function(response) {
                        console.log(response);
                        visitorsDataTable.ajax.reload(null, false);
                        get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        console.log(jqXHR, textStatus, errorThrown);
                        get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.msg, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                    }
                });
            });

        });
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
                { data: 'created_at', name: 'created_at', title: 'Created @', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        let created_at_for_humans = moment(row.created_at).fromNow();
                        let created_at_formatted = moment(row.created_at).format('Y-M-D hh:mm');
                        return `<span title="${created_at_formatted}">${created_at_for_humans}<br/>${created_at_formatted}</span>`;
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
                                <label for="exampleFormControlInput1" class="form-label">Created @ : ${created_at.format('Y-M-D hh:mm')} / ${created_at.fromNow()}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>`;
            $('#page-container').append(modal);
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
    if ($('#subscriptions').length) {
        let params = {
            first_time: true,
            id: '#subscriptions',
            method: 'POST',
            url: '/api/subscriptions',
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
                { data: 'subscription_id', name: 'subscription_id',title: 'Subscription Id', className: 'text-center' },
                { data: 'email', name: 'email', title: 'Email', className: 'text-center' },
                { data: 'first_name', name: 'first_name', title: 'First Name', className: 'text-center' },
                { data: 'last_name', name: 'last_name', title: 'Last Name', className: 'text-center' },
                { data: 'subscribed_at', name: 'subscribed_at', title: 'Subscribed At', className: 'text-center' },
                { data: 'token_verification', name: 'token_verification', title: 'Token Verification', className: 'text-center '},
                { data: 'created_at', name: 'created_at', title: 'Created @', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        let created_at_for_humans = moment(row.created_at).fromNow();
                        let created_at_formatted = moment(row.created_at).format('Y-M-D hh:mm');
                        return `<span title="${created_at_formatted}">${created_at_for_humans}<br/>${created_at_formatted}</span>`;
                    }
                },
            ]
        };
        let subscriptionsDataTable = configDT(params);
    }

    if ($('#testimonials').length) {
        let params = {
            first_time: true,
            id: '#testimonials',
            method: 'POST',
            url: '/api/testimonials',
            columns: [
                { data: 'id', name: 'id', title: 'Actions', className: 'text-center',
                    render: function (data, type, row, params) {
                        return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm js-bs-tooltip-enabled display-testimonials-details">
                                <i class="fa fs-3 fa-eye"></i>
                            </button>
                        </div>
                    `;
                    }
                },
                { data: 'id', name: 'id', title: 'ID', className: 'text-center'},
                { data: 'author', name: 'author', title: 'Author', className: 'text-center'},
                { data: 'content', name: 'content', title: 'Content', className: 'text-center',
                    render: function(data, type, row) {
                        var div = document.createElement('div');
                        div.innerHTML = row.content.substring(0, 100) + "...";
                        return div.innerText;
                    }
                },
                { data: 'image', name: 'image', title: 'Image', className: 'text-center',
                    render: function (data, type, row) {
                        return `<div class="square-60 m-auto"><img class="img-fluid" src="/assets/img/people/${row.image}" /></div>`;
                    }
                },
                { data: 'position', name: 'position', title: 'Position', className: 'text-center'},
                { data: 'hidden', name: 'hidden', title: 'Active', className: 'fs-sm',
                    render: function (data, type, row) {
                        return `<div class="item item-tiny item-circle mx-auto mb-3 ${ row.hidden ? 'bg-danger' : 'bg-success' }"></div>`;
                }}
            ]
        };
        let testimonialsDataTable = configDT(params);
        $('#testimonials').on('click', '.display-testimonials-details', function(e) {
            const $row = $(this).closest('tr');
            const data = testimonialsDataTable.row( $row ).data();
            let created_at = moment(data.updated_at)
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
                                                    src="/assets/img/people/${data.image}" /></div>
                                            </div>
                                            <div class="mb-3 form-check form-switch">
                                              <label class="form-check-label" for="active">Active</label>
                                              <input class="form-check-input" type="checkbox" ${ data.hidden ? "" : "checked" } id="active" name="active">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="content">Content</label>
                                                <textarea class="form-control" id="content" name="content" rows="7"
                                                    placeholder="Textarea content..">${data.content}</textarea>
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
                $.ajax({
                    type: 'PUT',
                    url: `/api/testimonials/${_this.data('testimonials-id')}`,
                    data: data,
                    success: function(response) {
                        console.log(response);
                        testimonialsDataTable.ajax.reload(null, false);
                        get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        console.log(jqXHR, textStatus, errorThrown);
                        get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.msg, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
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
            url: '/api/projects',
            columns: [
                { data: 'id', name: 'id', title: 'Actions', className: 'text-center',
                    render: function (data, type, row, params) {
                        return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm js-bs-tooltip-enabled display-projects-details">
                                <i class="fa fs-3 fa-eye"></i>
                            </button>
                        </div>
                    `;
                    }
                },
                { data: 'id', name: 'id', title: 'ID', className: 'text-center'},
                { data: 'role', name: 'role', title: 'Role', className: 'text-center',
                    render: function (data, type, row) {
                        var div = document.createElement('div');
                        div.innerHTML = row.role;
                        return div.innerText;
                }},
                { data: 'title', name: 'title', title: 'Title', className: 'text-center'},
                { data: 'description', name: 'description', title: 'Description', className: 'text-center'},
                { data: 'image', name: 'image', title: 'Image', className: 'text-center',
                    render: function (data, type, row) {
                        return `<div class="square-60 m-auto"><img class="img-fluid" src="/assets/img/work/${row.image}" /></div>`;
                    }
                },
                { data: 'links', name: 'links', title: 'Links', className: 'text-left',
                    render: function (data, type, row) {
                        console.log(data);
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
                { data: 'hidden', name: 'hidden', title: 'Active', className: 'fs-sm',
                    render: function (data, type, row) {
                        return `<div class="item item-tiny item-circle mx-auto mb-3 ${ row.hidden ? 'bg-danger' : 'bg-success' }"></div>`;
                }},
                { data: 'featured', name: 'featured', title: 'Featured', className: 'fs-sm',
                    render: function (data, type, row) {
                        return `<div class="item item-tiny item-circle mx-auto mb-3 ${ row.featured ? 'bg-success' : 'bg-danger' }"></div>`;
                }},
            ]
        };
        let projectsDataTable = configDT(params);
        $('#projects').on('click', '.display-projects-details', function(e) {
            const $row = $(this).closest('tr');
            const data = projectsDataTable.row( $row ).data();
            let created_at = moment(data.updated_at)
            let modal = `
            <div class="modal modal-projects-details" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">${data.title}</h5>
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
                                                    value="${data.links.repository || ''}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="website">Website</label>
                                                <input type="text" class="form-control" id="website" name="links[website]"
                                                    value="${data.links.website || ''}">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <div class="img-container"><img class="img-fluid br-5px d-block m-auto"
                                                    src="/assets/img/work/${data.image}" /></div>
                                            </div>
                                            <div class="mb-3 form-check form-switch">
                                              <label class="form-check-label" for="active">Active</label>
                                              <input class="form-check-input" type="checkbox" ${ data.hidden ? "" : "checked" } id="active" name="active">
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
                    type: 'PUT',
                    url: `/api/projects/${_this.data('projects-id')}`,
                    data: data,
                    success: function(response) {
                        console.log(response);
                        projectsDataTable.ajax.reload(null, false);
                        get_alert_box({class: 'alert-info', message: response.msg, icon: '<i class="fa-solid fa-check-circle"></i>'});
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        console.log(jqXHR, textStatus, errorThrown);
                        get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.msg, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                    }
                });
            });

        });
    }
}

function configDT(params) {
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
            this.find('thead').prepend('<tr id="search-row"></tr>');
            this.api().columns().every(function (index) {
                let column = this;
                let dataTitle = column.dataSrc();
                let title = params.columns[index].title;
                if (title.toLowerCase() === "actions") {
                    $('#search-row').append('<th></th>');
                    return;
                }
                // Create input element
                let headerSearchItem = `<th><input id="${dataTitle}" title="${dataTitle}" placeholder="${dataTitle.toUpperCase()}" type="search" style="min-width: 100px" class="form-control form-control-sm"></th>`;
                $('#search-row').append(headerSearchItem);
                let input = document.getElementById(dataTitle);

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
            });
        }
    });
    $('.btn-refresh').on('click', function (e) {
        table.ajax.reload(null, false);
    });
    return table;
}

export { initPostEditor, initSelect2, initDatatable, initChart, initFlatpickr };
