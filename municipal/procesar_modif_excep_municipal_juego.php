<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

// print_r($_POST);die();
//$db->debug=true;

$localidad = $_POST['localidad'];
$porcentaje = $_POST['porcentaje'];
$id_juego = $_POST['id_juego'];

ComenzarTransaccion($db);

try{	
	  $rs = $db->Execute("UPDATE IMPUESTOS.t_excepcion_municipal_kz_juego emj 
							  set emj.porcentaje = $porcentaje
							 where emj.id_localidad = $localidad
							   and emj.id_juego = $id_juego");
} catch(exception $e){die($db->ErrorMsg()); }
	
FinalizarTransaccion($db);
header("location:abm_excepcion_municipal_juego.php"); ?>