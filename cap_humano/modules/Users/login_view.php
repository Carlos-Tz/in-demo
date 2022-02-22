<?php
header('Content-type: text/javascript');
header('Access-Control-Allow-Origin: *');
$redirect = PATH_BACKEND . 'home.php';
?>
$("#message").html('<div class="alert alert-<?= (true !== $res) ? 'warning' : 'success' ?>"><a href="#" class="close" data-dismiss="alert">&times;</a><strong><?= $msg ?> </strong></div>');<?php
$pageReturn = (empty($_SESSION['return-page'])) ? $redirect : $_SESSION['return-page'];
if (empty($pageReturn) && false == $error) {
    ?>window.location.href="<?= $redirect ?>";<?php
} elseif (true === $res && !empty($pageReturn)) {
    ?>window.location.href="<?= $pageReturn ?>";<?php
}
if (4 <= $_SESSION['system_intentos']) {
    ?>$("#message").html('<div class="alert alert-dismissable alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a><strong> ¡Atención! </strong> '¡Intenta recuperar tu contraseña por favor!' </div>');<?php
}
?>
