<?php
//	function conectar() {
		$conexion = null ;
		try {
		    /* $host = "174.136.25.125" ; */
		    $host = "localhost" ;
		    /* $user = "inomacmx_pruebas" ; */
		    $user = "root" ;
		    /* $pass = "=B(gO)K[a_uk" ; */
		    $pass = "" ;
		    /* $bd = "inomacmx_pruebas" ; */
		    $bd = "demo" ;

		    $connect = mysqli_connect($host, $user, $pass, $bd);
		    mysqli_set_charset($connect, 'utf8mb4'); 
			//$conexion = new PDO('mysql:dbname=inomacmx_pruebas;charset=utf8mb4;host=174.136.25.125', "inomacmx_pruebas", "=B(gO)K[a_uk") ;
		//	echo "Conectado con éxito".var_dump($connect) ;
		}
		catch(PDOException $e){
			echo '<p>No se puede conectar a la base de datos</p>'.$e->getMessage() ;
		}
//	}
//	return $conexion ;
