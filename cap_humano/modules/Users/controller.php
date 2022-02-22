<?php
$event = filter_input(INPUT_GET, 'event', FILTER_SANITIZE_STRING);
$id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_SANITIZE_STRING);
if(true == is_numeric($event)){
    $evento= bindec($event);
}else{
    $evento= $event;
}
handler($evento);

function handler($evento) {
    $ar_data = helper_data();
    $oUser = get_obj();
    global $db;
    global $id_usuario;
    
    switch ($evento) {
        case 1:
            /* Carga el view del listado */
            include 'list_view.php';
            break;
        case 2:
            include 'jsons/detalle_usuario.php';
            break;
        case 3:
            /* Carga el json para el listado */
            include 'jsons/lista_usuarios.php';
            break;
        case 4:
            /* Carga el view del formulario de edición */
            $db->debug = 0;
            $id_perfil = $_SESSION['system_id_perfil'];
            $id_usuario_session = $_SESSION['system_id_usuario']; //id de usuario en sesion
            if (!empty($id_usuario)) {
                if(!empty($id_usuario)){$res = $oUser->Load('id_usuario='.$id_usuario);}
                if (true == $res) {
                    $arAttibutes = $oUser->getAttributeNames();
                    foreach ($arAttibutes as $attribute) {
                        $$attribute = $oUser->$attribute;
                    }
                    $oDatosUsuario = $oUser->sys_user_data;
                    if (false != $oDatosUsuario) {
                        foreach ($oDatosUsuario as $datos) {
                            $arAttibutes = $datos->getAttributeNames();
                            foreach ($arAttibutes as $attribute) {
                                $$attribute = $datos->$attribute;
                            }
                        }
                    }
                    $oHasPerfiles = $oUser->sys_users_have_profiles;
                    if (false != $oHasPerfiles) {
                        foreach ($oHasPerfiles as $datos) {
                            $arAttibutes = $datos->getAttributeNames();
                            foreach ($arAttibutes as $attribute) {
                                $$attribute = $datos->$attribute;
                            }
                        }
                    }
                } else {
                    $rs = filter_var($oUser->ErrorMsg(), FILTER_SANITIZE_SPECIAL_CHARS);
                    echo $rs;
                }
            }
            include 'edit_view.php';
            break;
        case 5:
            $arRes = valida_datos($ar_data);
            if (false == $arRes[0]) {
                $id_entidad = $ar_data['id_entidad']?:$_SESSION['system_id_entidad'];
                if (empty($id_entidad)) {
                    $arRes[0] = true;
                    $arRes[1] = 'Algo salió mal';
                    $arRes[2] = 'La entidad es incorrecta, por favor verifique e intente de nuevo.';
                } else {
                    $arAttibutes = $oUser->GetAttributeNames();
                    foreach ($arAttibutes as $attribute) {
                        $oUser->$attribute = filter_var($ar_data[$attribute], FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                    if (!empty($ar_data['pass'])){
                        $oUser->pass = sha1($ar_data['pass']);
                    }elseif(empty($ar_data['id_usuario']) && empty($ar_data['pass'])){
                        $random_pw = generate_password();
                        $oUser->pass = sha1($random_pw);
                    }else{
                        $oUser->pass = NULL;
                    }
                    if (empty($ar_data['id_social'])) {
                        $oUser->id_social = uniqid();
                    }
                    $db->startTrans();
                    if (!empty($ar_data['id_usuario'])) {
                        $oUser->nombre = convert_title(trim($ar_data['nombre']));
                        $oUser->ap_paterno = convert_title(trim($ar_data['ap_paterno']));
                        $oUser->usuario = $ar_data['mail'];
                        $res = $oUser->Update();
                        $id_usuario = $oUser->id_usuario;
                        $data_return['id_usuario'] = $id_usuario;
                        $data_return[0] = false;
                        $data_return[1] = '¡Excelente!';
                        $data_return[2] .= 'La información se actualizó correctamente.';
                    } else {
                        $oUser->id_usuario = 0;
                        $oUser->nombre = convert_title(trim($ar_data['nombre']));
                        $oUser->ap_paterno = convert_title(trim($ar_data['ap_paterno']));
                        $oUser->usuario = $ar_data['mail'];
                        $res = $oUser->Save();
                        $id_usuario = $db->Insert_ID();
                        $data_return['id_usuario'] = $id_usuario;
                        $data_return[0] = false;
                        $data_return[1] = '¡Excelente!';
                        $data_return[2] .= 'El nuevo usuario se registró con éxito.';
                    }
                    if (true == $res) {
                        if(empty($ar_data['id_usuario'])){
                            $oPhysical = new Physical_Address(); //step 1
                            $oPhysical->id = NULL;
                            $data_res = $oPhysical->Save();
                            $id_fisica = $db->Insert_ID();
                            if($data_res == false){
                                $data_return[2] .= 'No se pudo crear la nueva dirección física';
                            }
                            $oFiscal = new Fiscal_Address(); //step 2
                            $oFiscal->id = NULL;
                            $data_res = $oFiscal->Save();
                            $id_fiscal = $db->Insert_ID();
                            if($data_res == false){
                                $data_return[2] .= 'No se pudo crear la nueva dirección fiscal';
                            }
                        }
                        $oDatosUsuarios = new DatosAdicionales();
                        $oDatosUsuarios->id_usuario = $id_usuario;
                        $resData = $oDatosUsuarios->Load("id_usuario=" . $id_usuario);
                        $arAttibutes = $oDatosUsuarios->GetAttributeNames();
                        foreach ($arAttibutes as $attribute) {
                            if (!empty($ar_data[$attribute])) {
                                $oDatosUsuarios->$attribute = $ar_data[$attribute];
                            }
                        }
                        if (true == $resData) {
                            $res = $oDatosUsuarios->Update();
                        } else {
                            $oDatosUsuarios->id_direccion = $id_fisica;
                            $oDatosUsuarios->id_direccion_fiscal = $id_fiscal;
                            $res = $oDatosUsuarios->Save();
                        }
                        if(true==$res){
                            $oUserProfile = new UsuariosHasPerfiles();
                            $id_perfil = $ar_data['id_perfil'];
                            if (empty($id_perfil)) {
                                $id_perfil = 4;
                            }
                            $ar_profile = $oUserProfile->Find("id_usuario='$id_usuario' AND id_entidad='$id_entidad'");
                            if (!empty($ar_profile)) {
                                foreach ($ar_profile as $oProfile) {
                                    $oProfile->Delete();
                                }
                            }
                            $oUserProfile->id_usuario = $id_usuario;
                            $oUserProfile->id_perfil = $id_perfil;
                            $oUserProfile->id_entidad = $id_entidad;
                            $resP = $oUserProfile->Save();
                            if (false == $resP) {
                                $data_return[2] .= $oUserProfile->ErrorMsg() . '<br>';
                            } else {
                                $db->completeTrans();
                                if(empty($ar_data['pass']) && $ar_data['id_usuario'] == 0){
                                    $sender_mail = notify_new_user(1,$ar_data['mail'],$random_pw);
                                }
                                $data_return[2] .= $sender_mail['Msj'];
                            }
                        }
                    }
                }
            }else{
                $data_return['id_usuario'] = $ar_data['id_usuario'];
                $data_return[0] = true;
                $data_return[1] = '¡Algo salió mal!';
                $data_return[2] = $arRes[1];
                $data_return[3] = filter_var($oUser->ErrorMsg(), FILTER_SANITIZE_SPECIAL_CHARS);
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data_return);
            break;
        case 'LOGIN':
            /* Valida Login */
            $db->debug = 0;
            $oUser->pass = str_replace('_' . session_id(), '', $ar_data['password_' . session_id()]);
            $oUser->usuario = str_replace('_' . session_id(), '', $ar_data['usuario_' . session_id()]);
            $res = $oUser->login();
            if (true === $res) {
                //verify_session($_SESSION['system_id_usuario']); 
                $msg = 'Bienvenid@: ' . strtoupper($_SESSION['system_usuario']);
            } elseif (false === $res) {
                $msg = 'Ingresó usuario/correo o contraseña incorrectos, por favor verifique e intente nuevamente.';
            }
            include 'login_view.php';
            break;
        case 'LOGOUT':
            session_destroy();
            $msg = urlencode('Su sesión se cerró correctamente.');
            header('Location: ' . PATH . "?msg=$msg");
            die($msg);
            break;
        case 'RESETPW':
            $arRes = reset_psw();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($arRes);
        break;
        case 12:
            $data_res = update_psw();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data_res);
        break; 
        case 13:
            $data_res = verify_token();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data_res);
        break;   
        default:
            header("Location: ../");
        break;
    }
}

