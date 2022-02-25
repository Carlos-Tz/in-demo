<?php
	// include Database connection file 
	include_once("../../../conectar/conecta.php");
	
    $id_detalle = $_POST['id_detalle'];
	$numeral = $_POST['numeral'];

    $data = '<h3>Orden de Compra: '.$id_detalle.'-'.$numeral.'</h3>';
	// Design initial table header 
	$data .= '<table class="table table-responsive table-bordered table-striped" id="lista_Detalle">
	            <thead>
						<tr>
							<th>Fecha</th>
							<th>Metodo de Pago</th>
							<th>Folio</th>
							<th>Documento</th>
							<th>Monto</th>
						</tr>
				</thead>
				<tbody>';

	$query = "SELECT * FROM pagos_detalle where id_requisicion=".$id_detalle." and consecutivo=".$numeral." order by fecha" ;
    $result = mysqli_query($connect, $query) ;

    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<tr>
    		    <td>'.$row["fecha"].'</td>
    		    <td>'.$row["metodo"].'</td>
    		    <td>'.$row["folio"].'</td>
    		    <td>'.$row["documento"].'</td>
    		    <td>$ '.str_pad(number_format($row ["monto"],2,".",","),10, " ", STR_PAD_LEFT).'</td>
    		</tr>';
    	}
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="6">No hay registros!</td></tr>';
    }

    $data .= '</tbody></table>';

 echo $data ;

?>