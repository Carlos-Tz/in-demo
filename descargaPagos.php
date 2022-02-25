<?php
    include("../../../utils/sesion.php") ;
    include("../../../conectar/conecta.php") ;
    require '../../../phpspreadsheet/vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $f_inicial = mysqli_real_escape_string($connect, $_POST["fechaIni"]);
    $f_final = mysqli_real_escape_string($connect, $_POST["fechaFin"]);

	$sql = "SELECT * FROM pagos where fecha_programada BETWEEN '".$f_inicial."' AND '".$f_final."' order by id_requisicion, consecutivo" ;
	$orden = mysqli_query($connect, $sql);
	
	$sql2 = "select id_requisicion, consecutivo, fecha, monto, documento, folio, title as metodo_pago  from pagos_detalle, sys_catalog_payment_methods where pagos_detalle.metodo = sys_catalog_payment_methods.id order by id_requisicion, consecutivo" ;
	$detalle = mysqli_query($connect, $sql2);
	
	$spreadsheet = new Spreadsheet();
    
    $estado = 1 ;
    while ($estado <= 3) {
        $fila = 1 ;
        switch ($estado) {
            case 1:
                $sheet = $spreadsheet->getActiveSheet();
                $titulo = "Pagado" ;
	            $sheet->setTitle($titulo);
	            break;
	        case 2:
	            $sheet = $spreadsheet->createSheet();
	            $titulo = "Parcial" ;
	            $sheet->setTitle($titulo);
	            break;
	        case 3:
	            $sheet = $spreadsheet->createSheet();
	            $titulo = "Programado" ;
	            $sheet->setTitle($titulo);
	            break;
        }
        $sheet->setCellValue('A'.$fila, "ORDEN DE COMPRA") ;
	    $sheet->setCellValue('B'.$fila, "FECHA PROGRAMADA") ;
	    $sheet->setCellValue('C'.$fila, "RFC") ;
	    $sheet->setCellValue('D'.$fila, "PROVEEDOR") ;
	    $sheet->setCellValue('E'.$fila, "SUBTOTAL") ;
	    $sheet->setCellValue('F'.$fila, "IVA") ;
	    $sheet->setCellValue('G'.$fila, "TOTAL") ;
	    $sheet->setCellValue('H'.$fila, "SALDO") ;
	    $sheet->getStyle('A1:H1')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('009900');
        $sheet->getStyle('A1:H1')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('E:H')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        //$sheet->freezePaneByColumnAndRow(1,2) ;
        $sheet->freezePane("A2") ;
	    $fila++ ;
	    $vuelta = true ;
	    while($row = mysqli_fetch_array($orden)){
	        if($row["status"] == $titulo) {
	            if(!$vuelta) {
	                $sheet->getStyle('A'.$fila.':H'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DAF7A6');
	            }
        	    //$sheet->setCellValue('A'.$fila, $row["status"]);
        	    $sheet->setCellValue('A'.$fila, $row["id_requisicion"]." - ".$row["consecutivo"]);
        	    $sheet->setCellValue('B'.$fila, $row["fecha_programada"]);
        	    $sheet->setCellValue('C'.$fila, $row["rfc"]);
        	    $sheet->setCellValue('D'.$fila, $row["nom_prov"]);
        	    $sheet->setCellValue('E'.$fila, $row["subtotal"]);
        	    $sheet->setCellValue('F'.$fila, $row["iva"]);
        	    $sheet->setCellValue('G'.$fila, $row["total"]);
        	    $sheet->setCellValue('H'.$fila, $row["saldo"]);
        	    $sub_encabezado = true ;
                while($row2 = mysqli_fetch_array($detalle)){
                    if($row["id_requisicion"] == $row2["id_requisicion"] && $row["consecutivo"] == $row2["consecutivo"]){
                        if ($sub_encabezado){
                            $color = new \PhpOffice\PhpSpreadsheet\Style\Color('000000');
                            $sheet->getStyle('A'.$fila.':H'.$fila)->getBorders()->getTop()->setColor($color);
                            $sheet->getStyle('A'.$fila.':H'.$fila)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                            $fila++ ;
                            $sheet->setCellValue('B'.$fila, "FECHA DE PAGO") ;
                            $sheet->setCellValue('C'.$fila, "FOLIO") ;
                            $sheet->setCellValue('D'.$fila, "METODO DE PAGO") ;
                            $sheet->setCellValue('E'.$fila, "MONTO") ;
                            $sheet->setCellValue('F'.$fila, "DOCUMENTO") ;
                            $sheet->getStyle('B'.$fila.':F'.$fila)->getFont()->setBold(true)->setSize(11);
                            $sheet->getStyle('B'.$fila.':F'.$fila)->getAlignment()->setHorizontal('center');
                            $sheet->getStyle('B'.$fila.':F'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('33CC66');
                            $sheet->getStyle('B'.$fila.':F'.$fila)->getFont()->getColor()->setRGB('FFFFFF');
                        }
                        $fila ++ ;
                        //$sheet->setCellValue('B'.$fila, $row2["id_requisicion"]." - ".$row2["consecutivo"]);
        	            $sheet->setCellValue('B'.$fila, $row2["fecha"]);
        	            $sheet->setCellValue('C'.$fila, $row2["folio"]);
        	            $sheet->setCellValue('D'.$fila, $row2["metodo_pago"]);
        	            $sheet->setCellValue('E'.$fila, $row2["monto"]);
        	            $sheet->setCellValue('F'.$fila, $row2["documento"]);
        	            $sub_encabezado = false ;
                    }
                }
                if(!$sub_encabezado) {
                    $color = new \PhpOffice\PhpSpreadsheet\Style\Color('000000');
                    $sheet->getStyle('A'.$fila.':H'.$fila)->getBorders()->getBottom()->setColor($color);
                    $sheet->getStyle('A'.$fila.':H'.$fila)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
                    $sub_encabezado = true ;
                }
                mysqli_data_seek($detalle, 0);
                $fila++ ;
                $vuelta = !$vuelta ;
	        }
	    }
	    $sheet->getColumnDimension("A")->setAutoSize(true);
	    $sheet->getColumnDimension("B")->setAutoSize(true);
	    $sheet->getColumnDimension("C")->setAutoSize(true);
	    $sheet->getColumnDimension("D")->setAutoSize(true);
	    $sheet->getColumnDimension("E")->setAutoSize(true);
	    $sheet->getColumnDimension("F")->setAutoSize(true);
	    $sheet->getColumnDimension("G")->setAutoSize(true);
	    $sheet->getColumnDimension("H")->setAutoSize(true);
	    mysqli_data_seek($orden, 0);
	    $estado++ ;
    }

    //echo $sql."****".$sql2;

    $filename = 'cuentasXpagar.xlsx' ;
	ob_clean();
	$writer = new Xlsx($spreadsheet);
    $writer->save($filename);
    
    echo $filename;
?>