function get_obj() {
    $obj = new Usuario();
    return $obj;
}

function helper_data() {
    return $ar_data = filter_input_array(INPUT_POST);
}

function valida_datos($ar_data) {
    $arRes = array();
    global $db;
    $db->debug = 0;
    $validUser = get_obj();
    $mail = filter_var(trim($ar_data['mail']), FILTER_VALIDATE_EMAIL);
    if (false == $mail) {
        $error = true;
        $msg .= '[El mail es Incorrecto] ';
    }
    $usuario = true;
    if (false == $usuario) {
        $error = true;
        $msg .= '[Nombre de usuario incorrecto] ';
    }
    $res = $validUser->Load("usuario LIKE '$usuario'");
    if ((true == $res || empty($usuario)) && empty($ar_data['id_usuario'])) {
        $error = true;
        $msg .= '[El nombre de Usuario ya está registrado o no es válido] ';
    }
    $string_mail = $ar_data['mail'];
    $res = $validUser->Load("mail LIKE '$string_mail'");
    if ((true == $res || empty($ar_data['mail'])) && empty($ar_data['id_usuario'])) {
        $error = true;
        $msg .= '[El correo electrónico ya está registrado o no es válido] ';
    }
    if (!empty($ar_data['id_usuario'])) {
        $data_usuario = $ar_data['usuario'];
        $resCheck = $validUser->load("usuario = '".$data_usuario."'  AND id_usuario != ".$ar_data['id_usuario']."");
        if (true == $resCheck) {
            $error = true;
            $msg .= '[Nombre de usuario ya existe] ';
        }
    }
    if (!empty($ar_data['id_usuario'])) {
        $data_mail = $ar_data['mail'];
        $resCheck = $validUser->load("mail = '".$data_mail."'  AND id_usuario != ".$ar_data['id_usuario']."");
        if (true == $resCheck) {
            $error = true;
            $msg .= '[El correo electrónico que intenta registrar ya existe] ';
        }
    }
    if($error == true){
        $msg .= " Verifica los datos e intenta nuevamente";
    }
    return array(0 => $error, 1 => $msg);
}

