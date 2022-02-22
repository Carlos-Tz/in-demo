<?php
class Modelo{
    private $db;
    public function __construct(){
        $this->Modelo = array();
        $this->db=new PDO('mysql:host=174.136.25.125;dbname=inomacmx_pruebas',"inomacmx_pruebas","=B(gO)K[a_uk");
    }
    public function mostrar($tabla,$condicion){
        $consul="select clasificacion from ".$tabla." where ".$condicion.";";
        /* $consul="select * from ".$tabla." where ".$condicion." ORDER BY clasificacion;"; */
        $resu=$this->db->query($consul);
        while($filas = $resu->FETCHALL(PDO::FETCH_ASSOC)) {
            $this->registros[]=$filas;
        }
        /* return array_unique($this->registros, SORT_STRING); */
        return $this->registros;
    } 
}

?>