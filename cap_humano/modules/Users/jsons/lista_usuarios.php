<?php
header('Content-Type: application/json; charset=utf-8');
$db->debug = 0;
//print_r($_SESSION);
$sess_id_entidad = $_SESSION['system_id_entidad'];
$db->Execute('DROP view IF EXISTS usersview')or trigger_error($db->ErrorMsg(), E_USER_ERROR);
$queryView = "CREATE view usersview as
	SELECT
	u.id_usuario, u.usuario, u.mail, u.nombre, CONCAT(u.ap_paterno,' ',ap_materno) apellidos, c.titulo,
	IF(1=u.estatus,\"<span class='label label-success'>Activo</span>\",\"<span class='label label-danger'>Inactivo</span>\") id_status,
        CONCAT('<div class=\"d-flex justify-content-center\">
        <button class=\"btn btn-info btn-sm btn-icon\" onclick=\"loadDetail(',u.id_usuario,')\"><i class=\"fa fa-search\"></i></button>&nbsp;
        <a class=\"btn btn-success btn-sm btn-icon\" href=\"index.php?event=100&id_usuario=',u.id_usuario,'\"><i class=\"fa fa-edit\"></i></a>
        </div>') opciones
	FROM sys_users u
        LEFT JOIN sys_users_have_profiles e ON e.id_usuario=u.id_usuario AND e.id_entidad='$sess_id_entidad'
        LEFT JOIN sys_user_profiles c on e.id_perfil=c.id_cf
        WHERE 1";
        
$db->Execute($queryView)or trigger_error($db->ErrorMsg(), E_USER_ERROR);
$table = 'usersview';
$primaryKey = 'id_usuario';
$columns = array(
   // array('db' => 'id_usuario', 'dt' => 0),
    array('db' => 'mail', 'dt' => 0),
    array('db' => 'nombre', 'dt' => 1),
    array('db' => 'apellidos', 'dt' => 2),
    array('db' => 'titulo', 'dt' => 3),
    array('db' => 'id_status', 'dt' => 4),
    array('db' => 'opciones', 'dt' => 5)
);
include DIR_PATH . '/core/config.php';
$sql_details = array(
    'user' => serverUname,
    'pass' => serverPass,
    'db' => serverDB,
    'host' => serverHost
);
include DIR_PATH . '/classes/Web/ssp.class.php';
echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);