function verify_session($user) {
    global $db;
    $db->debug = 0;
    $maxusers = 1;
    $desconectar = 'DESC';
    $result = $db->Execute("SELECT COUNT(expireref), sesskey FROM sys_sesiones WHERE expireref='$user' ")or trigger_error($db->ErrorMsg(), E_USER_ERROR);
    if (!$result->EOF) {
        list($numSesiones) = $result->FetchRow();
        if ($numSesiones >= $maxusers) {
            $idSesion = session_id();
            $qrSesiones = 'SELECT sesskey FROM sys_sesiones WHERE ' .
                    "expireref ='$user' AND sesskey <> '$idSesion' ORDER BY expiry $desconectar";     
            $result = $db->Execute($qrSesiones)or die(trigger_error($db->ErrorMsg(), E_USER_ERROR));
            if (!$result->EOF) {
                while (list($idSesion) = $result->FetchRow()) {
                    $result = $db->Execute("DELETE FROM sys_sesiones WHERE sesskey = '$idSesion'")or die(trigger_error($db->ErrorMsg(), E_USER_ERROR));
                }
            }
        }
    }
}

function carga_imagen() {
    $resultado = array();
    $ds = DIRECTORY_SEPARATOR;
    $storeFolder = DIR_PATH . '/Files/Users/';
    if (!empty($_FILES)) {
        $tempFile = $_FILES['file']['tmp_name'];
        $direccion = $storeFolder . $ds;
        $nombreArchivo = time() . '-' . $_FILES['file']['name'];
        $archivoPrincipal = $direccion . 'original' . $ds . $nombreArchivo;
        $archivoBig = $direccion . 'big' . $ds . $nombreArchivo;
        $archivoMedium = $direccion . 'medium' . $ds . $nombreArchivo;
        $archivoSmall = $direccion . 'small' . $ds . $nombreArchivo;
        move_uploaded_file($tempFile, $archivoPrincipal);
        list($width, $height) = getimagesize($archivoPrincipal);
        $resultado['original'] = $archivoPrincipal;
        $resultado['big'] = $archivoBig;
        $resultado['medium'] = $archivoMedium;
        $resultado['small'] = $archivoSmall;
        $resultado['nombre'] = $nombreArchivo;
        $resultado['iWidth'] = $width;
        $resultado['iHeight'] = $height;
    } else {
        $resultado['original'] = 'user.png';
        $resultado['big'] = 'user.png';
        $resultado['medium'] = 'user.png';
        $resultado['small'] = 'user.png';
        $resultado['nombre'] = 'user.png';
        $resultado['iWidth'] = '300px';
        $resultado['iHeight'] = '300px';
    }
    return json_encode($resultado);
}

