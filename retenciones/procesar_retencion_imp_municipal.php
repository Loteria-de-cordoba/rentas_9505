<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

//print_r($_POST);die();
/*$db->debug=true;*/

if (!empty($_POST['accion']))
	$accion = $_POST['accion'];
else
	$accion = $_GET['accion'];	
$id_provincia = $_POST['id_provincia'];
$id_localidad = $_POST['descripcion'];
$desde= $_POST['desde'];
$hasta= $_POST['hasta'];
$porcentaje= $_POST['porcentaje'];
$periodo = $_POST['periodo'];
$imputa_desde = $_POST['imputa_desde'];
$tipo_imputacion = $_POST['tipo_imputacion'];
if ($tipo_imputacion=="mensual"){
	$tipo_imputacion=1;
	$momento_imputacion = $_POST['momento_imputacion'];
	if ($momento_imputacion=="ultimo_dia")
		$momento_imputacion=0;
	else
		$momento_imputacion=1;
}else{
	$tipo_imputacion=0;
	$momento_imputacion=null;
}
$sobre_carteleria=$_POST['sobre_carteleria'];
if ($sobre_carteleria=='on')
	$sobre_carteleria=1;
else
	$sobre_carteleria=0;
$minimo = $_POST['minimo'];
$cod_concepto =  $_POST['cod_concepto'];

if (!empty($_POST['id_retencion_imp_municipal']))
	$id_retencion_imp_municipal = $_POST['id_retencion_imp_municipal'];
else
	$id_retencion_imp_municipal = $_GET['id_retencion_imp_municipal'];	

//die($accion);

if ($accion=='alta'){
	ComenzarTransaccion($db);
		
					try {
						$db->Execute("CALL IMPUESTOS.PR_INS_RETENCION_IMP_MUNICIPAL(?,?,?,?,?,?,?,to_date(?,'DD/MM/YYYY'),?,?,?,?)",array($cod_concepto,$id_provincia,$desde,$hasta,$periodo,$porcentaje,$minimo,$imputa_desde,$id_localidad,$tipo_imputacion,$momento_imputacion,$sobre_carteleria));
								}
								catch (exception $e) {die ($db->ErrorMsg()); }

		
	FinalizarTransaccion($db);
}
elseif($accion=='modificar'){
	ComenzarTransaccion($db);
		
					try {
						$db->Execute("CALL IMPUESTOS.PR_UPD_RETENCION_IMP_MUNICIPAL(?,?,?,?,?,?,?,?,to_date(?,'DD/MM/YYYY'),?,?,?,?)",array($id_retencion_imp_municipal,$cod_concepto,$id_provincia,$desde,$hasta,$periodo,$porcentaje,$minimo,$imputa_desde,$id_localidad,$tipo_imputacion,$momento_imputacion,$sobre_carteleria));
								}
								catch (exception $e) {die ($db->ErrorMsg()); }

		
	FinalizarTransaccion($db);
}
elseif($accion='eliminar'){
	ComenzarTransaccion($db);
		
					try {
						$db->Execute("CALL IMPUESTOS.PR_DEL_RETENCION_IMP_MUNICIPAL(?)",array($id_retencion_imp_municipal));
								}
								catch (exception $e) {die ($db->ErrorMsg()); }

		
	FinalizarTransaccion($db);
}

header("location: abm_retenciones_imp_municipal.php"); ?>
