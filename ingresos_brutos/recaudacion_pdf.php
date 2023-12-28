<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");
error_reporting(E_ERROR);
require("../list/header_listado.php"); 
////
//$db->debug=true;
//print_r($_GET); 

$variables=array();
$periodo= (isset($_GET['periodo'])) ? $_GET['periodo'] : '-1';

if (isset($_GET['periodo']) && $_GET['periodo']!=-1) {
			$periodo = $_GET['periodo'];
			$condicion_periodo = "and r.periodo in ($periodo)";
	} else {
		$condicion_periodo = "";
	}

try { $rs = $db->Execute("SELECT r.periodo, r.comision, r.cuit, R.SUC_BAN, R.NRO_AGEN
						FROM IMPUESTOS.t_recaudacion r
						where 1=1
						$condicion_periodo
						order by r.periodo desc,r.comision desc, R.SUC_BAN, R.NRO_AGEN");}
catch  (exception $e)	{ 	die($db->ErrorMsg());	}

$titulo='RECAUDACION';

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
			$pdf->Cell(30,8,'CUIT',1,0,'C',1);
			$pdf->Cell(30,8,'COMISION',1,0,'C',1);
			$pdf->Cell(30,8,'PERIODO',1,0,'C',1);
			$pdf->Cell(30,8,'AGENCIA',1,0,'C',1);
			$pdf->Cell(30,8,'PORCENTAJE',1,1,'C',1);
			} else {
			$pri='NO';
			}
} 
	
$y_line=$pdf->GetY(); 
$pdf->SetFillColor(240,240,240);	
$pdf->SetFont('Arial','',8);

while ($row = $rs->FetchNextObject($toupper=true)) {
		
		$fecha = '01/01/'.$row->PERIODO; 
		try{ $rs1= $db->Execute("SELECT impuestos.F_ING_BRUTOS(1,to_date('$fecha','dd/mm/yyyy'),$row->CUIT) as porcentaje FROM DUAL");}
		catch(exception $e){die($db->ErrorMsg());}
		$row_porcentaje = $rs1->FetchNextObject($toupper=true);
		
		$cant=$cant+1;
		$pdf->Cell(20,6,'',0,0,'C');
		$pdf->Cell(30,6,$row->CUIT,0,0,'C');
		$pdf->Cell(30,6,number_format($row->COMISION,2,',','.'),0,0,'R');
		$pdf->Cell(30,6,$row->PERIODO,0,0,'C');
		$pdf->Cell(30,6,str_pad($row->SUC_BAN,2,'0',STR_PAD_LEFT).' - '. str_pad($row->NRO_AGEN,4,'0',STR_PAD_LEFT),0,0,'C');
		$pdf->Cell(30,6,number_format($row_porcentaje->PORCENTAJE,2,',','.').' %',0,1,'R');
	
	$y_line=$pdf->GetY();
	$salto_pagina=number_format($y_line,0,'.',',');
	
	if ($salto_pagina > 270) 
		{
		$salto_pagina=0;
		if ($pri=='NO')
			{
			$pdf->SetFillColor(194,194,194);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(20,6,'',0,0,'C');
			$pdf->Cell(30,8,'CUIT',1,0,'C',1);
			$pdf->Cell(30,8,'COMISION',1,0,'C',1);
			$pdf->Cell(30,8,'PERIODO',1,0,'C',1);
			$pdf->Cell(30,8,'AGENCIA',1,0,'C',1);
			$pdf->Cell(30,8,'PORCENTAJE',1,1,'C',1);	 
			} else {
				$pri='NO';
			}
		}	
}
$pdf->Output();							
?> 