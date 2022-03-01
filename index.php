
<?php
include 'view/cabecera.php';
date_default_timezone_set('America/Mexico_City');
?>
<link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous" />

<div class="card-body">
    <div class="container-fluid">
        <H1>Módulo Ejecutivo</H1>
        <div class="row py-2  px-2" style="background-color: #e3e6ec">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sub">Fecha Inicio :</label>
                    <input type="date" class="form-control" required name="fechaInicio" id="fechaInicio" value="<?= (empty($_SESSION['concentradoFechaInicio'])) ? date("Y-m-d", strtotime(date('Y-m-d') . "- 28 days")) : $_SESSION['concentradoFechaInicio'] ?>">
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group ">
                    <label for="sub">Fecha Fin:</label>
                    <input type="date" class="form-control" required name="fechaFin" id="fechaFin" value="<?= (empty($_SESSION['concentradoFechaFin'])) ? date("Y-m-d") : $_SESSION['concentradoFechaFin'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn btn-outline-success btn-block" id="entradas">ENTRADAS</button>
                <button class="btn btn-outline-primary btn-block" id="salidas" name="salidas">SALIDAS</button>
            </div>
        </div>
        <?php /* include "table-salidas.php" */ ?>
        
        <div class="container mt-5" id="cont_e" style="display:none;">
            <h2 style="margin-bottom: 30px;">Entradas</h2>
            <button type="button" class="btn btn-success" onclick="entradas_excel()">Excel</button>
            <table class="table table-striped table-bordered table-hover" id="table-entradas" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Rubro</th>
                        <th>Costo</th>
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
        
        <div class="container mt-5" id="cont_s" style="display:none;">
            <h2 style="margin-bottom: 30px;">Salidas</h2>
            <button type="button" class="btn btn-success" onclick="salidas_excel()">Excel</button>
            <table class="table table-striped table-bordered table-hover" id="table-salidas" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Rubro</th>
                        <th>Costo</th>
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
    </div>
</div> <!-- card-body -->

<?php include "view/piePagina.php";
define('DIR_J', 'http://localhost:8080/local/dev/adm/in/');
/*  define('DIR_J','https://pruebas.inomac.mx/ejecutivo/'); */
?>

<script src="<?= DIR_S ?>js/app.js"></script>