function recortar_img() {
    $targ_w = 300;
    $targ_h = 300;
    $jpeg_quality = 90;
    $src = DIR_PATH . DIR_APP . 'Files/Users/original/' . $_POST['imagen'];
    if (true == $_POST['imagen']) {
        $ext = pathinfo($src, PATHINFO_EXTENSION);
        $nombreArchivo = $_POST['imagen'];
        if ('png' == $ext) {
            png2jpg($src);
            $src = str_replace('png', 'jpg', $src);
            $nombreArchivo = str_replace('png', 'jpg', $_POST['imagen']);
        }
        $img_r = imagecreatefromjpeg($src);
        list($width, $height) = getimagesize($src);
        $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
        imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x1'], $_POST['y1'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
        imagejpeg($dst_r, $src = DIR_PATH . '/Files/Users/big/' . $_POST['imagen'], $jpeg_quality);
        $storeFolder = 'Files/usuarios';
        $direccion = DIR_PATH . DIR_APP . $storeFolder . DIR_APP;
        $archivoBig = $direccion . 'big' . DIR_APP . $nombreArchivo;
        $archivoMedium = $direccion . 'medium' . DIR_APP . $nombreArchivo;
        $archivoSmall = $direccion . 'small' . DIR_APP . $nombreArchivo;
        copy($src, $archivoMedium);
        copy($src, $archivoSmall);
        copy($src, $archivoBig);
        image_gd($archivoMedium, 259);
        image_gd($archivoSmall, 40);
    }
    $resultado = array();
    $resultado['nombre'] = $nombreArchivo;
    return json_encode($resultado);
}

