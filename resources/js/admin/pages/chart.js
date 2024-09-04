
$(function () {
    try {
        if ($('.charts').length === 0) {
            return;
        }
        let defaultValue = 'countryName';
        initChartByField(defaultValue);
        initChartByYearEvents(defaultValue);
    } catch (error) {
        // console.log(error);
    }
});

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
