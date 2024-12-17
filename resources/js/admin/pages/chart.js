
document.addEventListener('DOMContentLoaded', function () {
    try {
        if (document.querySelector('.charts') === null) {
            return;
        }
        const defaultValue = 'countryName';
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
    fetch('/api/visitors/columns', { method: 'GET' })
        .then((response) => response.json())
        .then((response) => {
            const columnsList = document.getElementById('columns-list');
            const columnsList2 = document.getElementById('columns-list2');
            const pagesList = document.getElementById('pages-list');
            const perPageList = document.getElementById('perpage-list');
            let html = '';
            response.forEach(function(k,i) {
                html += `<option value="${k}" ${k === defaultValue ? 'selected' : ''}>${k}</option>`;
            });
            columnsList.innerHTML = html;
            columnsList2.innerHTML = html;
            const params = {columnSelected: defaultValue, pagesList, visitsChart: null, ctx, page: 1};
            getColumnStats(params);
            columnsList.addEventListener('change', function() {
                params.columnSelected = columnsList.value;
                params.page = 1;
                getColumnStats(params);
            });

            pagesList.addEventListener('change', function() {
                params.columnSelected = columnsList.value;
                params.page = pagesList.value;
                getColumnStats(params);
            });

            perPageList.addEventListener('change', function() {
                params.columnSelected = columnsList.value;
                params.page = 1;
                params.perPage = perPageList.value;
                getColumnStats(params);
            });
        })
        .catch((error) => console.error(error));
}

function getColumnStats(params) {
    fetch(`/api/stats?page=${params.page}`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
            body: JSON.stringify({ table: 'visitors', column: params.columnSelected, perPage: params.perPage}),
        })
        .then((response) => response.json())
        .then((response) => {
            if (params.page === 1) {
                let html = '';
                for (let i = 1; i <= response.last_page; i++) {
                    html += `<option value="${i}">Page ${i}</option>`;
                }
                params.pagesList.innerHTML = html;
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
        })
        .catch((error) => console.error('Error fetching stats:', error));
}

function initChartByYearEvents(defaultValue = 'countryName') {
    const ctx = document.getElementById('myChart2');
    if (ctx === null) {
        return;
    }
    const columnsList2 = document.getElementById('columns-list2');
    const pagesList2 = document.getElementById('pages-list2');
    const yearsList = document.getElementById('years-list2');
    const perpageList2 = document.getElementById('perpage-list2');
    const params = {
        columnSelected: defaultValue,
        pagesList: pagesList2,
        visitsChart: null,
        ctx,
        page: 1,
        yearSelected: moment().year()
    };
    initChartByYear(params);
    columnsList2.addEventListener('change', function() {
        params.columnSelected = columnsList2.value;
        params.page = 1;
        params.yearSelected = yearsList.value;
        initChartByYear(params);
    });
    yearsList.addEventListener('change', function() {
        params.columnSelected = columnsList2.value;
        params.page = 1;
        params.yearSelected = yearsList.value;
        initChartByYear(params);
    });
    pagesList2.addEventListener('change', function() {
        params.columnSelected = columnsList2.value;
        params.page = pagesList2.value;
        params.yearSelected = yearsList.value;
        initChartByYear(params);
    });
    perpageList2.addEventListener('change', function() {
        params.columnSelected = columnsList2.value;
        params.page = 1;
        params.yearSelected = yearsList.value;
        params.perPage = perpageList2.value;
        initChartByYear(params);
    });
}

function initChartByYear(params) {
    fetch(`/api/stats?page=${params.page}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: JSON.stringify({table: 'visitors', column: params.columnSelected, year: params.yearSelected, perPage: params.perPage,}),
        })
        .then((response) => response.json())
        .then((response) => {
            if (params.page === 1) {
                let html = '';
                for (let i = 1; i <= response.last_page; i++) {
                    html += `<option value="${i}">Page ${i}</option>`;
                }
                params.pagesList.innerHTML = html;
            }
            let _datasets = [];
            if (response.data.length === 0) {
                _datasets.push({
                    label: 'NO DATA FOUND',
                    data: null,
                    borderWidth: 1
                });
            } else {
                const monthsData = Object.groupBy(response.data, (item) => item[params.columnSelected]);
                for (let key in monthsData) {
                    let dataTmp = monthsData[key];
                    if (dataTmp) {
                        let _data = new Array(12).fill(0); // Initialize with 0 for 12 months
                        monthsData[key].forEach(function (a) {
                            _data[a.month - 1] = a.visits;
                        });
                        _datasets.push({
                            label: key,
                            data: _data,
                            borderWidth: 1
                        });
                    }
                }
            }

            if (params.visitsChart) { params.visitsChart.destroy(); }
            const _labels =["January","February","March","April","May","June","July", "August","September","October","November","December"];
            params.visitsChart = makeChart({
                ctx: params.ctx,
                labels: _labels,
                datasets: _datasets,
                title: `Visits of ${params.yearSelected}`
            });
        })
        .catch((error) => console.error(error));
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
