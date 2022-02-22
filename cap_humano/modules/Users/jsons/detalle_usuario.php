<?php

header('Content-Type: application/json; charset=utf-8');
$arJson = array();
$id_entidad = $_SESSION['system_id_entidad'];
if (!empty($id_usuario) && !empty($id_entidad)) {
    $res = $oUser->Load('id_usuario=' . $id_usuario . $conditions);
    if (true == $res) {
        $arAttibutes = $oUser->getAttributeNames();
        foreach ($arAttibutes as $attribute) {
            $$attribute = $oUser->$attribute;
            $arJson[$attribute] = $$attribute;
        }
        $oDatosUsuario = $oUser->sys_user_data;
        if (false != $oDatosUsuario) {
            foreach ($oDatosUsuario as $datos) {
                $arAttibutes = $datos->getAttributeNames();
                foreach ($arAttibutes as $attribute) {
                    $$attribute = $datos->$attribute;
                    $arJson[$attribute] = $$attribute;
                }
            }
        }
        $oPerfilesUsuario = $oUser->sys_users_have_profiles;
        if (false != $oPerfilesUsuario) {
            foreach ($oPerfilesUsuario as $datos) {
                $arAttibutes = $datos->getAttributeNames();
                foreach ($arAttibutes as $attribute) {
                    $$attribute = $datos->$attribute;
                    $arJson[$attribute] = $$attribute;
                }
            }
        }
    }
}
echo json_encode($arJson);
