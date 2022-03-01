<?php
require 'phpspreadsheet/vendor/autoload.php';
/* include("conectar/conecta.php") ; */
include 'connection/connection.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$fechaI = $_POST['fechaI'];
$fechaF = $_POST['fechaF'];
$rubros = ['acido', 'agroquimico', 'ferreteria', 'fertilizante', 'infraestructura', 'inocuidad', 'mano de obra', 'maq. agricola', 'mat. fumigacion', 'mat. riego', 'otros', 'papeleria', 'servicios', 'vehiculos'];

$stmt = $conn->prepare("SELECT movtos_prod.id_prod, movtos_prod.clasificacion, movtos_prod.cantidad, movtos_prod.precio_compra, movtos_prod.fecha_movto , movtos_prod.nom_prod, movtos_prod.subrancho, movtos_prod.sector, producto.unidad_medida, sector.hectareas, sector.nombre from movtos_prod, producto, sector WHERE movtos_prod.id_prod = producto.id_prod AND (movtos_prod.tipo = 'S') AND (sector.nombre = movtos_prod.sector) AND (movtos_prod.fecha_movto BETWEEN :fechaI AND :fechaF)");
$stmt->bindParam(':fechaI', $fechaI, PDO::PARAM_STR);
$stmt->bindParam(':fechaF', $fechaF, PDO::PARAM_STR);
$stmt->execute();
$data = $stmt->fetchAll();

$data1 = array();
$total_salidas = 0;


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
        $total_salidas += $tot[$key_rubro];
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
           //print_r($ranchos_unique); print_r($v);
           $ranc_prod = array();     
        foreach ($ranchos_unique as $n => $value) :
           $pro_rancho[$n] = array_filter($pro[$j], function ($row) use ($value){
              return $row['subrancho'] == $value;
           });
           $sec_rancho[$n] = array_filter($data, function ($row) use ($value){
              return $row['subrancho'] == $value;
           });
           $todos_sectores = array();
           foreach ($sec_rancho[$n] as $x => $val_x) :
              array_push($todos_sectores, $val_x['nombre']);
              endforeach;
              $todos_sectores_unique = array_unique($todos_sectores, SORT_STRING);  
              //print_r($todos_sectores_unique);
           $sub_hh = 0;
           foreach ($todos_sectores_unique as $y => $value_y) :
              $ran_sect_t[$y] = array_filter($sec_rancho[$n], function ($row) use ($value_y){
                 return $row['nombre'] == $value_y;
              }); 
              $sub_hh += current($ran_sect_t[$y])['hectareas'];
           endforeach;

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
              $total_sec_cant = 0;         
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
                 $total_sec_cant += $cantidad_sec;
                 /* $total_sec_hec += $costo_hec; */
                 /* $total_ha = $value_o; */
                 array_push($sect_prod, array('s'=>$s, 'subt_sec'=>$subtotal_sec, 'cost_h'=>$costo_hec, 'cant_s'=>$cantidad_sec, 'u'=>$u_sec ));
              endforeach;
              //array_push($ranc_prod, array('sect_prod'=>$sect_prod, 'r'=>$r, 'total_s'=>$total_sec, 'total_h'=>$total_sec_hec, 'total_c'=>$total_sec_cant));
              $cos_ha = $total_sec/$sub_hh;
              array_push($ranc_prod, array('sect_prod'=>$sect_prod, 'r'=>$r, 'total_s'=>$total_sec, 'total_h'=>$cos_ha, 'total_c'=>$total_sec_cant));
           endforeach;

           array_push($prod_rubro, array('p'=>$p, 'ranc_prod'=>$ranc_prod));
        endforeach;
        if ($tot[$key_rubro] > 0):
        array_push($data1, array('rubro'=> $rubros[$key_rubro], 'total'=> $tot[$key_rubro], 'productos' => $prod_rubro));
        endif;
     endforeach;


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$titulo = "Salidas" ;
$sheet->setTitle($titulo);
$fila = 1;

