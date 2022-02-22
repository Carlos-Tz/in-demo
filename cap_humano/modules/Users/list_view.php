<?php
ob_start('ob_gzhandler');
?><!DOCTYPE html>
<html lang="es">
<head>
    <?php include DIR_PATH . '/snippets/head.php'; ?>
    <?php include DIR_PATH . '/snippets/header-datatables.php'; ?>
</head>
<body class="nav-fixed">
<?php include DIR_PATH . '/snippets/top-nav.php'; ?>
<div id="layoutSidenav">
<!--    <?php include DIR_PATH . '/snippets/menu.php'; ?> -->
<?php include("../../../utils/head.php") ; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class=" mt-5">
                <div class="container-fluid">
                    <div class="page-header-content">
                        <div class="card-header bg-cyan-soft text-black"><i data-feather="user-plus"></i>
                            Listado Usuarios
                            <div class="float-right">
                                <a href="index.php?event=100" class="btn btn-outline-black  btn-sm"
                                   data-toggle="tooltip" data-placement="left" data-original-title="Agregar Nuevo">
                                    <i class="fa fa-plus-circle"></i> Agregar Nuevo</a>

                                </div>
                            </div>
                        </div>
                    </div>


            <div class="  mt-3">
                <div class="container-fluid">
                    <div class="card mb-4">
                        <div class="card-header-actions">


                            <div class="card-body">

                                <div class="datatable table-responsive">
                                    <table id="dataTables-usuarios"
                                           class="table table-striped table-bordered dataTable responsive"
                                           role="grid"
                                           style="width: 100%;">


                                        <thead>
                                        <tr>
                                            <!--th>ID</th-->
                                            <th>E-Mail</th>
                                            <th>Nombre(s)</th>
                                            <th>Apellidos</th>
                                            <th>Perfil</th>
                                            <th>Estatus</th>
                                            <th class="td-actions text-right">Opciones</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- Modals -->
                <div id="userDetail" class="modal fade" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Detalle de Usuario</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="row d-flex justify-content-center">
                                    <img id="usr_foto" src="" class="img-fluid img-thumbnail" width="150" height="150">
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        Nombre:<strong><p id="usr_nombre"></p></strong>
                                    </div>
                                    <div class="col-6">
                                        Apellidos:<strong><p id="apellidos"></p></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Fecha de nacimiento:<strong><p id="usr_fecha_nacimiento"></p></strong>
                                    </div>
                                    <div class="col-6">
                                        Teléfono:<strong><p id="usr_telefono"></p></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Correo:<strong><p id="usr_mail"></p></strong>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i
                                            class="glyphicon glyphicon-ok"></i>&nbsp;Aceptar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include DIR_PATH . '/snippets/footer-scripts.php'; ?>
                <script src="js/detail_user.js" type="text/javascript"></script>
                <?php include DIR_PATH . '/snippets/footer-scripts-datatables.php'; ?>
                <script>
                    $(document).ready(function () {
                        $('#dataTables-usuarios').DataTable({
                            responsive: true,
                            dom: 'T<"clear">lfrtip',
                            order: [[0, "asc"]],
                            aoColumns: [
                                //{sClass: "text-center"},
                                {sClass: "text-left"},
                                {sClass: "text-left"},
                                {sClass: "text-left"},
                                {sClass: "text-left"},
                                {sClass: "text-center"},
                                {sClass: "td-actions text-right"}
                            ],
                            scrollX: true,
                            "processing": true,
                            "serverSide": false,
                            "ajax": "index.php/?event=11",
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

                        $("#dataTables-usuarios").on("click", ".user-edit", function () {
                            id_usuario = $(this).attr('data-id');
                        });
                    });
                </script>

            </div>
            </div>

        </main>
        <?php include DIR_PATH . '/snippets/footer.php'; ?>
    </div>
</div>

</body>
</html><?php ob_end_flush(); ?>