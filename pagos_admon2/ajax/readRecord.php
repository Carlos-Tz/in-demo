<?php
	include_once("../../../conectar/conecta.php");
	include_once("archivo.php") ;
	
	$proveedor = isset($_GET['proveedor'])?$_GET['proveedor']:"" ;

	$data = '';
	
	if(strcmp($proveedor,"")) {
	    $query = "SELECT * FROM pagos where status in ('Programado', 'Parcial') and nom_prov = '".$proveedor."' order by fecha_programada,id_requisicion,consecutivo" ;
	} else {
	    $query = "SELECT * FROM pagos where status in ('Programado', 'Parcial') order by fecha_programada,id_requisicion,consecutivo" ;  
	}
    $result = mysqli_query($connect, $query) ;

    if(mysqli_num_rows($result) > 0)
    {
    	while($row = mysqli_fetch_assoc($result))
    	{
    	    $orden_compra = "'".orden_pdf($row["id_requisicion"], $row["consecutivo"])."'" ;

    		$data .= '<tr>
    		    <td>'.$row["id_requisicion"].' - '.$row["consecutivo"].'</td>
    		    <td>'.$row["rfc"].'</td>
    		    <td>'.$row["nom_prov"].'</td>
    		    <td>'.$row["fecha_programada"].'</td>
    		    <td>'.$row ["subtotal"].'</td>
    		    <td>'.$row ["iva"].'</td>
    		    <td>'.$row ["total"].'</td>
    		    <td>'.$row ["saldo"].'</td>
				<td>
					<button type="button" onclick="hacerPago('.$row['id_requisicion'].')" class="btn btn-warning btn-sm"><i class="fas fa-dollar-sign"></i></button>
				</td>
				<td>
					<button type="button" onclick="VerParcialidades('.$row['id_requisicion'].')" class="btn btn-info btn-sm"><i class="fa fa-search" ></i></button>
				</td>
				<td>
				    <button type="button" onclick="VerOrdenCompra('.$orden_compra.')" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf"></i></button>
				</td>
    		</tr>' ;
    	}
    }
    else
    {
    	$data .= '<tr><td colspan="6">No hay registros!</td></tr>'.$query;
    }


 echo $data ;
?>