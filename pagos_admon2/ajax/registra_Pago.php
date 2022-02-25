<?php
	if(isset($_POST['id_requisicion']) && isset($_POST['consecutivo']) && isset($_POST['saldo']) && isset($_POST['fecha']) && isset($_POST['folio']) && isset($_POST['documento']) && isset($_POST['monto']))
	{
		// include Database connection file 
		include_once("../../../conectar/conecta.php");

		// get values 
		$id_requisicion = $_POST['id_requisicion'];
		$consecutivo = $_POST['consecutivo'];
		$total = $_POST['total'];
		$saldo = $_POST['saldo'];
		$fecha = $_POST['fecha'];
		$folio = $_POST['folio'];
		$documento = $_POST['documento'];
		$monto = $_POST['monto'];
		$metodo = $_POST['metodo'];
		
		if ($monto == $saldo) {
            $query = "update pagos set status='Pagado', fecha_pago= '".$fecha."', saldo = 0 where id_requisicion = '".$id_requisicion."' and consecutivo= '".$consecutivo."'";
            if (!$result = mysqli_query($connect, $query)) {
	            exit(mysqli_error($connect));
	        }
	        if($total >= $saldo) {
	            $query3 = "INSERT INTO pagos_detalle(id_requisicion, consecutivo, fecha, monto, documento, folio, metodo) VALUES('$id_requisicion', '$consecutivo', '$fecha', '$monto', '$documento', '$folio', '$metodo')";
		        $res1 = mysqli_query($connect, $query3) ;
	        }
	        echo "Pago Total Registrado!" ;
		} else {
		    $query = "INSERT INTO pagos_detalle(id_requisicion, consecutivo, fecha, monto, documento, folio, metodo) VALUES('$id_requisicion', '$consecutivo', '$fecha', '$monto', '$documento', '$folio', '$metodo')";
		    $res1 = mysqli_query($connect, $query) ;
		    $saldo = $saldo - $monto ;
		    $query2 = "update pagos set status='Parcial', saldo = '$saldo' where id_requisicion = '$id_requisicion' and consecutivo = '$consecutivo'" ;
		    $res2 = mysqli_query($connect, $query2) ;
		    if ($res1 && $res2) {
		        echo "Pago Parcial Registrado! saldo: ".$saldo." monto: ".$monto ;
		    }   
		}
	} else {
	    echo "nada que hacer" ;
	}
?>