function reset_psw() {
    global $db;
    $db->debug = 0;
    $arData = helper_data();
    $email = filter_var(trim($arData['email']), FILTER_VALIDATE_EMAIL);
    if (!empty($email)) {
        $oUser = new Usuario();
        $res = $oUser->Load("mail LIKE '$email'");
        if (true == $res) {
            $user_id = $oUser->id_usuario;
            $fecha = date('Y-m-d H:i:s');
            $oRecovery = new Recovery_accounts();
            $data_rec = $oRecovery->Load("user_id = '$user_id' AND DATE(expiration) < '$fecha' AND estatus = 1");
            if($data_rec == false){
                $oToken = new Token_Generator();
                $data_token = $oToken->getToken(16);
                $token_id = $data_token['token'];
                $verification_code = $data_token['code'];
                $date = new DateTime();
                $date->modify('8 hours');
                $expiration = $date->format('Y-m-d H:i:s');
                $oRecovery->user_id = $user_id;
                $oRecovery->verification_code = $verification_code;
                $oRecovery->token = $token_id;
                $oRecovery->expiration = $expiration;
                $oRecovery->estatus = 1;
                $data_save = $oRecovery->save();
                if($data_save == true){
                    include DIR_PATH . '/classes/PHPMailer-master/class.phpmailer.php';
                    include DIR_PATH . '/classes/PHPMailer-master/class.smtp.php';
                    $url = DIR_PATH . '/assets/themes/welcome.html';
                    $strBody = file_get_contents($url) or trigger_error('Error al obtener url ' . $url, E_USER_ERROR);
                    $profile = '<p align="justified">Esta liga estará disponible sólo las siguientes <b>8</b> horas. <br> 
                                Si tú no solicitaste una contraseña nueva, escríbenos a soporte@grupoconstructorhuma.com';
                    $mensaje = 'Ingresa al siguiente enlace para crear una nueva contraseña usando el siguiente código de verificación: <b>'.$verification_code.'</b></p>';
                    $link = '<a style="color:#FFFFFF"; class="btn-primary" href="'.PATH.'account_recovey.php?usrid='.$user_id.'&token='.$token_id.'"">
                    Crear nueva contraseña</a>';
                    $arrContextOptions = array(
                        "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                        ),
                    );
                    $despedida .= '<p><center>GRUPO CONSTRUCTOR HUMA<br>
                                    MARCA REGISTRADA <br>
                                    DERECHOS RESERVADOS 2020</center></p>';
                    $strBody = str_replace('###preview###', 'Haz solicitado la restauración de tu contraseña', $strBody);                
                    $strBody = str_replace('###titulo###', 'Restaura tu contraseña', $strBody);
                    $strBody = str_replace('###mensaje###', $mensaje, $strBody);
                    $strBody = str_replace('###logotipo###', DIR_PATH . '/assets/img/logo.png', $strBody);
                    $strBody = str_replace('###DOMAIN###', DOMAIN, $strBody);
                    $strBody = str_replace('###PATH###', DIR_PATH, $strBody);
                    $strBody = str_replace('###profile###', $profile, $strBody);
                    $strBody = str_replace('###despedida###', $despedida, $strBody);
                    $strBody = str_replace('###activation###', $link, $strBody);
                    $mail = new PHPMailer($trueExeption = true);
                    try {
                        $mail->FromName = 'Grupo Constructor HUMA';
                        $mail->AddAddress($email, $nombre);
                        $mail->IsHTML(true);
                        $mail->Subject = 'Recuperación de cuenta';
                        $mail->AltBody = 'Para ver este email utilice un cliente de email compatible con HTML!';
                        $mail->MsgHTML($strBody);
                        $result = $mail->Send();
                        if (true == $result) {
                            $msg .= '¡Te hemos enviado un e-mail para que puedas recuperar tu contraseña!';
                        } else {
                            $error = true;
                            $msg .= 'Error in component that sends the mail. ' . $result;
                        }
                    } catch (phpmailerException $e) {
                        $error = $e->errorMessage(); //Pretty error messages from PHPMailer
                        $msg .= $error;
                    } catch (Exception $e) {
                        $error = $e->getMessage(); //Boring error messages from anything else!
                        $msg .= $error;
                    }
                }else{
                    $error = true;
                    $msg .= 'No hemos podido procesar tu solicitud, inténtalo de nuevo por favor!';
                }
            }else{
                $error = true;
                $msg .= 'Tu enlace, de una solicitud anterior, aún no expira. Revisa tu bandeja de entrada por favor!';
            }
        } else {
            $error = true;
            $msg .= 'No hemos encontrado un usuario ligado a esa cuenta de correo, corrobora la información!';
        }
    } else {
        $error = true;
        $msg .= 'Ingresa tu cuenta de correo electrónico registrada en el sistema';
    }
    return array(0 => $error, 1 => $msg);
}

