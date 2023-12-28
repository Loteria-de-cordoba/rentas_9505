<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");
error_reporting(E_ERROR);
require("../list/header_listado.php"); 
/////
//$db->debug=true;
//print_r($_GET); 
//print_r($_POST); 

$suc_ban= (isset($_POST['suc_ban'])) ? $_POST['suc_ban'] : '-1';
$nro_agen= (isset($_POST['nro_agen'])) ? $_POST['nro_agen'] : '-1';
$cuit= (isset($_POST['cuit'])) ? $_POST['cuit'] : '-1';

if (isset($_POST['fecha_desde']))
{
			$fecha_desde = $_POST['fecha_desde'];
			$fecha_hasta = $_POST['fecha_hasta'];
}
 else if (isset($_GET['fecha_desde']) && $_GET['fecha_desde']!="") {
			$fecha_desde = $_GET['fecha_desde'];
			$fecha_hasta = $_GET['fecha_hasta'];
} else {
			$array_fecha = FechaServer();
	  		$fecha_desde = str_pad($array_fecha["mday"],2,'0',STR_PAD_LEFT).'/'.str_pad($array_fecha["mon"],2,'0',STR_PAD_LEFT).'/'.$array_fecha["year"];
	  		$fecha_hasta = str_pad($array_fecha["mday"],2,'0',STR_PAD_LEFT).'/'.str_pad($array_fecha["mon"],2,'0',STR_PAD_LEFT).'/'.$array_fecha["year"];
}
		


$comision=0;


if (isset($_POST['suc_ban']) && $_POST['suc_ban']!='-1') {
			$suc_ban = $_POST['suc_ban'];
			$condicion_sucursal = "and md.suc_ban in ($suc_ban)";
			 
	} else if (isset($_GET['suc_ban']) && $_GET['suc_ban']!='-1') {
			$suc_ban = $_GET['suc_ban'];
			$condicion_sucursal = "and md.suc_ban in ($suc_ban)";
	} else {	
		$condicion_suc_ban = "";
		$condicion_sucursal = "";
	}
	

if (isset($_POST['nro_agen']) && $_POST['nro_agen']!='-1') {
			$nro_agen = $_POST['nro_agen'];
			$condicion_nro_agen = "and md.nro_agen in ($nro_agen)";
	} else if (isset($_GET['nro_agen']) && $_GET['nro_agen']!='-1') {
			$nro_agen = $_GET['nro_agen'];
			$condicion_nro_agen = "and md.nro_agen in ($nro_agen)";
	} else {
		$condicion_nro_agen = "";
	}

if (isset($_POST['cuit']) && $_POST['cuit']!='-1') {
			$cuit = $_POST['cuit'];
			$condicion_cuit = "and cuit in ($cuit)";
	} else if (isset($_GET['cuit']) && $_GET['nro_agen']!='-1') {
			$cuit = $_GET['cuit'];
			$condicion_cuit = "and cuit in ($cuit)";
	} else {
		$condicion_cuit = "";
	}
	
	
