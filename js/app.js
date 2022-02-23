function formatE(d) {
    var tr = '';
    for (const p in d) {
        tr += '<tr><td></td><td></td><td></td><td>' + d[p].p.toUpperCase() + '</td><td>' + d[p].cantidad.toFixed(3) + '</td><td>' + d[p].u.toUpperCase() + '</td><td>' + formatter.format(d[p].subtotal) + '</td></tr>';
    }
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr><td></td><td></td><td></td><td>Producto</td><td>Cantidad</td><td>Unidad</td><td>Subtotal</td></tr>' +
        tr +
        '</table>';
}
function formatS(d) {
    var tr = '';
    for (const p in d) {
        tr += '<tr><td></td><td></td><td></td><td>' + d[p].p.toUpperCase() + '</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
        for (const p_r in d[p].ranc_prod){
            tr += '<tr><td></td><td></td><td></td><td></td><td>' + d[p].ranc_prod[p_r].r.toUpperCase() + '</td><td></td><td></td><td></td><td></td><td></td></tr>';
            for (const r_s in d[p].ranc_prod[p_r].sect_prod){
                tr += '<tr><td></td><td></td><td></td><td></td><td></td><td>' + d[p].ranc_prod[p_r].sect_prod[r_s].s.toUpperCase() + '</td><td>' + d[p].ranc_prod[p_r].sect_prod[r_s].cant_s.toFixed(3) + '</td><td>' + d[p].ranc_prod[p_r].sect_prod[r_s].u.toUpperCase() + '</td><td>' + formatter.format(d[p].ranc_prod[p_r].sect_prod[r_s].subt_sec) + '</td><td>' + formatter.format(d[p].ranc_prod[p_r].sect_prod[r_s].cost_h) + '</td></tr>';
            }
        }
    }
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr><td></td><td></td><td></td><td>Producto</td><td>Rancho</td><td>Sector</td><td>Cantidad</td><td>Unidad</td><td>Subtotal</td><td>Costo por héctarea</td</tr>' +
        tr +
        '</table>';
        /* return d; */
}
function exportTableToCSV($table, filename) {
    //rescato los títulos y las filas
    var $Tabla_Nueva = $table.find('tr:has(td,th)');
    // elimino la tabla interior.
    var Tabla_Nueva2 = $Tabla_Nueva.filter(function () {
        return (this.childElementCount != 1);
    });
    var $rows = Tabla_Nueva2,
        // Temporary delimiter characters unlikely to be typed by keyboard
        // This is to avoid accidentally splitting the actual contents
        tmpColDelim = String.fromCharCode(11), // vertical tab character
        tmpRowDelim = String.fromCharCode(0), // null character

        colDelim = (filename.indexOf("xls") != -1) ? '"\t"' : '","',
        rowDelim = '"\r\n"',
        // Grab text from table into CSV formatted string
        csv = '"' + $rows.map(function (i, row) {
            var $row = $(row);
            var $cols = $row.find('td:not(.hidden),th:not(.hidden)');
            return $cols.map(function (j, col) {
                var $col = $(col);
                var text = $col.text()/* .replace(/\./g, '') */;
                return text.replace('"', '""'); // escape double quotes
            }).get().join(tmpColDelim);
            csv = csv + '"\r\n"' + 'fin ' + '"\r\n"';
        }).get().join(tmpRowDelim)
            .split(tmpRowDelim).join(rowDelim)
            .split(tmpColDelim).join(colDelim) + '"';
    download_csv(csv, filename);
}

function download_csv(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV FILE
    csvFile = new Blob([csv], { type: "text/csv" });
    // Download link
    downloadLink = document.createElement("a");
    // File name
    downloadLink.download = filename;
    // We have to create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);
    // Make sure that the link is not displayed
    downloadLink.style.display = "none";
    // Add the link to your DOM
    document.body.appendChild(downloadLink);
    // Lanzamos
    downloadLink.click();
}

const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 2
});