function update_psw() {
    global $db;
    $db->debug = 0;
    $arData = helper_data();
    $user_id = trim($arData['user_id']);
    $verification_code = trim($arData['code_']);
    $token_id = trim($arData['token_key']);
    $pass_0 = trim($arData['password_']);
    $pass_1 = trim($arData['passwordRe_']);
    if(count(array_filter($arData)) !== count($arData)){
        $error = true;
        $msg = '<b>No hemos podido procesar tu solicitud, la información no se ha cargado correctamente, ejecuta de nuevo el link de recuperación!</b>';
        return array(0 => $error, 1 => $msg);
    }
    if($pass_0 !== $pass_1 || strlen($pass_0) < 8 || strlen($pass_1) < 8 ){
        $error = true;
        $msg = '<b>No hemos podido procesar tu solicitud, las contraseñas no coinciden o su longitud es menor a 8 caracteres, inténtalo de nuevo por favor!</b>';
        return array(0 => $error, 1 => $msg);
    }
    $db->startTrans();
        $oUser = new Usuario();
        $res = $oUser->Load("id_usuario = '$user_id' AND estatus = 1");
        if (true == $res) {
            $user_id = $oUser->id_usuario;
            $email = $oUser->mail;
            $fecha = date('Y-m-d H:i:s');
            $oRecovery = new Recovery_accounts();
            $data_rec = $oRecovery->Load("user_id = '$user_id' AND verification_code = '$verification_code' AND token = '$token_id' AND estatus = 1");
            $recovery_id = $oRecovery->id;
            $expiration = $oRecovery->expiration;
            $send_mail = false;
            if($data_rec == true && $fecha <= $expiration){
                $oUser->pass = SHA1($pass_0);
                $sql_user = $oUser->update();
                if($sql_user == true){
                    $oRecovery->estatus = 2;
                    $sql_rec = $oRecovery->update();
                    if($sql_rec == true){
                        $db->completeTrans();
                        $send_mail = true;
                    }else{
                        $error = true;
                        $msg = filter_var($oRecovery->ErrorMsg(), FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }else{
                    $error = true;
                    $msg = filter_var($oUser->ErrorMsg(), FILTER_SANITIZE_SPECIAL_CHARS);
                }
                if($send_mail == true){
                    include DIR_PATH . '/classes/PHPMailer-master/class.phpmailer.php';
                    include DIR_PATH . '/classes/PHPMailer-master/class.smtp.php';
                    $url = DIR_PATH . '/assets/themes/welcome.html';
                    $strBody = file_get_contents($url) or trigger_error('Error al obtener url ' . $url, E_USER_ERROR);
                    $profile = '<p>Si tú no reconoces este proceso escríbenos a soporte@grupoconstructorhuma.com</p>';
                    $mensaje = 'Tu contraseña se ha actualizado con éxito y ya puedes continuar usando nuestra aplicación, gracias por confiar.';
                    $link = '<a style="color:#FFFFFF"; class="btn-primary" href="'.PATH.'index.php"">
                    Iniciar Sesión</a>';
                    $arrContextOptions = array(
                        "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                        ),
                    );
                    $despedida .= '<p><center>GRUPO CONSTRUCTOR HUMA<br>
                                    ES UNA MARCA REGISTRADA<br>
                                    DERECHOS RESERVADOS 2020</center></p>';
                    $strBody = str_replace('###preview###', 'Haz actualizado tu contraseña', $strBody);                
                    $strBody = str_replace('###titulo###', 'Restauración de contraseña', $strBody);
                    $strBody = str_replace('###mensaje###', $mensaje, $strBody);
                    $strBody = str_replace('###logotipo###', DIR_PATH . '/assets/img/logo.png', $strBody);
                    $strBody = str_replace('###DOMAIN###', DOMAIN, $strBody);
                    $strBody = str_replace('###PATH###', DIR_PATH, $strBody);
                    $strBody = str_replace('###profile###', $profile, $strBody);
                    $strBody = str_replace('###despedida###', $despedida, $strBody);
                    $strBody = str_replace('###activation###', $link, $strBody);
                    $mail = new PHPMailer($trueExeption = true);
                    try {
                        $mail->FromName = 'Grupo Constructor HUMA';
                        $mail->AddAddress($email, $nombre);
                        $mail->IsHTML(true);
                        $mail->Subject = 'Recuperación de cuenta';
                        $mail->AltBody = 'Para ver este email utilice un cliente de email compatible con HTML!';
                        $mail->MsgHTML($strBody);
                        $result = $mail->Send();
                        if (true == $result) {
                            $msg .= '¡Te hemos enviado un e-mail de confirmación. Gracias!';
                        } else {
                            $error = true;
                            $msg .= 'Error in component that sends the mail. ' . $result;
                        }
                    } catch (phpmailerException $e) {
                        $error = $e->errorMessage(); //Pretty error messages from PHPMailer
                        $msg .= $error;
                    } catch (Exception $e) {
                        $error = $e->getMessage(); //Boring error messages from anything else!
                        $msg .= $error;
                    }
                }else{
                    $error = true;
                    $msg .= 'No hemos podido procesar tu solicitud, inténtalo de nuevo por favor!';
                }
            }else{
                $error = true;
                $msg = 'El link de recuperación ha expirado, solicite uno nuevo desde el formulario de "¿Olvidó su contraseña?"';
            }
        } else {
            $error = true;
            $msg .= 'No hemos encontrado un usuario activo ligado a esa cuenta de correo, corrobora la información!';
        }
    return array(0 => $error, 1 => $msg);
}

function notify_new_user($send_mail, $email, $pw){
    if($send_mail == true){
        include DIR_PATH . '/classes/PHPMailer-master/class.phpmailer.php';
        include DIR_PATH . '/classes/PHPMailer-master/class.smtp.php';
        $url = DIR_PATH . '/assets/themes/welcome.html';
        $strBody = file_get_contents($url) or trigger_error('Error al obtener url ' . $url, E_USER_ERROR);
        $profile = '<p>Si tú no reconoces este proceso escríbenos a /p>';
        $mensaje = 'Haz sido dado de alta con éxito al Software Administrativo de Grupo Constructor HUMA y ya puedes empezar a hacer uso de la aplicación, tus datos de acceso son los siguientes:<br>
                    e-mail: '.$email.'<br>
                    contraseña: '.$pw;
        $link = '<a style="color:#FFFFFF"; class="btn-primary" href="'.PATH.'index.php"">
        Iniciar Sesión</a>';
        $arrContextOptions = array(
            "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
            ),
        );
        $despedida .= '<p><center>GRUPO CONSTRUCTOR HUMA<br>
                        ES UNA MARCA REGISTRADA<br>
                        DERECHOS RESERVADOS 2020</center></p>';
        $strBody = str_replace('###preview###', 'Registro de Nuevo Usuario', $strBody);                
        $strBody = str_replace('###titulo###', 'Alta de Usuario', $strBody);
        $strBody = str_replace('###mensaje###', $mensaje, $strBody);
        $strBody = str_replace('###logotipo###', DIR_PATH . '/assets/img/logo_huma.JPEG', $strBody);
        $strBody = str_replace('###DOMAIN###', DOMAIN, $strBody);
        $strBody = str_replace('###PATH###', DIR_PATH, $strBody);
        $strBody = str_replace('###profile###', $profile, $strBody);
        $strBody = str_replace('###despedida###', $despedida, $strBody);
        $strBody = str_replace('###activation###', $link, $strBody);
        $mail = new PHPMailer($trueExeption = true);
        try {
            $mail->FromName = 'Grupo Constructor HUMA';
            $mail->AddAddress($email, $nombre);
            $mail->IsHTML(true);
            $mail->Subject = 'Nuevo Usuario';
            $mail->AltBody = 'Para ver este email utilice un cliente de email compatible con HTML!';
            $mail->MsgHTML($strBody);
            $result = $mail->Send();
            if (true == $result) {
                $msg .= ' Y el mensaje de confirmación se ha enviado correctamente!';
            } else {
                $error = true;
                $msg .= 'Error in component that sends the mail. ' . $result;
            }
        } catch (phpmailerException $e) {
            $error = $e->errorMessage(); //Pretty error messages from PHPMailer
            $msg .= $error;
        } catch (Exception $e) {
            $error = $e->getMessage(); //Boring error messages from anything else!
            $msg .= $error;
        }
    }else{
        $error = true;
        $msg .= 'No hemos podido procesar tu solicitud, inténtalo de nuevo por favor!';
    }
    return array('Error'=>$error,'Msj'=>$msg);
}

function add_social() {
    global $db;
    $ar_data = helper_data();
    $oUser = get_obj();
    $arRes = array();
    if (!empty($ar_data)) {
        $id_social = $ar_data['id_social'];
        $mail = $ar_data['mail'];
        $rsSocial = $oUser->Load("id_social='$id_social' OR mail LIKE '$mail'");
        if (true == $rsSocial) {
            $ar_data['id_usuario'] = $oUser->id_usuario;
        }
        $arAttibutes = $oUser->GetAttributeNames();
        foreach ($arAttibutes as $attribute) {
            $$attribute = filter_var($ar_data[$attribute], FILTER_SANITIZE_SPECIAL_CHARS);
            $oUser->$attribute = $$attribute;
        }

        $id_entidad = $ar_data['id_entidad'];
        if (empty($pass)) {
            $new_pass = uniqid();
            $oUser->pass = sha1($new_pass);
        }
        if (empty($usuario)) {
            $oUser->usuario = $mail;
        }
        if (empty($id_entidad)) {
            $arRes[0] = true;
            $arRes[1] = 'Error: por favor elija una entidad o negocio de afiliación.';
        } else {
            $db->startTrans();
            $oUser->estatus = 1;
            if (empty($id_usuario)) {
                $oUser->id_usuario = 0;
                $res = $oUser->Save();
                $id_usuario = $db->Insert_ID();
            } else {
                $oUser->id_usuario = $id_usuario;
                $res = $oUser->Update();
            }
            if (true == $res) {
                $db->debug = 0;
                $oUserProfile = new UsuariosHasPerfiles();
                if (empty($id_perfil)) {
                    $id_perfil = 4;
                }
                $resP = $oUserProfile->Load("id_usuario='$id_usuario' AND id_perfil='$id_perfil' AND id_entidad='$id_entidad' ");
                if (false == $resP) {
                    $oUserProfile->id_usuario = $id_usuario;
                    $oUserProfile->id_perfil = $id_perfil;
                    $oUserProfile->id_entidad = $id_entidad;
                    $resP = $oUserProfile->Save();
                }
                if (false == $resP) {
                    $arRes[0] = true;
                    $arRes[1] .= filter_var($oUserProfile->ErrorMsg(), FILTER_SANITIZE_FULL_SPECIAL_CHARS) . '<br>';
                } else {
                    $db->completeTrans();
                    $arRes['id_usuario'] = $id_usuario;
                    $arRes[0] = false;
                    $arRes[1] .= '<i class="fa fa-check-circle-o"></i> El registro se guardo con éxito. <a href="./"> Ir al login</a>';
                }
            } else {
                $arRes[0] = true;
                $arRes[1] = filter_var($oUser->ErrorMsg(), FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
    } else {
        $arRes[0] = true;
        $arRes[1] = 'No se obtuvieron datos';
    }
    return json_encode($arRes);
}

function verify_token(){
    global $db;
    $db->debug = 0;
    $arData = helper_data();
    $user_id = $arData['user'];
    $token = $arData['token'];
    $fecha = date('Y-m-d H:i:s');
    $oRecovery = new Recovery_accounts();
    $data_rec = $oRecovery->Load("token = '$token' AND user_id = '$user_id' AND estatus = 1 LIMIT 1"); 
    $expiration = $oRecovery->expiration;
    if($data_rec == true){
        if($fecha >= $expiration){
            $oRecovery->estatus = 2;
            $sql_res = $oRecovery->update();
            if($sql_res == true){
                $error = true;
                $msg = 'El link de recuperación ha expirado, solicite uno nuevo desde el formulario de "¿Olvidó su contraseña?"';
            }else{
                $error = true;
                $msg = filter_var($oRecovery->ErrorMsg(), FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
    }else{
        $error = true;
        $msg = 'Los datos proporcionados no son correctos o el link ha expirado, solicite uno nuevo desde el formulario de "¿Olvidó su contraseña?"';
    }
    return array(0 =>$error, 1=>$msg);
}

function convert_title($string){
    $string = mb_convert_case($string, MB_CASE_TITLE, "utf8");
    return $string;
}

function generate_password(){
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
    $password = substr( str_shuffle( $chars ), 0, 8 );
    return $password;
}
exit;
?>