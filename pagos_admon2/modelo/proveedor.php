<?php
    include("../../conectar/conecta.php") ;

    $sql2 = "select nom_prov from proveedor order by nom_prov";
    $data = mysqli_query($connect, $sql2);

    echo "<option value=''>Todos</option>" ;
    while($row = mysqli_fetch_array($data)){ 
        echo  '<option value="'.$row["nom_prov"].'" />'.$row['nom_prov'].'</option>' ;
    } 
    echo $sql2;
?>