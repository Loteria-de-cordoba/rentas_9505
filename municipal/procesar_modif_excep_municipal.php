<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

// print_r($_POST);
// die();
//$db->debug=true;

$localidad = $_POST['localidad'];
$porcentaje = $_POST['porcentaje'];
$periodo = $_POST['periodo'];
$accion = "modificar";


ComenzarTransaccion($db);



try{	
	$rs = $db->Execute("update IMPUESTOS.t_excepcion_municipal_kz e 
							  set e.porcentaje = $porcentaje
							  where e.id_localidad = $localidad
							   and e.periodo = $periodo");
	}
	catch(exception $e){die($db->ErrorMsg());
	}

	try{ $db->Execute("INSERT INTO IMPUESTOS.t_log(usuario,periodo_cargado,porcentaje,nombre_usuario,accion,nombre_archivo)
									VALUES (?,?,?,?,?,?)",array($_SESSION[usuario],$periodo,$porcentaje,$_SESSION[nombre_usuario],$accion,$localidad.'-id_loc'));
	} catch (exception $e){die ($db->ErrorMsg());}



	
FinalizarTransaccion($db);
header("location: abm_excepcion_municipal.php"); ?>
