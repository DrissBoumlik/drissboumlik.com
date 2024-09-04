
$(function () {
    try {
        let btnExport = $('.btn-export');
        if (btnExport.length) {
            btnExport.on('click', function () {
                let tablesNames = null;
                if (!$('#export-all-tables').prop('checked')) {
                    tablesNames = '';
                    document.querySelectorAll('#tables .table-item').forEach(function (e) {
                        if (e.checked) {
                            tablesNames += e.closest('tr').querySelector('.table-name').innerText + ' ';
                        }
                    });
                    tablesNames = tablesNames.trim();
                }
                let dontCreateTables = $('#dont-create-tables').prop('checked');
                let dontExportData = $('#dont-export-data').prop('checked');
                let queryString = `${tablesNames ? 'tables=' + tablesNames : ''}
                                            &
                                            ${dontExportData ? 'dont-export-data=1' : ''}
                                            &
                                            ${dontCreateTables ? 'dont-create-tables=1' : ''}`;
                window.open('/admin/export-db?' + queryString);
            });
        }

        let btnExportAll = $('#export-all-tables');
        if (btnExportAll.length) {
            btnExportAll.on('click', function() {
                $('.table-item').prop('checked', this.checked)
            });
        }
    } catch (error) {
        // console.log(error);
    }
});
