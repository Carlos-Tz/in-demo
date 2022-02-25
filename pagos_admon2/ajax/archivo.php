<?php
    function orden_pdf($id_requisicion, $consecutivo) {
        $nombre = "OC-PI-".$id_requisicion."-".$consecutivo.".pdf" ; 
        $directorio = opendir("../../../ordenes_compra"); //ruta actual
        while ($archivo = readdir($directorio)) {//obtenemos un archivo y luego otro sucesivamente
            if (is_dir($archivo)) {//verificamos si es o no un directorio
                if ($archivo != "." && $archivo != "..") {
                     echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
                }
            } else {
                $pos = strpos($archivo, $id_requisicion);
                if ($pos) {
                    if($archivo === $nombre) {
                        return $archivo ;
                    }
                }
            }
        }
    }
?>