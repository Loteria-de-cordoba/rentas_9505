<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");
error_reporting(E_ALL);
ini_set("display_errors",1);
//;die();
//$db->debug=true;
//print_r($_POST);


$id_provincia = $_POST['id_provincia'];
$desde= $_POST['desde'];
$hasta= $_POST['hasta'];
$porcentaje= $_POST['porcentaje'];
$periodo = $_POST['periodo'];


ComenzarTransaccion($db);

try {
	$rs = $db->Execute("select impuestos.sec_ing_bruto.nextval as secuencia from dual");

}catch (exception $e){die ($db->ErrorMsg()); }	
$row = $rs->FetchNextObject($toupper=true);
$secuencia = $row->SECUENCIA;
	
	
try {
	$db->Execute("insert into IMPUESTOS.t_ing_bruto(ID_ING_BRUTO,PORCENTAJE,ID_PROVINCIA,TOPE_DESDE,TOPE_HASTA,PERIODO) 
				  values (?,?,?,?,?,?)",array($secuencia,$porcentaje,$id_provincia,$desde,$hasta,$periodo));
}catch (exception $e) {die ($db->ErrorMsg()); }

	
FinalizarTransaccion($db);
header("location: abm_ingresos_brutos.php"); ?>
