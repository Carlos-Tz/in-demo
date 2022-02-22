<?php
   // Database Connection
   include 'connection/connection.php';

   // Reading value
   /* $draw = $_POST['draw'];
   $row = $_POST['start'];
   $rowperpage = $_POST['length']; // Rows display per page
   $columnIndex = $_POST['order'][0]['column']; // Column index
   $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
   $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
   $searchValue = $_POST['search']['value']; // Search value */

   
   $fechaI = $_POST['fechaI'];
   $fechaF = $_POST['fechaF'];

   // Total number of records without filtering
   /* $stmt = $conn->prepare("SELECT clasificacion FROM movtos_prod ");
   $stmt->execute();
   $records = $stmt->fetchAll();

   $clasificacion = array();
	foreach ($records as $key => $value)
		foreach ($value as $va ): 
            //print_r($va);
			$clasificacion[strtolower($va)] = strtolower($va);
         //print_r($value['clasificacion']);
		endforeach;
   $rubros = array_unique($clasificacion, SORT_STRING); */

   /* print_r($rubros); */
   $rubros = ['acido', 'agroquimico', 'ferreteria', 'fertilizante', 'infraestructura', 'inocuidad', 'mano de obra', 'maq. agricola', 'mat. fumigacion', 'mat. riego', 'otros', 'papeleria', 'servicios', 'vehiculos'];

   $stmt = $conn->prepare("SELECT movtos_prod.id_prod, movtos_prod.clasificacion, movtos_prod.cantidad, movtos_prod.precio_compra, movtos_prod.fecha_movto , movtos_prod.nom_prod, producto.unidad_medida from movtos_prod, producto WHERE movtos_prod.id_prod = producto.id_prod AND (movtos_prod.tipo = 'E') AND (movtos_prod.fecha_movto BETWEEN :fechaI AND :fechaF)");
   $stmt->bindParam(':fechaI', $fechaI, PDO::PARAM_STR);
   $stmt->bindParam(':fechaF', $fechaF, PDO::PARAM_STR);
   $stmt->execute();
   $data = $stmt->fetchAll();
   $data1 = array();


   /* print_r($data); */

   foreach ($rubros as $key_rubro => $value_rubro) :
        /* echo  $key_rubro . '===>' . $value_rubro . '<br>';  */
        $rub[$key_rubro] = array_filter($data, function ($row) use ($value_rubro) {
            return strtolower($row['clasificacion']) == $value_rubro;
        });
        /* print_r($rubros[$key_rubro]);  */
        /* echo '<br> monto = precio * cantidad <br>'; */
        $tot[$key_rubro] = 0;
        $ids_prod_all = array();
        foreach ($rub[$key_rubro] as $j => $v) :
            $tot[$key_rubro] += $v['precio_compra']*$v['cantidad'];
            /* print_r($v['precio_compra']*$v['cantidad']);echo ' = ';
            print_r($v['precio_compra']);
            echo ' * ';
            print_r($v['cantidad']);
            echo '<br>'; */
            array_push($ids_prod_all, $v['id_prod']);
            endforeach;
            /* echo '<br>total = ';
            print_r($tot[$key_rubro]); echo '<br>'; */
            $ids_prod_unique = array_unique($ids_prod_all, SORT_STRING);
            /* print_r($ids_prod_all); echo 'termina todos los id <br><br>'; */
            $prod_rubro = array();
         foreach ($ids_prod_unique as $j => $v) :
            /* print_r($v); echo '<br>'; */
            $pro[$j] = array_filter($rub[$key_rubro], function ($row) use ($v){
               return $row['id_prod'] == $v;
            });
            $subtotal = 0;
            $index = 0;
            $cantidad = 0;
            $p = '';
            $u = '';
            /* $p =  array(); */
            foreach ($pro[$j] as $l => $val) :
                  /* print_r($val); echo '<br>'; */
                  if ($index == 0): 
                     /* echo $index. '----'. $val['id_prod']. '____|____' . $val['nom_prod']. '____|'.$val['cantidad']*$val['precio_compra'] .'|____' . $val['cantidad']. '____|____' . $val['precio_compra'] . '____|____' .$val['fecha_movto']. '____|____' .$val['unidad_medida'] . '<br>'; */
                     /* echo $val['nom_prod'] .'<br>';  */
                     $p = $val['nom_prod'];
                     $u = $val['unidad_medida'];
                  endif;
                  $subtotal += $val['cantidad']*$val['precio_compra'];
                  $cantidad += $val['cantidad'];
                  $index++;
               endforeach;
               array_push($prod_rubro, array('p'=>$p, 'subtotal'=>$subtotal, 'cantidad'=>$cantidad, 'u'=>$u));
               /* echo 'subtotal= '.$subtotal.'<br>cantidad = '. $cantidad.'<br>';
               echo 'termina prod' . $val['id_prod'] . '<br>'; */

            endforeach;
            /* print_r($pro); echo 'termina rubro <br><br>'; */
            /* print_r($prod_rubro); */

            /* echo 'termina rubro ' . $value_rubro .'<br><br>'; */
            array_push($data1, array('rubro'=> $rubros[$key_rubro], 'total'=> $tot[$key_rubro], 'productos' => $prod_rubro));
         endforeach;
    /* echo '<br><br>'; */



   // Response
   $response = array(
      "draw" => 1,
     //  "iTotalRecords" => $totalRecords,
      // "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $data1
   );

   echo json_encode($response);