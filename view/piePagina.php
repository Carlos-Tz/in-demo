<?php

/* define('DIR_A', 'https://demo.inomac.mx/cap_humano'); */
/* define('DIR_A','http://inomac.test/cap_humano/'); */
/* define('DIR_J','http://inomac.test/'); */

?>







</div>

</div>

</div>

</main>

</div>

</div>



<!-- jQuery library -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



<!-- Bootstrap -->

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>



<!-- Jquery -->

<script src="<?= DIR_A ?>assets/js/plugins/tooltipster/js/jquery.tooltipster.min.js"></script>



<!-- Animations -->

<script src="<?= DIR_A ?>assets/js/plugins/progress-skylo/skylo.min.js"></script>

<script src="<?= DIR_A ?>assets/js/plugins/bootbox/bootbox.min.js"></script>

<script src="<?= DIR_A ?>vendors/skycons/skycons.js"></script>

<!-- Date picker -->

<script src="<?= DIR_A ?>vendors/date-picker/bootstrap-datepicker.min.js"></script>



<!-- Date picker -->

<script src="<?= DIR_A ?>vendors/momentjs/moment.js"></script>

<script src="<?= DIR_A ?>vendors/datetimepicker/bootstrap-datetimepicker.min.js"></script>



<!-- SweetAlert -->

<script src="<?= DIR_A ?>vendors/sweetalert/sweetalert.min.js"></script>



<!-- Bootstrap-Select -->

<script src="<?= DIR_A ?>assets/bootstrap-select/js/bootstrap-select.min.js"></script>







<!-- Functions -->

<script defer src="<?= DIR_A ?>modules/Users/js/login.js"></script>







<script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>



<script src="<?= DIR_A ?>assets/js/scripts.js"></script>





<!-- Datatables -->

<!-- <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script> -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js" crossorigin="anonymous"></script>






<!-- 
<script>

    var ctx = document.getElementById('myChart2').getContext('2d');



    var myChart = new Chart(ctx, {

        type: 'bar',

        data: {
            labels: ["Agroquimico", "Fertilizante", "Eqpo. Electronico", "Ferreteria", "Mat. Riego", "Papeleria", "Inocuidad", "Acido", "Mat. Fumigacion", "Maq. Agricola", "Otros", "Servicios", "Vehículos", "Infraestructura"],

            datasets: [

                {

                    label: 'Rubro' ,

                    data: [

                        <?php

                       /*  $letreros = $agroquimico[$i]["monto"].", " ;

                        $letreros .= $fertilizante[$i]["monto"].", " ;

                        $letreros .= $electronico[$i]["monto"].", " ;

                        $letreros .= $ferreteria[$i]["monto"].", " ;

                        $letreros .= $riego[$i]["monto"].", " ;

                        $letreros .= $papeleria[$i]["monto"].", " ;

                        $letreros .= $inocuidad[$i]["monto"].", " ;

                        $letreros .= $acido[$i]["monto"].", " ;

                        $letreros .= $fumigacion[$i]["monto"].", " ;

                        $letreros .= $agricola[$i]["monto"].", " ;

                        $letreros .= $otros[$i]["monto"].", " ;

                        $letreros .= $servicios[$i]["monto"].", " ;

                        $letreros .= $vehiculos[$i]["monto"].", " ;

                        $letreros .= $infraestructura[$i]["monto"] ;

                        echo $letreros ; */

                        ?>

                    ],

                    backgroundColor: [

                        <?php

                        /* for ($i = 0 ; $i < count($colores) ; $i++){

                            $label = "'".$colores[$i]."'" ;

                            if ($i < count($colores) - 1) {

                                $label .= ", " ;

                            }

                            echo $label ;

                        } */

                        ?>

                    ],

                    maxBarThickness: 30,

                    maxBarLength: 2

                }

            ],

        },

        options: {

            scales: {

                yAxes: [{

                    ticks: {

                        beginAtZero: true

                    }

                }]

            }

        }

    });

</script>



