<?php
	// include Database connection file 
	include_once("../../../conectar/conecta.php");

	$query = "SELECT id, title FROM sys_catalog_payment_methods order by title" ;
    $result = mysqli_query($connect, $query) ;

    if(mysqli_num_rows($result) > 0)
    {
        $data = '';
    	while($row = mysqli_fetch_assoc($result))
    	{
    		$data .= '<option value='
    		         .$row["id"].
                     '>'
                     .$row["title"].
                     '</option>' ;
    	}
    }
    else
    {
    	// records now found 
    	$data .= '<tr><td colspan="6">No hay registros!</td></tr>';
    }

 echo $data ;

?>