$sheet->setCellValue('A'.$fila, "SALIDAS") ;
$sheet->setCellValue('B'.$fila, $fechaI) ;
$sheet->setCellValue('C'.$fila, "---") ;
$sheet->setCellValue('D'.$fila, $fechaF) ;
$fila++;
$sheet->setCellValue('A'.$fila, "RUBRO") ;
$sheet->setCellValue('B'.$fila, "SUBTOTAL") ;
$sheet->setCellValue('C'.$fila, "PRODUCTO") ;
$sheet->setCellValue('D'.$fila, "RANCHO") ;
$sheet->setCellValue('E'.$fila, "CANTIDAD") ;
$sheet->setCellValue('F'.$fila, "UNIDAD") ;
$sheet->setCellValue('G'.$fila, "COSTO") ;
$sheet->setCellValue('H'.$fila, "COSTO POR HÉCTAREA") ;
$sheet->getStyle('A1:H1')->getFont()->setBold(true)->setSize(12);
$sheet->getStyle('A2:H2')->getFont()->setBold(true)->setSize(12);
$sheet->getStyle('A1:H1')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A2:H2')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00ac69');
$sheet->getStyle('A2:H2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00ac69');
$sheet->getStyle('A1:H1')->getFont()->getColor()->setRGB('FFFFFF');
$sheet->getStyle('A2:H2')->getFont()->getColor()->setRGB('FFFFFF');
$sheet->getStyle('G')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
$sheet->getStyle('B')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
$sheet->getStyle('H')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
/* $sheet->freezePane("A2") ; */
$fila++;
foreach ($data1 as $rubro):
if ($rubro['total'] > 0):
        $sheet->getStyle('A'.$fila.':H'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DAF7A6');
        $sheet->setCellValue('A'.$fila, strtoupper($rubro['rubro']));
        $sheet->setCellValue('B'.$fila, $rubro['total']);
        $fila++ ;
        foreach ($rubro['productos'] as $producto):
            $sheet->setCellValue('C'.$fila, strtoupper($producto['p']));            
            $fila++;
            foreach ($producto['ranc_prod'] as $rancho):
                $sheet->setCellValue('D'.$fila, strtoupper($rancho['r']));
                $sheet->getStyle('E'.$fila)->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('E'.$fila, $rancho['total_c']);
                $sheet->setCellValue('F'.$fila, strtoupper($rancho['sect_prod'][0]['u']));
                $sheet->setCellValue('G'.$fila, $rancho['total_s']);
                $sheet->setCellValue('H'.$fila, $rancho['total_h']);
                $fila++;
                endforeach;
        endforeach;
    endif;
    endforeach;
$sheet->getStyle('F'.$fila.':G'.$fila)->getFont()->setBold(true)->setSize(12);
$sheet->getStyle('F'.$fila.':G'.$fila)->getFont()->getColor()->setRGB('FFFFFF');
$sheet->getStyle('F'.$fila.':G'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00ac69');

$sheet->setCellValue('F'.$fila, 'TOTAL: ');
$sheet->setCellValue('G'.$fila, $total_salidas);
$sheet->getColumnDimension("A")->setAutoSize(true);
$sheet->getColumnDimension("B")->setAutoSize(true);
$sheet->getColumnDimension("C")->setAutoSize(true);
$sheet->getColumnDimension("D")->setAutoSize(true);
$sheet->getColumnDimension("E")->setAutoSize(true);
$sheet->getColumnDimension("F")->setAutoSize(true);
$sheet->getColumnDimension("G")->setAutoSize(true);
$sheet->getColumnDimension("H")->setAutoSize(true);


$filename = 'salidas.xlsx' ;
	ob_clean();
	$writer = new Xlsx($spreadsheet);
    $writer->save($filename);
    
    echo $filename;

?>