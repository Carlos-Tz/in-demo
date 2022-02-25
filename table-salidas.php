<?php
   // Database Connection
   include 'connection/connection.php';
   $fechaI = $_POST['fechaI'];
   $fechaF = $_POST['fechaF'];

   $rubros = ['acido', 'agroquimico', 'ferreteria', 'fertilizante', 'infraestructura', 'inocuidad', 'mano de obra', 'maq. agricola', 'mat. fumigacion', 'mat. riego', 'otros', 'papeleria', 'servicios', 'vehiculos'];

   
   $stmt = $conn->prepare("SELECT movtos_prod.id_prod, movtos_prod.clasificacion, movtos_prod.cantidad, movtos_prod.precio_compra, movtos_prod.fecha_movto , movtos_prod.nom_prod, movtos_prod.subrancho, movtos_prod.sector, producto.unidad_medida, sector.hectareas, sector.nombre from movtos_prod, producto, sector WHERE movtos_prod.id_prod = producto.id_prod AND (movtos_prod.tipo = 'S') AND (sector.nombre = movtos_prod.sector) AND (movtos_prod.fecha_movto BETWEEN :fechaI AND :fechaF)");
   $stmt->bindParam(':fechaI', $fechaI, PDO::PARAM_STR);
   $stmt->bindParam(':fechaF', $fechaF, PDO::PARAM_STR);
   $stmt->execute();
   $data = $stmt->fetchAll();

   $data1 = array();


   foreach ($rubros as $key_rubro => $value_rubro) :
        $rub[$key_rubro] = array_filter($data, function ($row) use ($value_rubro) {
            return strtolower($row['clasificacion']) == $value_rubro;
        });
        $tot[$key_rubro] = 0;
        $ids_prod_all = array();
        foreach ($rub[$key_rubro] as $j => $v) :
            $tot[$key_rubro] += $v['precio_compra']*$v['cantidad'];
            array_push($ids_prod_all, $v['id_prod']);
            endforeach;
            $ids_prod_unique = array_unique($ids_prod_all, SORT_STRING);
            $prod_rubro = array();
         foreach ($ids_prod_unique as $j => $v) :
            $pro[$j] = array_filter($rub[$key_rubro], function ($row) use ($v){
               return $row['id_prod'] == $v;
            });
            $index = 0;
            $p = '';
            $ranchos = array();
            foreach ($pro[$j] as $l => $val) :
               array_push($ranchos, $val['subrancho']);
               if ($index == 0): 
                  $p = $val['nom_prod'];
               endif;
               $index++;
               endforeach;
               $ranchos_unique = array_unique($ranchos, SORT_STRING);     
               $ranc_prod = array();          
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
                     $r = $val_r['subrancho'];
                  endif;
                  $index_r++;
                  endforeach;
                  $sectores_unique = array_unique($sectores, SORT_STRING);  
                  $sect_prod = array(); 
                  $total_sec = 0;         
                  $total_sec_hec = 0;         
               foreach ($sectores_unique as $o => $value_o) :
                  $ran_sect[$o] = array_filter($pro_rancho[$n], function ($row) use ($value_o){
                     return $row['nombre'] == $value_o;
                  });
                  $s = '';
                  $hec = 0;
                  $index_s = 0;
                  $subtotal_sec = 0;
                  $cantidad_sec = 0;
                  foreach ($ran_sect[$o] as $k_s => $val_s) :
                     if ($index_s == 0): 
                        $s = $val_s['nombre'];
                        $hec = $val_s['hectareas'];
                        $u_sec = $val_s['unidad_medida'];
                     endif;
                     $subtotal_sec += $val_s['cantidad']*$val_s['precio_compra'];
                     $cantidad_sec += $val_s['cantidad']; /* echo $cantidad_sec. '<br>'; print_r($val_s); */
                     $index_s++;
                     endforeach;
                     $costo_hec = $subtotal_sec/$hec;
                     $total_sec += $subtotal_sec;
                     $total_sec_hec += $costo_hec;
                     array_push($sect_prod, array('s'=>$s, 'subt_sec'=>$subtotal_sec, 'cost_h'=>$costo_hec, 'cant_s'=>$cantidad_sec, 'u'=>$u_sec ));
                  endforeach;
                  array_push($ranc_prod, array('sect_prod'=>$sect_prod, 'r'=>$r, 'total_s'=>$total_sec, 'total_h'=>$total_sec_hec));
               endforeach;

               array_push($prod_rubro, array('p'=>$p, 'ranc_prod'=>$ranc_prod));
            endforeach;

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