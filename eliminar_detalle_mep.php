<?php
session_start();
include("db_conecta_adodb.inc.php");
try {
	$db->Execute("delete from impuestos.mep9505 where id_mep = ?",array($_GET['id_mep']));
	}
	catch  (exception $e) 
	{ 
	die($db->ErrorMsg());
	}
header("location: detalle_mep.php");
?>  	