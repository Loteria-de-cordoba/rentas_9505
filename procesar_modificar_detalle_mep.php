<?php
session_start();
include("db_conecta_adodb.inc.php");
try {
	$db->Execute("update impuestos.mep9505  set
	concepto = ?,
	quincena = ?,
	mes = ?,
	anio = ?,
	fechamep = to_date(?,'DD/MM/YYYY'),
	monto = ?,
	recargo = ?
	where id_mep = ?",
	array($_POST['concepto'],$_POST['quincena'],$_POST['mes'],$_POST['anio'],$_POST['fecha'],$_POST['monto'],$_POST['recargo'],$_POST['id_mep']));
	}
	catch  (exception $e) 
	{ 
	die($db->ErrorMsg());
	}
header("location: detalle_mep.php");
?>  	