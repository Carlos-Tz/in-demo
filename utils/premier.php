<?php
$ruta = "https://pruebas.inomac.mx/";
?>

<!-- EJECUTIVO  -->
<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
   data-target="#Submenu-0" aria-expanded="false" aria-controls="collapseComponents">
    <div class="nav-link-icon"><i data-feather="package"></i></div>
    EJECUTIVO
    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
    >
</a>
<div class="collapse" id="Submenu-0" data-parent="#accordionSidenav">
    <nav class="sidenav-menu-nested nav">
        <a class="nav-link" href="<?php echo $ruta . 'ejecutivo' ?>">Ejecutivo</a>
    </nav>
</div>


<!-- SUMINISTRO  -->

<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
   data-target="#Submenu-0" aria-expanded="false" aria-controls="collapseComponents">
    <div class="nav-link-icon"><i data-feather="package"></i></div>
    SUMINISTRO
    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
    >
</a>
<div class="collapse" id="Submenu-0" data-parent="#accordionSidenav">
    <nav class="sidenav-menu-nested nav">

        <?php $sub = "compras/"; ?>
        
        <a class="nav-link" href="<?php echo $ruta . $sub . 'requisicion' ?>">Requisicion</a>

        <a class="nav-link" href="<?php echo $ruta . $sub . 'autorizar/gestion_vobo.php' ?>">Autorizar</a>

        <a class="nav-link" href="<?php echo $ruta . $sub . 'requisicion/gestion_vobo.php' ?>">Comprar</a>

        <a class="nav-link" href="<?php echo $ruta . $sub . 'pagos/gestion_pagos.php' ?>">Programar Pagos</a>

<!--        <a class="nav-link" href="<?php echo $ruta . $sub . 'pagos_admon/gestion_pagos.php' ?>">Realizar Pagos</a> -->
        
        <a class="nav-link" href="<?php echo $ruta . $sub . 'pagos_admon2' ?>">Realizar Pagos</a>

        <a class="nav-link" href="<?php echo $ruta . $sub . 'proveedor/gestion_proveedor.php' ?>">Proveedores</a>

        <a class="nav-link" href="<?php echo $ruta . $sub . 'producto/gestion_producto.php' ?>">Productos</a>
    </nav>
</div>
<!-- ALMACEN  -->
<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
   data-target="#Submenu-1" aria-expanded="false" aria-controls="collapseComponents">
    <div class="nav-link-icon"><i data-feather="package"></i></div>
    ALMACEN
    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
    >
</a>
<div class="collapse" id="Submenu-1" data-parent="#accordionSidenav">
    <nav class="sidenav-menu-nested nav">
        <?php $sub = "almacen/"; ?>

        <a class="nav-link" href="<?php echo $ruta . $sub . 'recepcion/gestion_recepcion.php' ?>">Recepción</a>

        <a class="nav-link" href="<?php echo $ruta . $sub . 'salida/gestion_salida.php' ?>">Entrega</a>

        <a class="nav-link" href="<?php echo $ruta . $sub . 'reportes/gestion_reporte.php' ?>">Reportes</a>

        <!--
            <a class="nav-link"href="<?php echo $ruta . $sub . 'reportes/reporte.php' ?>">Reporte Rancho</a>
          -->
    </nav>
</div>
<!-- APLICACIONES  -->
<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
   data-target="#Submenu-2" aria-expanded="false" aria-controls="collapseComponents">
    <div class="nav-link-icon"><i data-feather="package"></i></div>
    APLICACIONES
    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
    >
</a>
<div class="collapse" id="Submenu-2" data-parent="#accordionSidenav">
    <nav class="sidenav-menu-nested nav">
        <?php $sub = "aplicacion/"; ?>
        <a class="nav-link" href="<?php echo $ruta . $sub . 'programar/gestion_aplicacion.php' ?>">Programar</a>
        <a class="nav-link" href="<?php echo $ruta . $sub . 'ejecutar/gestion_ejecutar.php' ?>">Ejecutar</a>
        <a class="nav-link" href="<?php echo $ruta . $sub . 'reportes/gestion_descarga.php' ?>">Reporte</a>
    </nav>
</div>

<!-- MONITOREO  -->

<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
   data-target="#Submenu-3" aria-expanded="false" aria-controls="collapseComponents">
    <div class="nav-link-icon"><i data-feather="package"></i></div>
    MONITOREO
    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
    >
</a>
<div class="collapse" id="Submenu-3" data-parent="#accordionSidenav">
    <nav class="sidenav-menu-nested nav">
        <?php $sub = "cap_humano/modules/Monitoring/?event="; ?>
        <a class="nav-link" href="<?php echo $ruta . $sub . '1001' ?>">Nuevo</a>
        <a class="nav-link" href="<?php echo $ruta . $sub . '001' ?>">Reporte</a>
    </nav>
