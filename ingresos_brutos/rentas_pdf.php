<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");
error_reporting(E_ERROR);
require("../list/header_listado.php"); 
/////
// $db->debug=true;
//print_r($_GET); 

if (isset($_POST['periodo']) && $_POST['periodo']!='-1') {
	$periodo = $_POST['periodo'];
	$condicion_periodo = "and rM.periodo in ($periodo)";
} else if (isset($_GET['periodo']) && $_GET['periodo']!='-1') {
	$periodo = $_GET['periodo'];
	$condicion_periodo = "and rM.periodo in ($periodo)";
} else {
	$condicion_periodo = "";
}

if (isset($_POST['suc_ban']) && $_POST['suc_ban']!='0') {
			$suc_ban = $_POST['suc_ban'];
			$condicion_suc_ban = "and X.suc_ban in ($suc_ban)";
} else if (isset($_GET['suc_ban']) && $_GET['suc_ban']!='0') {
			$suc_ban = $_GET['suc_ban'];
			$condicion_suc_ban = "and X.suc_ban in ($suc_ban)";
} else {
	//$suc_ban = $_SESSION['suc_ban'];
	$condicion_suc_ban="";	
}

if (isset($_POST['nro_agen']) && $_POST['nro_agen']!='0') {
			$nro_agen = $_POST['nro_agen'];
			$condicion_nro_agen = "and X.nro_agen in ($nro_agen)";
} else if (isset($_GET['nro_agen']) && $_GET['nro_agen']!='0') {
			$nro_agen = $_GET['nro_agen'];
			$condicion_nro_agen = "and X.nro_agen in ($nro_agen)";
} else {
		$condicion_nro_agen = "";
}


try { $rs = $db->Execute("SELECT RM.PERIODO,
					  RM.CUIT,
					  X.SUC_BAN,
					  (S.NOMBRE ) AS sucursal,
					  X.NRO_AGEN,
					  (B.APELLIDO
					  ||' '
					  ||B.NOMBRE) AS AGENCIA
					FROM IMPUESTOS.T_DGR_REPORTE_MENSUAL RM,
					  JUEGOS.PERSAGEN X,
					  JUEGOS.PERSONA B,
					  JUEGOS.SUCURSAL S
					WHERE 1               = 1
					AND b.tipo_doc        = x.tipo_doc
					AND b.nro_doc         = x.nro_doc
					AND NVL(X.TIT_CC,'S') ='S'
					AND X.TIPO_REL        = 'TIT'
					AND RM.CUIT           = B.CUIT
					AND S.SUC_BAN         = X.SUC_BAN
         			$condicion_periodo
					$condicion_suc_ban
					$condicion_nro_agen 
					$condicion_recien_entro
		   ORDER BY RM.PERIODO, X.SUC_BAN, X.NRO_AGEN,
		  	        RM.CUIT, B.CUIT,B.APELLIDO,B.NOMBRE");
}catch  (exception $e)	{ 	die($db->ErrorMsg());	}

$titulo='SUJETOS NO PASIBLES DE PERCEPCION INCISO E ART. 195 DECRETO 1205/15';

$pdf=new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
		
$pdf->SetFont('Arial','',7);

$salto_pagina=275;
$pri='NO';
$x= 10;
$contar_agencias=0;

if ($salto_pagina > 270) {
		$salto_pagina=0;
		if ($pri=='NO'){
			$pdf->SetFillColor(176,176,176);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(10,8,'',0,0,'C');
			$pdf->Cell(40,8,'SUCURSAL',1,0,'C',1);
			$pdf->Cell(90,8,'AGENCIA',1,0,'C',1);
			$pdf->Cell(25,8,'CUIT',1,0,'C',1);
			$pdf->Cell(20,8,'PERIODO',1,1,'C',1);	 
 
			} else {
			$pri='NO';
			}
} 
	
$y_line=$pdf->GetY(); 
$pdf->SetFillColor(240,240,240);	
$pdf->SetFont('Arial','',8);
 
while ($row_resul = $rs->FetchNextObject($toupper=true)) {
		$cant=$cant+1;
		$pdf->Cell(10,6,'',0,0,'C');
		$pdf->Cell(40,6,str_pad($row_resul->SUC_BAN, 2, "0",STR_PAD_LEFT).' - '.$row_resul->SUCURSAL,0,0,'L');
		$pdf->Cell(90,6,str_pad($row_resul->NRO_AGEN, 4, "0",STR_PAD_LEFT).' - '.$row_resul->AGENCIA,0,0,'L');
		$pdf->Cell(25,6,$row_resul->CUIT,0,0,'C');
		$pdf->Cell(20,6,$row_resul->PERIODO,0,1,'C');
		$contar_agencias++;
		 
		$y_line=$pdf->GetY();
		$salto_pagina=number_format($y_line,0,'.',',');
	
		if ($salto_pagina > 270) {
				$salto_pagina=0;
				if ($pri=='NO'){
					$pdf->SetFillColor(194,194,194);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(10,8,'',0,0,'C');
					$pdf->Cell(40,8,'SUCURSAL',1,0,'C',1);
			$pdf->Cell(90,8,'AGENCIA',1,0,'C',1);
			$pdf->Cell(25,8,'CUIT',1,0,'C',1);
			$pdf->Cell(20,8,'PERIODO',1,1,'C',1);	 
				} else {
					$pri='NO';
				}
		}	
}
$pdf->Cell(200,6,'',0,1,'C');
$pdf->Cell(10,6,'',0,0,'C');
$pdf->Cell(175,6,'Cantidad Agencias: '.$contar_agencias,1,1,'C');
$pdf->Output();?> 