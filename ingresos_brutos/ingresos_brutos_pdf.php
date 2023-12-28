<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");
error_reporting(E_ERROR);
require("../list/header_listado.php"); 
/////
//$db->debug=true;
//print_r($_GET); 

$periodo= (isset($_GET['periodo'])) ? $_GET['periodo'] : '-1';
$id_provincia= (isset($_GET['id_provincia'])) ? $_GET['id_provincia'] : '';

//if(!empty($periodo) && $periodo!='0'){
//	$periodo = " AND l.id_localidad = $periodo ";
//}

if (isset($_GET['periodo']) && $_GET['periodo']!=-1) {
				$periodo = $_GET['periodo'];
				$condicion_periodo = "and ib.periodo in ($periodo)";
	} else {
		$condicion_periodo = " AND 1=1 ";
}

if(!empty($id_provincia) && $id_provincia!='0'){
			$provincia = " AND ib.id_provincia = $id_provincia ";
	}else {
			$provincia = " AND 1=1 ";
}

if (isset($_GET['id_provincia']) && $_GET['id_provincia']!=0) {
	$id_provincia = $_GET['id_provincia'];
	$condicion_provincia = "and ib.id_provincia in ($id_provincia)";
	} else {
		$id_provincia = 0;
		$condicion_provincia = "";
}

try{	
	$rs_prov= $db->Execute("select id_provincia as codigo, descripcion 
                			from impuestos.t_provincias
							order by 2");
	}catch(exception $e){die($db->ErrorMsg());}


try{	
	$rs_periodo= $db->Execute(" SELECT distinct periodo as codigo, periodo as descripcion
								FROM IMPUESTOS.t_ing_bruto ib,
									 IMPUESTOS.t_provincias p
								WHERE ib.id_provincia = p.id_provincia
								$condicion_provincia 
								ORDER BY PERIODO DESC ");
	}catch(exception $e){die($db->ErrorMsg());}


try { $rs = $db->Execute("SELECT P.ID_PROVINCIA, P.DESCRIPCION, IB.PORCENTAJE, IB.TOPE_DESDE, IB.TOPE_HASTA, IB.PERIODO
				FROM IMPUESTOS.t_ing_bruto ib,
			     	 IMPUESTOS.t_provincias p
				WHERE ib.id_provincia = p.id_provincia
                  $condicion_provincia 
                  $condicion_periodo  
                order by IB.PERIODO desc");}
catch  (exception $e)	{ 	die($db->ErrorMsg());	}

$titulo='INGRESOS BRUTOS';

$pdf=new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
		
$pdf->SetFont('Arial','',7);

$salto_pagina=275;
$pri='NO';
$x= 10;

if ($salto_pagina > 270) {
		$salto_pagina=0;
		if ($pri=='NO'){
			$pdf->SetFillColor(176,176,176);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(20,8,'',0,0,'C');
			$pdf->Cell(50,8,'PROVINCIA',1,0,'C',1);
			$pdf->Cell(25,8,'PORCENTAJE',1,0,'C',1);
			$pdf->Cell(25,8,'TOPE DESDE',1,0,'C',1);
			$pdf->Cell(25,8,'TOPE HASTA',1,0,'C',1);
			$pdf->Cell(25,8,'PERIODO',1,1,'C',1);	 
			} else {
			$pri='NO';
			}
} 
	
$y_line=$pdf->GetY(); 
$pdf->SetFillColor(240,240,240);	
$pdf->SetFont('Arial','',8);

while ($row = $rs->FetchNextObject($toupper=true)) {
		$cant=$cant+1;
		$pdf->Cell(20,6,'',0,0,'C');
		$pdf->Cell(50,6,$row->DESCRIPCION,0,0,'L');
		$pdf->Cell(25,6,number_format($row->PORCENTAJE,2,',','.').' %',0,0,'R');
		$pdf->Cell(25,6,number_format($row->TOPE_DESDE,2,',','.'),0,0,'R');
		$pdf->Cell(25,6,number_format($row->TOPE_HASTA,2,',','.'),0,0,'R');
		$pdf->Cell(25,6,$row->PERIODO,0,1,'C');
	
	$y_line=$pdf->GetY();
	$salto_pagina=number_format($y_line,0,'.',',');
	
	if ($salto_pagina > 270) 
		{
		$salto_pagina=0;
		if ($pri=='NO')
			{
			$pdf->SetFillColor(194,194,194);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(20,8,'',0,0,'C');
			$pdf->Cell(50,8,'PROVINCIA',1,0,'C',1);
			$pdf->Cell(25,8,'PORCENTAJE',1,0,'C',1);
			$pdf->Cell(25,8,'TOPE DESDE',1,0,'C',1);
			$pdf->Cell(25,8,'TOPE HASTA',1,0,'C',1);
			$pdf->Cell(25,8,'PERIODO',1,1,'C',1);	 
			} else {
				$pri='NO';
			}
		}	
}
$pdf->Output();							
?> 