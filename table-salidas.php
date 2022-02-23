<?php
   // Database Connection
   include 'connection/connection.php';
   /* $fechaI = $_POST['fechaI'];
   $fechaF = $_POST['fechaF'] */;

   $rubros = ['acido', 'agroquimico', 'ferreteria', 'fertilizante', 'infraestructura', 'inocuidad', 'mano de obra', 'maq. agricola', 'mat. fumigacion', 'mat. riego', 'otros', 'papeleria', 'servicios', 'vehiculos'];

   /* $stmt = $conn->prepare("SELECT movtos_prod.id_prod, movtos_prod.clasificacion, movtos_prod.cantidad, movtos_prod.precio_compra, movtos_prod.fecha_movto , movtos_prod.nom_prod, producto.unidad_medida from movtos_prod, producto WHERE movtos_prod.id_prod = producto.id_prod AND (movtos_prod.tipo = 'S') AND (movtos_prod.fecha_movto BETWEEN :fechaI AND :fechaF)");
   $stmt->bindParam(':fechaI', $fechaI, PDO::PARAM_STR);
   $stmt->bindParam(':fechaF', $fechaF, PDO::PARAM_STR); */
   $stmt = $conn->prepare("SELECT movtos_prod.id_prod, movtos_prod.clasificacion, movtos_prod.cantidad, movtos_prod.precio_compra, movtos_prod.fecha_movto , movtos_prod.nom_prod, movtos_prod.subrancho, movtos_prod.sector, producto.unidad_medida, sector.hectareas, sector.nombre from movtos_prod, producto, sector WHERE movtos_prod.id_prod = producto.id_prod AND (movtos_prod.tipo = 'S') AND (sector.nombre = movtos_prod.sector)");
   $stmt->execute();
   $data = $stmt->fetchAll();
   /* print_r($data); */

   $data1 = array();


   foreach ($rubros as $key_rubro => $value_rubro) :
        //echo  $key_rubro . '===>' . $value_rubro . '<br>'; 
        $rub[$key_rubro] = array_filter($data, function ($row) use ($value_rubro) {
            return strtolower($row['clasificacion']) == $value_rubro;
        });
        //print_r($rubros[$key_rubro]); 
        //echo '<br> monto = precio * cantidad <br>';
        $tot[$key_rubro] = 0;
        $ids_prod_all = array();
        foreach ($rub[$key_rubro] as $j => $v) :
            $tot[$key_rubro] += $v['precio_compra']*$v['cantidad'];
            //print_r($v['precio_compra']*$v['cantidad']);echo ' = ';
            //print_r($v['precio_compra']);
            //echo ' * ';
            //print_r($v['cantidad']);
            //echo '<br>';
            array_push($ids_prod_all, $v['id_prod']);
            endforeach;
            //echo '<br>total = ';
            //print_r($tot[$key_rubro]); echo '<br>';
            $ids_prod_unique = array_unique($ids_prod_all, SORT_STRING);
            //print_r($ids_prod_all); echo 'termina todos los id <br><br>';
            $prod_rubro = array();
         foreach ($ids_prod_unique as $j => $v) :
            //print_r($v); echo '<br>';
            $pro[$j] = array_filter($rub[$key_rubro], function ($row) use ($v){
               return $row['id_prod'] == $v;
            });
            /* $subtotal = 0; */
            $index = 0;
            /* $cantidad = 0; */
            $p = '';
            /* $u = ''; */
            $ranchos = array();
            foreach ($pro[$j] as $l => $val) :
               array_push($ranchos, $val['subrancho']);
               //print_r($val); echo '<br>';
               if ($index == 0): 
                  //echo $index. '----'. $val['id_prod']. '____|____' . $val['nom_prod']. '____|'.$val['cantidad']*$val['precio_compra'] .'|____' . $val['cantidad']. '____|____' . $val['precio_compra'] . '____|____' .$val['fecha_movto']. '____|____' .$val['unidad_medida'] . '<br>';
                  //echo $val['nom_prod'] .'<br>'; 
                  $p = $val['nom_prod'];
                  /* $u = $val['unidad_medida']; */
               endif;
               /* $subtotal += $val['cantidad']*$val['precio_compra'];
               $cantidad += $val['cantidad']; */
               $index++;
               endforeach;
               $ranchos_unique = array_unique($ranchos, SORT_STRING);     
               $ranc_prod = array();          
               /* array_push($prod_rubro, array('p'=>$p, 'subtotal'=>$subtotal, 'cantidad'=>$cantidad, 'u'=>$u)); */
            foreach ($ranchos_unique as $n => $value) :
               $pro_rancho[$n] = array_filter($pro[$j], function ($row) use ($value){
                  return $row['subrancho'] == $value;
               });
               $r = '';
               $index_r = 0;
               $sectores = array();
               foreach ($pro_rancho[$n] as $k_r => $val_r) :
                  array_push($sectores, $val_r['nombre']);
                  if ($index_r == 0): 
                     //echo '--ID=> '. $val_r['id_prod']. '____|--Nombre=> ' . $val_r['nom_prod']. '____|--Subtotal=> '.$val_r['cantidad']*$val_r['precio_compra'] .'|___Cantidad=> ' . $val_r['cantidad']. '____|--Precio=> ' . $val_r['precio_compra'] . '____|--Fecha=> ' .$val_r['fecha_movto']. '____|--Unidad=> ' .$val_r['unidad_medida'] . '____|--Subrancho=> '. $val_r['subrancho']. '____|--Sector=> '.$val_r['nombre']. '<br>';
                     $r = $val_r['subrancho'];
                  endif;
                  $index_r++;
                  /* echo $val['nom_prod'] .'<br>';  */
                  /* print_r($val_r);echo '<br>'; */
                  endforeach;
                  $sectores_unique = array_unique($sectores, SORT_STRING);
                  $sect_prod = array();          
               foreach ($sectores_unique as $o => $value) :
                  $ran_sect[$o] = array_filter($pro[$j], function ($row) use ($value){
                     return $row['nombre'] == $value;
                  });
                  $s = '';
                  $hec = 0;
                  $index_s = 0;
                  $subtotal_sec = 0;
                  $cantidad_sec = 0;
                  foreach ($ran_sect[$o] as $k_s => $val_s) :
                     if ($index_s == 0): 
                        //echo '--ID=> '. $val_s['id_prod']. '____|--Nombre=> ' . $val_s['nom_prod']. '____|--Subtotal=> '.$val_s['cantidad']*$val_s['precio_compra'] .'|___Cantidad=> ' . $val_s['cantidad']. '____|--Precio=> ' . $val_s['precio_compra'] . '____|--Fecha=> ' .$val_s['fecha_movto']. '____|--Unidad=> ' .$val_s['unidad_medida'] . '____|--Subrancho=> '. $val_s['subrancho']. '____|--Sector=> '.$val_s['nombre']. '<br>';
                        $s = $val_s['nombre'];
                        $hec = $val_s['hectareas'];
                        $u_sec = $val_s['unidad_medida'];
                     endif;
                     $subtotal_sec += $val_s['cantidad']*$val_s['precio_compra'];
                     $cantidad_sec += $val_s['cantidad'];
                     $index_s++;
                     endforeach;
                     $costo_hec = $subtotal_sec/$hec;
                     array_push($sect_prod, array('s'=>$s, 'subt_sec'=>$subtotal_sec, 'cost_h'=>$costo_hec, 'cant_s'=>$cantidad_sec, 'u'=>$u_sec ));
                  endforeach;
                  //echo 'termina rancho'.$value.'<br>';
                  array_push($ranc_prod, array('sect_prod'=>$sect_prod, 'r'=>$r));
               endforeach;

               //echo 'subtotal= '.$subtotal.'<br>cantidad = '. $cantidad.'<br>';
               //echo 'termina prod' . $val['id_prod'] . '<br>';
               array_push($prod_rubro, array('p'=>$p, 'ranc_prod'=>$ranc_prod));
            endforeach;
            //print_r($pro); echo 'termina rubro <br><br>';
            //print_r($prod_rubro);

            //echo 'termina rubro ' . $value_rubro .'<br><br>';
            array_push($data1, array('rubro'=> $rubros[$key_rubro], 'total'=> $tot[$key_rubro], 'productos' => $prod_rubro));
         endforeach;

   // Response
   $response = array(
      "draw" => 1,
     //  "iTotalRecords" => $totalRecords,
      // "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $data1
   );

   echo json_encode($response);