<script>

    var ctx = document.getElementById('myChart4').getContext('2d');

    var myChart = new Chart(ctx, {

        type: 'bar',

        data: {

            labels: ["Agroquimico", "Fertilizante", "Eqpo. Electronico", "Ferreteria", "Mat. Riego", "Papeleria", "Inocuidad", "Acido", "Mat. Fumigacion", "Maq. Agricola", "Otros", "Servicios", "Vehículos", "Infraestructura"],

            datasets: [

                {

                    label: 'Rubro' ,

                    data: [

                        <?php

                        //echo $agroquimico[$pos]["monto"].", ".$fertilizante[$pos]["monto"] ;

                        /* $letreros = $agroquimico[$pos]["monto"].", " ;

                        $letreros .= $fertilizante[$pos]["monto"].", " ;

                        $letreros .= $electronio[$pos]["monto"].", " ;

                        $letreros .= $ferreteria[$pos]["monto"].", " ;

                        $letreros .= $riego[$pos]["monto"].", " ;

                        $letreros .= $papeleria[$pos]["monto"].", " ;

                        $letreros .= $inocuidad[$pos]["monto"].", " ;

                        $letreros .= $acido[$pos]["monto"].", " ;

                        $letreros .= $fumigacion[$pos]["monto"].", " ;

                        $letreros .= $agricola[$pos]["monto"].", " ;

                        $letreros .= $otros[$pos]["monto"].", " ;

                        $letreros .= $servicios[$pos]["monto"].", " ;

                        $letreros .= $vehiculos[$pos]["monto"].", " ;

                        $letreros .= $infraestructura[$pos]["monto"] ;

                        echo $letreros ; */

                        ?>

                    ],

                    backgroundColor: [

                        <?php

                        /* for ($i = 0 ; $i < count($colores) ; $i++){

                            $label = "'".$colores[$i]."'" ;

                            if ($i < count($colores) - 1) {

                                $label .= ", " ;

                            }

                            echo $label ;

                        }
 */
                        ?>

                    ],

                    maxBarThickness: 30,

                    maxBarLength: 2

                }

            ],

        },

        options: {

            scales: {

                yAxes: [{

                    ticks: {

                        beginAtZero: true

                    }

                }]

            }

        }

    });

</script>

<script>

    var ctx = document.getElementById('myChart3').getContext('2d');

    var myChart = new Chart(ctx, {

        type: 'bar',

        data: {

            labels: [

                <?php

               /*  for($i = 0 ; $i < count($tablas) ; $i++) {

                    $label = '"'.$tablas[$i].'"' ;

                    if ($i < count($tablas) - 1) {

                        $label .= ", " ;

                    }

                    echo $label ;

                } */

                ?>

            ],

            datasets: [

                {

                    label: 'Costo Total',

                    data: [

                        <?php

                        /* for ($i = 0 ; $i < count($totales) ; $i++){

                            $label = $totales[$i]["monto"] ;

                            if ($i < count($totales) - 1) {

                                $label .= ", " ;

                            }

                            echo $label ;

                        } */

                        ?>

                    ],

                    backgroundColor: [

                        <?php

                        /* for ($i = 0 ; $i < count($colores) ; $i++){

                            $label = "'".$colores[$i]."'" ;

                            if ($i < count($colores) - 1) {

                                $label .= ", " ;

                            }

                            echo $label ;

                        } */

                        ?>

                    ],

                    maxBarThickness: 30,

                    maxBarLength: 2

                }

            ],

        },

        options: {

            scales: {

                yAxes: [{

                    ticks: {

                        beginAtZero: true

                    }

                }]

            }

        }

    });

</script>







<script>

    var ctx = document.getElementById('myChart').getContext('2d');

    var myChart = new Chart(ctx, {

        type: 'bar',

        data: {

            labels: [

                <?php

                /* for($i = 0 ; $i < count($sub_rancho) ; $i++) {

                    $label = '"'.$sub_rancho[$i].'"' ;

                    if ($i < count($sub_rancho) - 1) {

                        $label .= ", " ;

                    }

                    echo $label ;

                } */

                ?>

            ],

            datasets: [

                {

                    label: 'Costo Total',

                    data: [

                        <?php

                       /*  for ($i = 0 ; $i < count($totales) ; $i++){

                            $label = $totales[$i]["total"] ;

                            if ($i < count($totales) - 1) {

                                $label .= ", " ;

                            }

                            echo $label ;

                        } */

                        ?>

                    ],

                    backgroundColor: [

                        <?php

                        /* for ($i = 0 ; $i < count($colores) ; $i++){

                            $label = "'".$colores[$i]."'" ;

                            if ($i < count($colores) - 1) {

                                $label .= ", " ;

                            }

                            echo $label ;

                        } */

                        ?>

                    ],

                    maxBarThickness: 30,

                    maxBarLength: 2

                }

            ],

        },

        options: {

            scales: {

                yAxes: [{

                    ticks: {

                        beginAtZero: true

                    }

                }]

            }

        }

    });

</script>
 -->


<!-- Select 2 -->

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>

    $(".buscador").select2();

</script>

<script type="text/javascript">

    $(document).ready(function () {

        $('#sidebarCollapse').on('click', function () {

            $('#sidebar').toggleClass('active');

        });

    });

