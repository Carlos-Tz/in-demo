<?php

ADOdb_Active_Record::SetDatabaseAdapter($db);

class Usuario extends ADOdb_Active_Record {

    var $_table = 'sys_users';

    function login() {
        global $db;
        $usuario = trim($this->usuario);
        $pass = sha1($this->pass);
        $mail = filter_var(strtolower($usuario), FILTER_VALIDATE_EMAIL);
        if (true == $mail) {
            $usr_validate = "AND LOWER(mail) LIKE '$mail%'";
        } else {
            $usr_validate = "AND LOWER(usuario)=LOWER('$usuario')";
        }
        $res = $this->Load("pass='$pass' $usr_validate AND estatus=1");
        if (true == $res) {
            $id_usuario  = $this->id_usuario;
            $nombre      = $this->nombre;
            $ap_paterno  = $this->ap_paterno;
            $ar_entidad  = $this->sys_users_have_profiles;
            $data_perfil = $this->get_perfil($id_usuario);
            if (is_array($ar_entidad)) {
                foreach ($ar_entidad as $datos) {
                    $arAttibutes = $datos->getAttributeNames();
                    foreach ($arAttibutes as $attribute) {
                        $$attribute = $datos->$attribute;
                    }
                    break;
                }
            }
            $_SESSION['user_name'] = $nombre;
            $_SESSION['last_name'] = $ap_paterno;
            $_SESSION['system_id_usuario'] = $id_usuario;
            $_SESSION['system_id_entidad'] = $id_entidad;
            $_SESSION['system_usuario'] = $this->usuario;
            $_SESSION['system_mail'] = $this->mail;
            $_SESSION['system_id_perfil'] = $id_perfil;
            $_SESSION['system_renovar'] = $this->renovar;
            $remote_addr = get_ip();            
            if (empty($remote_addr)) {
                $remote_addr = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');
                if (empty($user_agent)) {
                    $remote_addr = filter_input(INPUT_ENV, 'HTTP_USER_AGENT');
                }
            }
            $_SESSION['remoteAddr'] = $remote_addr;
            $GLOBALS['remoteAddr'] = &$remote_addr;
            $GLOBALS['system_id_usuario'] = &$_SESSION['system_id_usuario'];
            $_SESSION['system_intentos'] = 0;
            return true;
        } else {
            return false;
        }
    }


    function valida_nombre_usuario($nombre_usuario) {
        if (3 >= strlen($nombre_usuario) || 20 < strlen($nombre_usuario)) {
            return false;
        }
        $permitidos = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_@.';
        for ($i = 0; $i < strlen($nombre_usuario); $i++) {
            if (false === strpos($permitidos, substr($nombre_usuario, $i, 1))) {
                return false;
            }
        }
        return trim($nombre_usuario);
    }

    function validaPassword($password) {
        $tamanoMin = 6;
        if (empty($tamanoMin)) {
            return false;
        }
        if (!empty($password)) {
            if (ctype_space($password) || false !== strpos($password, ' ')) {
                return false;
            }
            $pass = (strip_tags($password));
            $passw = (strlen(trim($pass)));
            if ($passw < $tamanoMin || 15 < strlen($passw)) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }


    function get_perfil($id_usuario) {
        global $db;
        $user_id = $id_usuario;
        if (!empty($user_id)) {
            $profile = 'Usuario';
            $qrPerfil = 'SELECT p.`id_perfil`, p.`id_entidad`, pf.nivel, pf.description, pf.titulo as 
                        titulo_perfil, e.entity_name FROM `sys_users_have_profiles` p 
                        INNER JOIN sys_entities e ON p.id_entidad=e.id LEFT JOIN sys_user_profiles pf 
                        ON pf.id_Cf=p.id_perfil WHERE e.estatus_id = 1 AND p.id_usuario = '.$user_id.' 
                        ORDER BY e.id DESC LIMIT 1';
            $rsPerfil = $db->Execute($qrPerfil)or die(trigger_error($db->ErrorMsg(), E_USER_ERROR));
            if (!$rsPerfil->EOF) {
                list($profile_id, $entity_id, $level, $profile_description, $profile, $entity_name) = $rsPerfil->FetchRow();
                $_SESSION['user_profile_id'] = $profile_id;
                $_SESSION['user_profile'] = $profile;
                $_SESSION['user_entity_id'] = $entity_id;
                $_SESSION['user_entity_name'] = $entity_name;
                $_SESSION['user_level'] = $level;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

class DatosAdicionales extends ADOdb_Active_Record {

    var $_table = 'sys_user_data';

}

class UsuariosHasPerfiles extends ADODB_Active_Record {

    var $_table = 'sys_users_have_profiles';

}


class Recovery_accounts extends ADODB_Active_Record {

    var $_table = 'sys_recovery_logs';

}

class Physical_Address extends ADODB_Active_Record {

    var $_table = 'sys_physical_address';

}

class Fiscal_Address extends ADODB_Active_Record {

    var $_table = 'sys_fiscal_address';

}

class Usuarios extends ADODB_Active_Record {

    var $_table = 'usuario';

}

class Empleados extends ADODB_Active_Record {

    var $_table = 'empleado';

}

class Token_Generator {
    
    function get_random_value($proposed_array) {
		$random_key = array_rand($proposed_array, 1);	//get a random key
		return $proposed_array[$random_key];	//return value
	}

	function get_Md5_char($char) {
		$md5Char = md5($chr.Time());	//Code char and time POSIX (timestamp) in md5
		$arrChar = str_split(strtoupper($md5Char));	//To array md5
		$charToken = $this->get_random_value($arrChar);	//get random item
		return $charToken;
    }

    function getToken($long) {
		$alphabet = "ABCDEFGHIJKMNPQRSTUVWXYZ";
		$to_upper = str_split($alphabet);
        $numbers = range(0,9);
		shuffle($to_upper);
        shuffle($numbers);
        $total_array = array_merge($to_upper,$numbers);
        $newToken = "";
        $very_code = "";
		for($i=0;$i<=$long;$i++) {
                $myChar = $this->get_random_value($total_array);
                if(is_numeric($myChar) == true){
                    $very_code .= $myChar;
                }
				$newToken .= $this->get_Md5_char($myChar);
        }
		return array('token'=>$newToken,'code'=>$very_code);
    }
}

ADODB_Active_Record::ClassHasMany('Usuario', 'sys_user_data', 'id_usuario');
ADODB_Active_Record::ClassHasMany('Usuario', 'sys_users_have_profiles', 'id_usuario');