</div>
<!-- EMPLEADOS  -->

<?php $sub = "cap_humano/modules/Employees/?event="; ?>
<a class="nav-link" href="<?php echo $ruta . $sub . '0010' ?>"><div class="nav-link-icon"><i data-feather="package"></i></div> EMPLEADOS</a>

<!-- CHECK LIST  -->

<?php $sub = "cap_humano/modules/CheckList/?event="; ?>
<a class="nav-link" href="<?php echo $ruta . $sub . '001' ?>"> <div class="nav-link-icon"><i data-feather="package"></i></div> CHECK LIST</a>

<!-- INOCUIDAD  -->

<?php $sub = "cap_humano/modules/Innocuousness/General/?event="; ?>
<a class="nav-link" href="<?php echo $ruta . $sub . '001' ?>"> <div class="nav-link-icon"><i data-feather="package"></i></div>INOCUIDAD</a>

<!-- CAPITAL HUMANO  -->
<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
   data-target="#Submenu-4" aria-expanded="false" aria-controls="collapseComponents">
    <div class="nav-link-icon"><i data-feather="package"></i></div>
    CAPITAL HUMANO
    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
    >
</a>
<div class="collapse" id="Submenu-4" data-parent="#accordionSidenav">
    <nav class="sidenav-menu-nested nav">
    <?php $sub = "cap_humano/modules/HumanResources/"; ?>
    <a class="nav-link" href="<?php echo $ruta . 'cap_humano/modules/HumanResources/Payroll/?event=100' ?>">Cálculo de
        Nómina</a>
    <a class="nav-link" href="<?php echo $ruta . $sub . 'Employee_Log/?event=001' ?>">Gestión de Incidencias</a>
    <a class="nav-link" href="<?php echo $ruta . $sub . 'Payment_Settings/?event=001' ?>">Configuración de Pagos</a>
    <a class="nav-link" href="<?php echo $ruta . $sub . 'Task_Assignment/?event=001' ?>">Asignación/Corte</a>
    <a class="nav-link" href="<?php echo $ruta . $sub . 'harvest_log/?event=1000' ?>">Bitácora de Cosecha</a>
    </nav>
</div>
    <!-- CATALOGOS -->

<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
   data-target="#Submenu-5" aria-expanded="false" aria-controls="collapseComponents">
    <div class="nav-link-icon"><i data-feather="package"></i></div>
    CATALOGOS
    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
    >
</a>
<div class="collapse" id="Submenu-5" data-parent="#accordionSidenav">
    <nav class="sidenav-menu-nested nav">
        <?php $sub = "cap_humano/modules/Catalogs/"; ?>
        <a class="nav-link" href="<?php echo $ruta . $sub . 'General/?event=001' ?>">General</a>
        <a class="nav-link" href="<?php echo $ruta . $sub . 'Activities/?event=010' ?>">Actividades</a>
    </nav>
</div>

        <!-- ADMINISTRACION -->
        <!--
    <a href="#Submenu-6" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">ADMINISTRACION</a>
    <ul class="collapse list-unstyled" id="Submenu-6">
        <?php $sub = "cap_humano/modules/Administration/"; ?>
           
            <a href="<?php echo $ruta . $sub . 'Bank_Accounts/?event=001' ?>">Bancos</a>
        
    
  -->
        <!-- GRAFICOS -->

<a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
   data-target="#Submenu-6" aria-expanded="false" aria-controls="collapseComponents">
    <div class="nav-link-icon"><i data-feather="package"></i></div>
    GRAFICAS
    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
    >
</a>
<div class="collapse" id="Submenu-6" data-parent="#accordionSidenav">
    <nav class="sidenav-menu-nested nav">
            <?php $sub = "graph/"; ?>
            <a class="nav-link" href="<?php echo $ruta . $sub . 'graph_rubro.php' ?>">Por Rubro</a>
            <a class="nav-link" href="<?php echo $ruta . $sub . 'graph_persona.php' ?>">Por Persona</a>
            <a class="nav-link" href="<?php echo $ruta . $sub . 'dashboard/index.php' ?>">Centro de Costos</a>
            <a class="nav-link"
               href="<?php echo $ruta . 'cap_humano/modules/HumanResources/Employee_performance/?event=001' ?>">Rendimiento
                de Personal</a>
            <a class="nav-link" href="<?php echo $ruta . 'cap_humano/modules/Reports/?event=001' ?>">Monitoreo</a>
        <a class="nav-link" href="<?= $ruta ?>cap_humano/modules/HumanResources/Graficas/?event=01">Graficas Bitacora Cosecha</a>
    </nav>
</div>
    
