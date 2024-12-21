
document.addEventListener('DOMContentLoaded', function () {
    try {
        const btnExport = document.querySelector('.btn-export');
        if (btnExport) {
            btnExport.addEventListener('click', function () {
                let tablesNames = null;
                const exportAllTablesCheckbox = document.getElementById('export-all-tables');
                if (! exportAllTablesCheckbox.checked) {
                    tablesNames = '';
                    document.querySelectorAll('#tables .table-item').forEach(function (e) {
                        if (e.checked) {
                            tablesNames += e.closest('tr').querySelector('.table-name').innerText + ' ';
                        }
                    });
                    tablesNames = tablesNames.trim();
                }
                const dontCreateTables = document.getElementById('dont-create-tables').checked;
                const dontExportData = document.getElementById('dont-export-data').checked;

                const queryString = [
                    tablesNames ? `tables=${tablesNames}` : '',
                    dontExportData ? 'dont-export-data=1' : '',
                    dontCreateTables ? 'dont-create-tables=1' : ''
                ].filter(Boolean).join('&');

                window.open(`/admin/export-db?${queryString}`);
            });
        }

        const btnExportAll = document.getElementById('export-all-tables');
        if (btnExportAll) {
            btnExportAll.addEventListener('click', function () {
                const tableItems = document.querySelectorAll('.table-item');
                tableItems.forEach(function (item) {
                    item.checked = btnExportAll.checked;
                });
            });
        }
    } catch (error) {
        console.error(error);
    }
});
