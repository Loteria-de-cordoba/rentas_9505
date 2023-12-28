<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

//print_r($_POST);die();
//$db->debug=true;

//die('iiiiiiiii');

$id_provincia = $_POST['id_provincia'];
$desde= $_POST['desde'];
$hasta= $_POST['hasta'];
$porcentaje= $_POST['porcentaje'];
$periodo = $_POST['periodo'];
$id_ing_bruto = $_POST['id_ing_bruto'];


ComenzarTransaccion($db);

try{	
	$rs = $db->Execute("update IMPUESTOS.t_ing_bruto 
							  	set porcentaje = $porcentaje,
							  		id_provincia = $id_provincia,
									tope_desde = $desde,
									tope_hasta= $hasta,
									periodo = $periodo	
							  
							   where id_ing_bruto = $id_ing_bruto");
	}
	catch(exception $e){die($db->ErrorMsg());
	}
	
FinalizarTransaccion($db);
header("location: abm_ingresos_brutos.php"); ?>
