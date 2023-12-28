<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

//print_r($_POST);die();
//$db->debug=true;

if (!empty($_POST['accion']))
	$accion = $_POST['accion'];
else
	$accion = $_GET['accion'];	
$id_provincia = $_POST['id_provincia'];
$desde= $_POST['desde'];
$hasta= $_POST['hasta'];
$porcentaje= $_POST['porcentaje'];
$periodo = $_POST['periodo'];
$imputa_desde = $_POST['imputa_desde'];
$minimo = $_POST['minimo'];
$cod_concepto =  $_POST['cod_concepto'];
if (!empty($_POST['id_retencion_ing_bruto']))
	$id_retencion_ing_bruto = $_POST['id_retencion_ing_bruto'];
else
	$id_retencion_ing_bruto = $_GET['id_retencion_ing_bruto'];
if (!empty($_POST['ddjj']))
	$ddjj=1;
else
	$ddjj=0;
//die($accion);

if ($accion=='alta'){
	ComenzarTransaccion($db);
		
					try {
						$db->Execute("CALL IMPUESTOS.PR_INS_RETENCION_ING_BRUTOS(?,?,?,?,?,?,?,to_date(?,'DD/MM/YYYY'),?)",array($cod_concepto,$id_provincia,$desde,$hasta,$periodo,$porcentaje,$minimo,$imputa_desde,$ddjj));
								}
								catch (exception $e) {die ($db->ErrorMsg()); }

		
	FinalizarTransaccion($db);
}
elseif($accion=='modificar'){
	ComenzarTransaccion($db);
		
					try {
						$db->Execute("CALL IMPUESTOS.PR_UPD_RETENCION_ING_BRUTOS(?,?,?,?,?,?,?,?,to_date(?,'DD/MM/YYYY'),?)",array($id_retencion_ing_bruto,$cod_concepto,$id_provincia,$desde,$hasta,$periodo,$porcentaje,$minimo,$imputa_desde,$ddjj));
								}
								catch (exception $e) {die ($db->ErrorMsg()); }

		
	FinalizarTransaccion($db);
}
elseif($accion='eliminar'){
	ComenzarTransaccion($db);
		
					try {
						$db->Execute("CALL IMPUESTOS.PR_DEL_RETENCION_ING_BRUTOS(?)",array($id_retencion_ing_bruto));
								}
								catch (exception $e) {die ($db->ErrorMsg()); }

		
	FinalizarTransaccion($db);
}

header("location: abm_retenciones_ing_brutos.php"); ?>
