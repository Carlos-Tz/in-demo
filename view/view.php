<?php 
include 'cabecera.php'; 
date_default_timezone_set('America/Mexico_City');
?>

<div class="card-header-actions">
    <!-- <h2 class="card-header bg-cyan-soft text-black">
        Módulo Ejecutivo
    </h2> -->
</div>
<div class="card-body">
    <div class="container-fluid">
        <H1>AQUI VA TU CODIGO</H1>
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
        <?php
        /* foreach ($rubros as $k => $va) :
            // echo  $k . '===>' . $va . '<br>'; 
            $rub[$k] = array_filter($data[0], function ($key) use ($va) {
                return strtolower($key['clasificacion']) == $va;
            });
            $tot[$k] = 0;
            foreach ($rub[$k] as $j => $v) :
                $tot[$k] += $v['precio_compra'];
            //print_r($v['precio_compra']); echo '<br>';
            endforeach;
        endforeach;
        print_r($rub['inocuidad']);
        echo '<br><br>';
        print_r($tot['inocuidad']); */







        /* foreach ($rubros as $k => $va ): 
                echo  $k .'===>'.$va . '<br>';
	        endforeach; */

        /* print_r($rubros); */

        /* print_r($data[0]); */
        /* foreach ($data[0] as $key => $value)
    			foreach ($value as $va ): 
                    print_r($value);
			    endforeach; */

        /* var_dump(array_filter($data[0], function ($key) {
                return strtolower($key['clasificacion']) == 'vehiculos';
            })); */

        /* $name = "DISPOSICIONES DE EFECTIVO";
            var_dump(array_filter($data[0], function($v) use ($name) {
                return ($v['nom_prod'] == $name);
            })); */

        /* var_dump($rubros); */
        ?>

        <div class="dataTable_wrapper table-responsive custom-scrollbar">
            <div id="message"></div>
            <table class="table table-striped table-bordered table-hover" id="dataTable-entradas" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cantidad</th>
                        <th>nombre</th>
                        <th>clasi</th>
                      <!--  <th>Sector</th>
                        <th>Túnel</th>
                        <th>Opciones</th> -->
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div> <!-- card-body -->

<?php include "piePagina.php"; 
    /* define('DIR_J','http://inomac.test/'); */
    define('DIR_J','http://localhost:8080/local/dev/adm/in/');
   /*  define('DIR_J','https://pruebas.inomac.mx/ejecutivo'); */
?>
<!--- ZONA PARA INCLUIR TUS JS -->

<script src="<?= DIR_J ?>js/app.js"></script>