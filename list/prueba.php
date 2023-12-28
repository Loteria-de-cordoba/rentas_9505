<?php
$titulo='INFORME';
require("header_listado.php"); 


try{
	
	 $rs = $db->Execute("select d.descripcion as des ,c.descripcion, concurso, sum(debe) as debe, sum(haber) as haber, sum(debe-haber) as saldo
 		from (select * from cuenta_corriente.movimiento_cabecera 
    	where cod_movimiento_cabecera in (Select min(cod_movimiento_cabecera) 
	                                   from cuenta_corriente.movimiento_cabecera 
	                                   where fecha_valor = to_date(?,'dd/mm/yyyy')
									   group by nro_liquidacion_bold)) a, cuenta_corriente.movimiento_detalle b, cuenta_corriente.juego c, cuenta_corriente.concepto d 
 	where a.cod_movimiento_cabecera = b.cod_movimiento_cabecera
 	and b.cod_juego = c.cod_juego
    and b.cod_concepto = d.cod_concepto
 	and suc_ban = ?
 	and a.activo = 'S'
 	and b.activo = 'S'
 	and fecha_valor = to_date(?,'dd/mm/yyyy')
 	group by d.descripcion,c.descripcion,concurso",array($_SESSION['fecha'],1,$_SESSION['fecha'])); 
	}
	catch(exception $e)
	{
	die($db->ErrorMsg());
	}
	


$pdf=new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,8,'',0,0);
$pdf->Cell(20,8,'Fecha',1,0,'C');
$pdf->Cell(25,8,'Juego',1,0,'C');
$pdf->Cell(20,8,'Concurso',1,0,'C');
$pdf->Cell(25,8,'Delegación',1,0,'C');
$pdf->Cell(30,8,'Concepto',1,0,'C');
$pdf->Cell(25,8,'Debe',1,0,'C');
$pdf->Cell(25,8,'Haber',1,1,'C');

		
$pdf->SetFont('Arial','',7);

while ($row = $rs->FetchNextObject($toupper=true)) {
	$pdf->Cell(10,7,'',0,0);
	$pdf->Cell(20,7,$_SESSION['fecha'],1,0,'R');
	$pdf->Cell(25,7,$row->DESCRIPCION,1,0,'R');
	$pdf->Cell(20,7,$row->CONCURSO,1,0,'R');
	$pdf->Cell(25,7,'1',1,0,'R');
	$pdf->Cell(30,7,$row->DES,1,0,'R');
	$pdf->Cell(25,7,number_format($row->DEBE,2,'.',','),1,0,'R');
	$debet += $row->DEBE;
	$pdf->Cell(25,7,number_format($row->HABER,2,'.',','),1,1,'R');
	$habert += $row->HABER;
	} 
$pdf->Cell(10,5,'',0,1);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,8,'',0,0);
$pdf->Cell(120,8,'TOTAL',1,0,'L');
$pdf->Cell(25,8,$debet,1,0,'R');
$pdf->Cell(25,8,$habert,1,1,'R');


//$y_line=$pdf->GetY();
//$pdf->Line(10,$y_line,200,$y_line);

$pdf->Output();
?>