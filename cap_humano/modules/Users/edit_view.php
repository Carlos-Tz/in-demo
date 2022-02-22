<?php
ob_start('ob_gzhandler');
?><!DOCTYPE html>
<html lang="es">
<head>
    <?php include DIR_PATH . '/snippets/head_login.php'; ?>
</head>
<body class="nav-fixed">
<?php include DIR_PATH . '/snippets/top-nav.php'; ?>
<div id="layoutSidenav">
<!--    <?php include DIR_PATH . '/snippets/menu.php'; ?> -->
<?php include("../../../utils/head.php") ; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="mt-5">
                <div class="container-fluid">
                    <div class="page-header-content">
                        <div class="card-header bg-cyan-soft text-black">
                            Agregar Usuario
                            <div class="float-right">
                                <a href="index.php?event=1" class="btn btn-outline-black  btn-sm"
                                   data-original-title="Agregar Nuevo Usuario"><i data-feather="user-plus"></i>&nbsp;Ver
                                    Lista</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="container-fluid">
                        <div class="card mb-4">
                            <div class="card-header-actions">
                                <div class="card-body">
                                    <form action="" method="post" id="formUser" name="formUser" autocomplete="off">
                                        <div class="card-body">
                                            <div class="sbp-preview">
                                                <div class="sbp-preview-content">
                                                    <div id="message" class="col-xs"><?= $msg; ?></div>
                                                    <input type="hidden" id="id_usuario" name="id_usuario"
                                                           value="<?= $id_usuario ?: 0 ?>">
                                                    <input type="hidden" id="perfil" name="perfil"
                                                           value="<?= $id_perfil; ?>">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs">
                                                            <div class="form-group">
                                                                <label for=" Nombre"> Nombre (s):&nbsp;*</label><input
                                                                        type="text"
                                                                        class="form-control"
                                                                        value="<?= $nombre; ?>"
                                                                        name="nombre"
                                                                        required
                                                                        tabindex="8">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs">
                                                            <div class="form-group">
                                                                <label>Apellidos Paterno:&nbsp;*</label><input
                                                                        type="text"
                                                                        class="form-control"
                                                                        value="<?= $ap_paterno; ?>"
                                                                        name="ap_paterno"
                                                                        tabindex="9"
                                                                        required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs">
                                                            <div class="form-group">
                                                                <label>Apellido Materno:</label><input type="text"
                                                                                                       class="form-control"
                                                                                                       value="<?= $ap_materno; ?>"
                                                                                                       name="ap_materno"
                                                                                                       tabindex="10">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs">
                                                            <div class="form-group">
                                                                <label>Fecha de nacimiento:&nbsp;</label>
                                                                <input type="date" class="form-control"
                                                                       value="<?= $fecha_nacimiento ?>"
                                                                       name="fecha_nacimiento" id="fecha_nacimiento">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs">
                                                            <div class="form-group">
                                                                <label>Sexo:</label>
                                                                <select class="form-control" id="genero" name="genero">
                                                                    <option value="" disabled>Seleccione una Opción
                                                                    </option>
                                                                    <option value="1" <?php if ($genero == 1) {
                                                                        echo "selected";
                                                                    } ?>>Masculino
                                                                    </option>
                                                                    <option value="2" <?php if ($genero == 2) {
                                                                        echo "selected";
                                                                    } ?>>Femenino
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs">
                                                            <div class="form-group">
                                                                <label>Teléfono:</label>
                                                                <input type="tel" value="<?= $telefono ?>"
                                                                       class="form-control"
                                                                       name="telefono" id="telefono" tabindex="10">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs">
                                                            <div class="form-group">
                                                                <label>Correo Electrónico:&nbsp;*</label>
                                                                <input type="email" value="<?= $mail ?: "" ?>"
                                                                       class="form-control"
                                                                       name="mail" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs">
                                                            <div class="form-gruop">
                                                                <label>Perfil:&nbsp;*</label>
                                                                <select class="form-control" id="id_perfil"
                                                                        name="id_perfil">
                                                                    <option value="">Seleccione una Opción</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs">
                                                            <div class="form-group">
                                                                <label>Estatus*</label>
                                                                <select name="estatus" class="form-control"
                                                                        id="estatus">
                                                                    <option value="1" <?= (1 == $estatus || empty($estatus)) ? 'selected' : ''; ?>>
                                                                        Activo
                                                                    </option>
                                                                    <option value="2" <?= (2 == $estatus) ? 'selected' : ''; ?>>
                                                                        Inactivo
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="pw_row">
                                                        <?php if ($id_usuario != 0) { ?>
                                                            <div class="form-check">
                                                                &nbsp;&nbsp;&nbsp;<input type="checkbox"
                                                                                         class="form-check-input"
                                                                                         id="edita_pw">
                                                                <label class="form-check-label"><b><u>Editar
                                                                            Contraseña</u></b></label>
                                                            </div> <?php } ?>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs">
                                                            <div class="form-group">
                                                                <label>Contraseña:&nbsp;</label>
                                                                <input type="password" value="" name="pass"
                                                                       id="newPassword"
                                                                       class="form-control">
                                                                <div id="regla_pw">
                                                                    <span class="label label-primary">La contraseña debe ser mínimo de 8 dígitos  entre Mayúsculas,<br> minúsculas, números y caracteres especiales</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs">
                                                            <div class="form-group">
                                                                <label>Confirma contraseña:&nbsp;</label>
                                                                <input type="password" value="" name="rePassword"
                                                                       id="rePassword"
                                                                       class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row float-right">
                                                    <div class="col-xs">
                                                        <a type="button" href="index.php?event=1"
                                                           class="btn btn-secondary">Cancelar</a>
                                                        <button type="submit" id="btn-save" name="saveButton"
                                                                class="btn btn-primary">Guardar
                                                        </button>
                                                    </div>
                                                    <br>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </main>
        <?php include DIR_PATH . '/snippets/footer.php'; ?>

    </div>

</div>
<?php include DIR_PATH . '/snippets/footer-scripts.php'; ?>
<script src="js/detail_user.js" type="text/javascript"></script>
<script src="js/edit_user.js"></script>
</body>
</html><?php ob_end_flush(); ?>