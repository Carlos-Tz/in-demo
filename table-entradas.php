<?php
   // Database Connection
   include 'connection/connection.php';

   $fechaI = $_POST['fechaI'];
   $fechaF = $_POST['fechaF'];

   $rubros = ['acido', 'agroquimico', 'ferreteria', 'fertilizante', 'infraestructura', 'inocuidad', 'mano de obra', 'maq. agricola', 'mat. fumigacion', 'mat. riego', 'otros', 'papeleria', 'servicios', 'vehiculos'];

   $stmt = $conn->prepare("SELECT movtos_prod.id_prod, movtos_prod.clasificacion, movtos_prod.cantidad, movtos_prod.precio_compra, movtos_prod.fecha_movto , movtos_prod.nom_prod, producto.unidad_medida from movtos_prod, producto WHERE movtos_prod.id_prod = producto.id_prod AND (movtos_prod.tipo = 'E') AND (movtos_prod.fecha_movto BETWEEN :fechaI AND :fechaF)");
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
            $subtotal = 0;
            $index = 0;
            $cantidad = 0;
            $p = '';
            $u = '';
            foreach ($pro[$j] as $l => $val) :
                  if ($index == 0): 
                     $p = $val['nom_prod'];
                     $u = $val['unidad_medida'];
                  endif;
                  $subtotal += $val['cantidad']*$val['precio_compra'];
                  $cantidad += $val['cantidad'];
                  $index++;
               endforeach;
               array_push($prod_rubro, array('p'=>$p, 'subtotal'=>$subtotal, 'cantidad'=>$cantidad, 'u'=>$u));               

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