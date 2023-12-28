<?php
session_start();
include("db_conecta_adodb.inc.php");
$db->true;
try {
	$db->Execute("insert into impuestos.mep9505 (id_mep,concepto,quincena, mes,anio,fechamep,monto,recargo) 
	values (?,?,?,?,?,to_date(?,'DD/MM/YYYY'),?,?)",array($_POST['id_mep'],$_POST['concepto'],$_POST['quincena'],$_POST['mes'],$_POST['anio'],$_POST['fecha'],$_POST['monto'],$_POST['recargo']));
	}
	catch  (exception $e) 
	{ 
	die($db->ErrorMsg());
	}
header("location: detalle_mep.php");
?>  	