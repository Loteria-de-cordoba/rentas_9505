<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

//print_r($_POST);die();
//$db->debug=true;

if (!empty($_POST['accion']))
	$accion = $_POST['accion'];
else
	$accion = $_GET['accion'];	
$periodo = $_POST['periodo'];
$id_sucursal = $_POST['id_sucursal'];
$id_agencia = $_POST['id_agencia'];
$sum_bases_imponibles = $_POST['sum_bases_imponibles'];
//die($accion);

if ($accion=='alta'){
	ComenzarTransaccion($db);
		
					try {
						$db->Execute("CALL IMPUESTOS.PR_INS_DDJJ_BASES_IMPONIBLES(?,?,?,?)",array($periodo,$id_sucursal,$id_agencia,$sum_bases_imponibles));
								}
								catch (exception $e) {die ($db->ErrorMsg()); }

		
	FinalizarTransaccion($db);
}

elseif($accion='eliminar'){
	ComenzarTransaccion($db);
		
					try {
						$db->Execute("CALL IMPUESTOS.PR_INS_DDJJ_BASES_IMPONIBLES(?,?,?)",array($periodo,$id_sucursal,$id_agencia));
								}
								catch (exception $e) {die ($db->ErrorMsg()); }

		
	FinalizarTransaccion($db);
}

header("location: abm_ddjj_bases_imponibles.php"); ?>
