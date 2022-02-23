<?php

    /* define('DIR_A','http://localhost:8080/local/dev/adm/demo/cap_humano/'); */
    define('DIR_A','http://inomac.test/cap_humano/');

/* define('DIR_S','http://localhost:8080/local/dev/adm/demo/'); */
define('DIR_S','http://inomac.test/');



/* include_once("sesion.php") ; */

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <meta NAME="robots" CONTENT="noindex, nofollow">

    <meta name="description" content="" />

    <meta name="author" content="" />

    <title>INOMAC</title>

    <!-- <link rel="icon" type="image/x-icon" href="<?= DIR_A ?>assets/img/inomac.png" /> -->

    <link href="<?= DIR_A ?>assets/css/styles.css" rel="stylesheet" />

    <link href="<?= DIR_A ?>assets/js/plugins/progress-skylo/skylo.min.css" rel="stylesheet" type="text/css"/>

    <link href="<?= DIR_A ?>assets/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />

    <link href="<?= DIR_A ?>assets/select2/dist/css/select2.css" rel="stylesheet" />

    <link href="<?= DIR_A ?>assets/select2/select2-bootstrap.css" rel="stylesheet" />

    <script> url_path = '<?= DIR_A ?>';</script>

    <style>

        th { font-size: 14px; }

        td { font-size: 13px; }

    </style>

    <!-- Datatables -->

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

    <link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    
  <!--   <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous" /> -->



    <!--PARA HACER LOS GRAFICOS-->

    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
 -->

</head>

<body class="nav-fixed">

<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-success" id="sidenavAccordion">

    <!-- Sidenav Toggle Button-->

    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></button>

    <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="#">INOMAC</a>

</nav>

<div id="layoutSidenav">

    <div id="layoutSidenav_nav">

        <nav class="sidenav shadow-right sidenav-light">

            <div class="sidenav-menu">

                <div class="nav accordion" id="accordionSidenav">

                    <div class="sidenav-menu-heading">Módulos</div>

                   <?php 

                    /* switch($_SESSION["nickname"]) {

                        case "premier":

                            include("premier.php") ;

                            break; 

                        default:

                            echo "<h2>NO ES USUARIO DEL SISTEMA</h2>" ;

                    } */

                ?>

                </div>

            </div>

            <div class="sidenav-footer">

                <div class="sidenav-footer-content">

                    <div class="sidenav-footer-title"><a href="<?= DIR_S ?>ingresar/logout.php" type="button" class="btn btn-outline-primary  btn-block">SALIR  &nbsp;<i class="fas fa-sign-out-alt"></i></a></div>

                </div>

            </div>



        </nav>

    </div>

    <div id="layoutSidenav_content">

        <main>

            <div class="mt-5">

                <div class="container-fluid">

                    <div class="card">

