
<?php
include 'view/cabecera.php';
date_default_timezone_set('America/Mexico_City');
?>

<div class="card-body">
    <div class="container-fluid">
        <H1>Módulo Ejecutivo</H1>
        <div class="row py-2  px-2" style="background-color: #e3e6ec">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sub">Fecha Inicio :</label>
                    <input type="date" class="form-control" required name="fechaInicio" id="fechaInicio" value="<?= (empty($_SESSION['concentradoFechaInicio'])) ? date("Y-m-d", strtotime(date('Y-m-d') . "- 28 days")) : $_SESSION['ViajeFechaInicio'] ?>">
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group ">
                    <label for="sub">Fecha Fin:</label>
                    <input type="date" class="form-control" required name="fechaFin" id="fechaFin" value="<?= (empty($_SESSION['concentradoFechaFin'])) ? date("Y-m-d") : $_SESSION['monitoreoFechaFin'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn btn-outline-success btn-block" id="entradas_c">ENTRADAS</button>
                <button class="btn btn-outline-primary btn-block" id="salidas" name="salidas">SALIDAS</button>
            </div>
        </div>

        <?php /* include 'table1.php' */ ?>
        <div class="container mt-5">
            <h2 style="margin-bottom: 30px;">Entradas</h2>
            <table class="table table-striped table-bordered table-hover" id="table1" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Rubro</th>
                        <th>Costo</th>
                        <!-- <th>productos</th>  --> 
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" style="text-align:right">Total:</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="container mt-5">
            <h2 style="margin-bottom: 30px;">Modulo Ejecutivo</h2>
            <table class="table table-striped table-bordered table-hover" id="dataTable-entradas" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>cantidad</th>
                        <th>nombre</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div> <!-- card-body -->

<?php include "view/piePagina.php";
/* define('DIR_J','http://inomac.test/'); */
define('DIR_J', 'http://localhost:8080/local/dev/adm/in/');
/*  define('DIR_J','https://pruebas.inomac.mx/ejecutivo'); */
?>
<script type="text/javascript">
    function format ( d ) {
        var tr = '';
        for(const p in d){
            tr += '<tr><td></td><td></td><td>'+d[p].p.toUpperCase()+'</td><td>'+d[p].cantidad+'</td><td>'+formatter.format(d[p].subtotal)+'</td></tr>';
        }
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                    '<tr><td></td><td></td><td>Producto</td><td>Cantidad</td><td>Precio</td></tr>'+
                    tr+
                '</table>';
    }
    function exportTableToCSV($table, filename) {
        //rescato los títulos y las filas
        var $Tabla_Nueva = $table.find('tr:has(td,th)');
        // elimino la tabla interior.
        var Tabla_Nueva2= $Tabla_Nueva.filter(function() {
            return (this.childElementCount != 1 );
        });
        var $rows = Tabla_Nueva2,
        // Temporary delimiter characters unlikely to be typed by keyboard
        // This is to avoid accidentally splitting the actual contents
        tmpColDelim = String.fromCharCode(11), // vertical tab character
        tmpRowDelim = String.fromCharCode(0), // null character

        colDelim = (filename.indexOf("xls") !=-1)? '"\t"': '","',
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
            csv =csv +'"\r\n"' +'fin '+'"\r\n"';
        }).get().join(tmpRowDelim)
            .split(tmpRowDelim).join(rowDelim)
            .split(tmpColDelim).join(colDelim) + '"';
        download_csv(csv, filename);
    }

    function download_csv(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV FILE
        csvFile = new Blob([csv], {type: "text/csv"});
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

    $(document).ready(function() {
        /* $('#dataTable-entradas').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'info': false,
            'dom': 'Bfrtip',
            'buttons':[
                'excel'
            ],
            'searching': false,
            'ajax': {
                'url': 'table.php'
            },
            'columns': [
                { data: 'id_prod' },
                { data: 'cantidad' },
                { data: 'nom_prod' },
                { data: 'clasificacion' }
            ]
        }); */
        var table = $('#table1').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'info': false,
            'dom': 'Bfrti',
            'stateSave': true,
            'buttons':[
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    titleAttr: 'Excel',
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "sFileName": "report.xls",
                    action : function( e, dt, button, config ) {
                        exportTableToCSV.apply(this, [$('#table1'), 'export.xls']);
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
                'url': 'table1.php',
                'data' : { 'fechaI': $('#fechaInicio').val(), 'fechaF': $('#fechaFin').val() },
                'type' : 'post'
            },
            'columns': [
                {
                    className:      'dt-control',
                    orderable:      false,
                    data:           null,
                    defaultContent: ''
                },
                { data: 'rubro',
                    render: function(data, type){
                        return data.toUpperCase();
                    }
                },
                { data: 'total',
                    render: function(data, type) {
                        var number = $.fn.dataTable.render.number( ',', '.', 2, '$').display(data);                     
                        return number;
                    }
                },
            ],
            'footerCallback': function ( row, data, start, end, display ) {
                var api = this.api();
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
                // Total over all pages
                total = api
                    .column( 2 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                // Total over this page
                pageTotal = api
                    .column( 2, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                // Update footer
                $( api.column( 2 ).footer() ).html(
                    formatter.format(total)
                    /* '$'+pageTotal +' ( $'+ total +' total)' */
                );
            }          
        });

        $('#table1 tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data().productos) ).show();
                tr.addClass('shown');
            }
        });

    });
</script>


<!-- </body>
</html> -->