try{	
	$rs_sucursal= $db->Execute(" select NOMBRE AS DESCRIPCION
								  from  juegos.sucursal MD
								  WHERE 1=1
								  $condicion_sucursal
								  ");
	}catch(exception $e){die($db->ErrorMsg());}
	
$row = $rs_sucursal->FetchNextObject($toupper=true);
 if ($rs_sucursal->RecordCount() > 1)
  { 
	 $titulo2= " DE TODAS LAS DELEGACIONES ";
} else {
	
	$titulo2= " DE LA DELEGACION ".$row->DESCRIPCION;
}


$variables[0]=$fecha_desde;
$variables[1]=$fecha_hasta; //array de variables bind

 /*try {
	
	 $rs= $db->Execute("SELECT SUM(debe - haber)*-1 AS comision,
					  md.suc_ban ,
					  md.nro_agen,
					  r.nombre AS agencia,
					  s.nombre AS sucursal
				   FROM
					  kaizen.movimiento_cabecera mc,
					  kaizen.movimiento_detalle md,
					  JUEGOS.AGENCIA R,
					  juegos.sucursal s
					where mc.cod_movimiento_cabecera = md.cod_movimiento_cabecera
					and md.cod_concepto in (2,122)
					and mc.fecha_valor between to_date(?,'dd/mm/yyyy') and to_date(?,'dd/mm/yyyy')
					  $condicion_sucursal
					  $condicion_nro_agen
					 AND R.SUC_BAN  = MD.SUC_BAN
					 AND R.NRO_AGEN = MD.NRO_AGEN
					 AND s.suc_ban  = md.suc_ban	
					GROUP BY md.suc_ban, md.nro_agen, r.nombre, s.nombre 
					order by md.suc_ban, md.nro_agen, r.nombre, s.nombre",array($fecha_desde,$fecha_hasta));
					
					
		}		catch (exception $e){	die ($db->ErrorMsg()); 	}*/	
		
		
		
try {$rs= $db->Execute("SELECT SUM(debe - haber)*-1 AS comision,
						  md.suc_ban ,
						  md.nro_agen,
						  r.nombre AS agencia,
						  s.nombre AS sucursal, 
						  to_char(mc.fecha_valor,'MONTH') as mes, 
						  to_char(mc.fecha_valor,'YYYY') as anio,
						  to_char(mc.fecha_valor,'MM') as mes_1,
			  			  to_char(p.fec_rel,'dd/mm/yyyy') as fecha_alta
						FROM kaizen.movimiento_cabecera mc,
						  kaizen.movimiento_detalle md,
						  JUEGOS.AGENCIA R,
						  juegos.sucursal s,
						 juegos.persagen p
						WHERE mc.cod_movimiento_cabecera = md.cod_movimiento_cabecera
						AND md.cod_concepto             IN (2,122)
						AND mc.fecha_valor BETWEEN to_date(?,'dd/mm/yyyy') AND to_date(?,'dd/mm/yyyy')
						$condicion_sucursal
						$condicion_nro_agen
						
						AND R.SUC_BAN   = MD.SUC_BAN
						AND R.NRO_AGEN  = MD.NRO_AGEN
						AND s.suc_ban   = md.suc_ban
						and P.SUC_BAN   = MD.SUC_BAN
									and P.NRO_AGEN  = MD.NRO_AGEN
									and p.tipo_rel = 'TIT'
									--and p.fec_rel <= mc.fecha_valor
						GROUP BY md.suc_ban, md.nro_agen, r.nombre, s.nombre, to_char(mc.fecha_valor,'MONTH'), to_char(mc.fecha_valor,'YYYY'), to_char(mc.fecha_valor,'MM'),p.fec_rel
						ORDER BY to_char(mc.fecha_valor,'YYYY'),  to_char(mc.fecha_valor,'MM'),md.suc_ban,  md.nro_agen,  r.nombre,  s.nombre",array($fecha_desde,$fecha_hasta));
					
					
		}		catch (exception $e){	die ($db->ErrorMsg()); 	}
					
while ($row_resul = $rs->FetchNextObject($toupper=true)){

$comision += $row_resul->COMISION;}

$rs->MoveFirst();

$titulo='INFORME  DE COMISIONES DESDE '.$fecha_desde.' HASTA '.$fecha_hasta;

$pdf=new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
		
$pdf->SetFont('Arial','',7);
$total_comision=0;
$salto_pagina=270;
$pri='NO';
$x= 10;

if ($salto_pagina > 265) {
		$salto_pagina=0;
		if ($pri=='NO'){
			$pdf->SetFillColor(170,170,170);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(5,8,'',0,0,'C');
			$pdf->Cell(25,8,'CUIT',1,0,'C',1);
			$pdf->Cell(35,8,'SUCURSAL',1,0,'C',1);
			$pdf->Cell(65,8,'AGENCIA - (fecha alta)',1,0,'C',1);
			$pdf->Cell(20,8,'MES',1,0,'C',1);
			$pdf->Cell(20,8,'AÑO',1,0,'C',1);
			$pdf->Cell(20,8,'COMISION',1,1,'C',1);	
			} else {
			$pri='NO';
			}
} 
	
$y_line=$pdf->GetY(); 
$pdf->SetFillColor(240,240,240);	
$pdf->SetFont('Arial','',7);

while ($row_resul = $rs->FetchNextObject($toupper=true)) {
		
	$cant=$cant+1;
		
     try {
	
	 $rs_cuit= $db->Execute("select JUEGOS.f_cuit(?,?,?) as cuit from dual",array($row_resul->SUC_BAN,$row_resul->NRO_AGEN,0));}
		
	 catch (exception $e){	die ($db->ErrorMsg()); 	}	

	 if ($rs_cuit->RecordCount() > 0)
	 			 {
			$row_cuit = $rs_cuit->FetchNextObject($toupper=true);
	  		$cuit = $row_cuit->CUIT;} 
	//echo 'mes'.	$row_resul->MES_1;
	switch ($row_resul->MES_1)
		{
		case 1:
		  $nombre_mes='ENERO';
		  break;
		case 2:
		  $nombre_mes='FEBRERO';
		  break;
		case 3:
		  $nombre_mes='MARZO';
		  break;
		case 4:
		  $nombre_mes='ABRIL';
		  break;
		case 5:
		  $nombre_mes='MAYO';
		  break;
		case 6:
		  $nombre_mes='JUNIO';
		  break;
		case 7:
		  $nombre_mes='JULIO';
		  break;
		case 8:
		  $nombre_mes='AGOSTO';
		  break;
		case 9:
		  $nombre_mes='SEPTIEMBRE';
		  break;
		case 10:
		  $nombre_mes='OCTUBRE';
		  break;
		case 11:
		  $nombre_mes='NOVIEMBRE';
		  break;
		case 12:
		  $nombre_mes='DICIEMBRE';
		  break;
		default:
		  $nombre_mes='S/P';
	}
		
		$pdf->Cell(5,6,'',0,0,'C');
		$pdf->Cell(25,6,$cuit,0,0,'C');
		$pdf->Cell(35,6,$row_resul->SUCURSAL,0,0,'L');
		$pdf->Cell(65,6,str_pad($row_resul->NRO_AGEN, 4, "0",STR_PAD_LEFT).' - '.$row_resul->AGENCIA.' ('.$row_resul->FECHA_ALTA.')',0,0,'L');
		$pdf->Cell(20,6,$nombre_mes,0,0,'L');
		$pdf->Cell(20,6,$row_resul->ANIO,0,0,'C');
		$pdf->Cell(20,8,number_format($row_resul->COMISION,2,',','.'),0,1,'R');
		  
	
	$y_line=$pdf->GetY();
	$salto_pagina=number_format($y_line,0,'.',',');
	
	if ($salto_pagina > 265) 
		{
		$salto_pagina=0;
		if ($pri=='NO')
			{
			$pdf->SetFillColor(170,170,170);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(5,8,'',0,0,'C');
			$pdf->Cell(25,8,'CUIT',1,0,'C',1);
			$pdf->Cell(35,8,'SUCURSAL',1,0,'C',1);
			$pdf->Cell(65,8,'AGENCIA - (fecha alta)',1,0,'C',1);
			$pdf->Cell(20,8,'MES',1,0,'C',1);
			$pdf->Cell(20,8,'AÑO',1,0,'C',1);
			$pdf->Cell(20,8,'COMISION',1,1,'C',1);	
			} else {
				$pri='NO';
			}
		}
		
}

$pdf->SetFont('Arial','BI',12);
$pdf->Cell(10,8,'',0,0,'C');
$pdf->Cell(130,8,'TOTAL COMISION : ',0,0,'R');
$pdf->Cell(30,8,number_format($comision,2,',','.') ,0,1,'R');	
$pdf->Output();							
?> 