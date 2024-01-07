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
                { data: 'published', name: 'published', title: 'published',
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
                { data: 'tags_count', name: 'tags_count', title: 'tags', className: 'text-center', searchable: false},
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
                { data: 'created_at', name: 'created_at', title: 'created @', className: 'text-center fs-sm',
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
                { data: 'updated_at', name: 'updated_at', title: 'updated @', className: 'text-center fs-sm',
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
                console.log(data);
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
                { data: 'created_at', name: 'created_at', title: 'created @', className: 'text-center fs-sm',
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
        }
    });
    $('.btn-refresh').on('click', function (e) {
        table.ajax.reload(null, false);
    });
    return table;
}

export { initPostEditor, initSelect2, initDatatable, initChart, initFlatpickr };
