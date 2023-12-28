<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

//print_r($_POST);die();
//$db->debug=true;

if (!empty($_POST['accion']))
	$accion = $_POST['accion'];
else
	$accion = $_GET['accion'];

if (!empty($_POST['id_sucursal']))
	$id_sucursal = $_POST['id_sucursal'];
else
	$id_sucursal = $_GET['id_sucursal'];

if (!empty($_POST['id_agencia']))
	$id_agencia = $_POST['id_agencia'];
else
	$id_agencia = $_GET['id_agencia'];	


if ($accion=='alta'){
	ComenzarTransaccion($db);
		
					try {
						$db->Execute("CALL IMPUESTOS.PR_INS_CARTELERIA(?,?)",array($id_sucursal,$id_agencia));
								}
								catch (exception $e) {die ($db->ErrorMsg()); }

		
	FinalizarTransaccion($db);
}

elseif($accion='eliminar'){
	ComenzarTransaccion($db);
		
					try {
						$db->Execute("CALL IMPUESTOS.PR_DEL_CARTELERIA(?,?)",array($id_sucursal,$id_agencia));
								}
								catch (exception $e) {die ($db->ErrorMsg()); }

		
	FinalizarTransaccion($db);
}

//header("location: abm_carteleria.php"); ?>