</script>

<script>

    /* $(document).ready( function () {

        $('#ejemplo').DataTable({

            dom: 'BT<"clear">lfrtip',

            buttons: [

                'copy', 'csv', 'excel', 'pdf', 'print'

            ],

            responsive: true,

            pagingType: 'full_numbers',

            "oLanguage": {

                "sProcessing": "Procesando...",

                "sLengthMenu": "Mostrar _MENU_ registros",

                "sZeroRecords": "No se encontraron resultados",

                "sEmptyTable": "Ningún dato disponible en esta tabla",

                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",

                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",

                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",

                "sInfoPostFix": "",

                "sSearch": "Buscar:",

                "sUrl": "",

                "sInfoThousands": ",",

                "oPaginate": {

                    "sFirst": "Primero",

                    "sLast": "Último",

                    "sNext": "Siguiente",

                    "sPrevious": "Anterior"

                }

            }

        });

    } ); */

</script>

<script language="javascript">



   /*  $(document).ready(function() {

        var id_subrancho ;

        var aplica ;

        var producto ;



        $("#cbx_producto").select2({ width: "100%" });



        $("#cbx_producto").change(function () {

            $("#cbx_producto option:selected").each(function () {

                id_producto = $(this).val() ;

                $.post("get_producto_detalle.php", {id_producto : id_producto}, function(data) {

                    $("#mensajes").html(data)

                });

            }) ;

        }) ;



        $("#cbx_rancho").change(function () {

            $("#cbx_rancho option:selected").each(function () {

                id_subrancho = $(this).val() ;

                $.post("get_sectores.php", {id_subrancho : id_subrancho}, function(data) {

                    if(data.length > 0) {

                        document.getElementById('cbx_aplica').style.display = "block";

                        document.getElementById('lbl_aplica').style.display = "block";

                    };

                    $("#tabla").html(data)

                });

            }) ;

        }) ;



        $("#cbx_aplica").change(function () {

            $("#cbx_aplica option:selected").each(function () {

                aplica = $(this).val() ;

                $.post("get_productos.php", {aplica : aplica, id_subrancho : id_subrancho}, function(data) {

                    document.getElementById('productos').style.display = "inline";

                    $("#productos select").html(data) ;

                });

            });

        }) ;



        $("#h_fin").on ('blur', function() {

            var hora_final = $(this).val();

            var hora_inicio = $("#h_inicio").val();

            var aux1 = parseInt(hora_inicio.split(":")[0]) ;

            var aux1_1 = parseInt(hora_inicio.split(":")[1]) ;

            var aux2 = parseInt(hora_final.split(":")[0]) ;

            var aux2_1 = parseInt(hora_final.split(":")[1]) ;

            var hora_diff = aux2 - aux1 ;

            var minuto_diff = aux2_1 - aux1_1;



            if (hora_diff < 0) {

                $('#Modal').modal('show'); // abrir

                document.getElementById("#h_fin").focus();

                //$("h_fin").focus() ;

            }

        } );



    } ) ; */


/* 
    function muestra(elemento) {

        switch(elemento) {

            case 1 :

                document.getElementById('lbl_justificacion').style.display = "block";

                document.getElementById('justificacion').style.display = "block";

                break ;

            case 2:

                document.getElementById('lbl_fecha').style.display = "block";

                document.getElementById('fecha').style.display = "block";

                break ;

            case 3:

                document.getElementById('lbl_autoriza').style.display = "block";

                document.getElementById('autoriza').style.display = "block";

                break ;

            case 4:

                document.getElementById('lookup').style.display = "block";

                break;

            case 5:

                document.getElementById('guardar').style.display = "block";

        }

    } */



    /* var total = 0 ;



    function calcula(item, valor){

        var existencia = parseFloat(document.getElementById("existencia").value) ;

        var elemento = "total[" + item + "]" ;

        var tamano = document.getElementById("medida[" + item + "]").value ;

        document.getElementById(elemento).value = valor * tamano ;

        total = total + parseFloat(document.getElementById(elemento).value) ;



        // alert("Has tomado: " + total + " de: " + existencia) ;



        if (total > existencia) {

            alert("Cantidad solicitada excede existencia en almacén") ;

            document.getElementById("dosis[" + item + "]").value = 0 ;

            total = total - document.getElementById(elemento).value ;

            document.getElementById(elemento).value = 0 ;

        } else {

            existencia = existencia - total ;

            document.getElementById("saldo[" + item + "]").value = existencia ;

        } ;

    } */



</script>

</body>



</html>