function getTableEntradas(fechaI, fechaF){
    var table = $('#table-entradas').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'info': false,
        'dom': 'Bfrti',
        'stateSave': true,
        'buttons': [
            {
                extend: 'excelHtml5',
                text: 'Excel',
                titleAttr: 'Excel',
                "oSelectorOpts": { filter: 'applied', order: 'current' },
                "sFileName": "report.xls",
                action: function (e, dt, button, config) {
                    exportTableToCSV.apply(this, [$('#table-entradas'), 'export.xls']);
                },
                exportOptions: {
                    modifier: {
                        page: 'current'
                    }
                }
            }
        ],
        'searching': false,
        'ajax': {
            'url': 'table-entradas.php',
            'data': { 'fechaI': fechaI, 'fechaF': fechaF },
            'type': 'post',
        },
        'columns': [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: ''
            },
            {
                data: 'rubro',
                render: function (data, type) {
                    return data.toUpperCase();
                }
            },
            {
                data: 'total',
                render: function (data, type) {
                    var number = $.fn.dataTable.render.number(',', '.', 2, '$').display(data);
                    return number;
                }
            },
        ],
        'footerCallback': function (row, data, start, end, display) {
            var api = this.api();
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            // Total over all pages
            total = api
                .column(2)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            // Total over this page
            pageTotal = api
                .column(2, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            // Update footer
            $(api.column(2).footer()).html(
                formatter.format(total)
                /* '$'+pageTotal +' ( $'+ total +' total)' */
            );
        }
    });
    
    $('#table-entradas tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child(formatE(row.data().productos)).show();
            tr.addClass('shown');
        }
    });
}

function getTableSalidas(fechaI, fechaF){
    var table = $('#table-salidas').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'info': false,
        'dom': 'Bfrti',
        'stateSave': true,
        'buttons': [
            {
                extend: 'excelHtml5',
                text: 'Excel',
                titleAttr: 'Excel',
                "oSelectorOpts": { filter: 'applied', order: 'current' },
                "sFileName": "report.xls",
                action: function (e, dt, button, config) {
                    exportTableToCSV.apply(this, [$('#table-salidas'), 'export.xls']);
                },
                exportOptions: {
                    modifier: {
                        page: 'current'
                    }
                }
            }
        ],
        'searching': false,
        'ajax': {
            'url': 'table-salidas.php',
            'data': { 'fechaI': fechaI, 'fechaF': fechaF },
            'type': 'post',
        },
        'columns': [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: ''
            },
            {
                data: 'rubro',
                render: function (data, type) {
                    return data.toUpperCase();
                }
            },
            {
                data: 'total',
                render: function (data, type) {
                    var number = $.fn.dataTable.render.number(',', '.', 2, '$').display(data);
                    return number;
                }
            },
        ],
        'footerCallback': function (row, data, start, end, display) {
            var api = this.api();
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            // Total over all pages
            total = api
                .column(2)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            // Total over this page
            pageTotal = api
                .column(2, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            // Update footer
            $(api.column(2).footer()).html(
                formatter.format(total)
            );
        }
    });

    $('#table-salidas tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child(formatS(row.data().productos)).show();
            tr.addClass('shown');
        }
    });
}

$(document).ready(function () {        
    $("#entradas").click(function() {
        if ($.fn.DataTable.isDataTable("#table-entradas")) {
            $("#table-entradas").dataTable().fnDestroy();
            $('#table-entradas tbody').remove();
            getTableEntradas($('#fechaInicio').val(), $('#fechaFin').val());
        }else{
            getTableEntradas($('#fechaInicio').val(), $('#fechaFin').val());
        }
    });
    $("#salidas").click(function() {
        /* alert('salidas'); */
        /* getTableSalidas($('#fechaInicio').val(), $('#fechaFin').val()); */
        if ($.fn.DataTable.isDataTable("#table-salidas")) {
            $("#table-salidas").dataTable().fnDestroy();
            alert('destro');
            $('#table-salidas tbody').remove();
            getTableSalidas($('#fechaInicio').val(), $('#fechaFin').val());
        }else{
            getTableSalidas($('#fechaInicio').val(), $('#fechaFin').val());
        }
    });
});