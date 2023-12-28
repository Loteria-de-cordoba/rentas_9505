<?php 
include("adodb/adodb.inc.php");
include('adodb/adodb-exceptions.inc.php');
$db = NewADOConnection("oci8po"); //oracle 9.2 o superior
//$db = NewADOConnection("oci8"); //oracle 8i 0 9i
//$db = NewADOConnection("oracle"); //oracle 7
//$db->Connect("rman", $_SESSION['usuario'], $_SESSION['clave']);
$rnum=rand(0,99999999);
$db->Connect("(DESCRIPTION =
					(ADDRESS =
				(PROTOCOL = TCP)
					(HOST = nscentral-scan.loteriadecordoba.com.ar)
					(PORT = 1521)
					(HASH = '.$rnum.')
				 )
			(CONNECT_DATA =(SERVER = DEDICATED)
      (SERVICE_NAME = CENTRAL))
				 )", "DU".$_SESSION['usuario'], $_SESSION['clave']);
//$DB->charSet = 'utf-8';//oracle
//$db->debug = true; // si lo habilito muestra las transacciones en el navegador
//$db->LogSQL(); // turn on logging (solo utilizarlo cuando el sistema esta estable porque no muestra los errores de mysql) // solo para mantenimiento
##Libreria oci8po distinta forma de acceder a variables bind
##Libreria oci8
/*
try {
	//$rs = $db->Execute("select * from emp where empno>:emp order by empno", array('emp' => 7900));
	$rs = $db->SelectLimit("select * from emp where empno=>:emp order by empno",10,1, array('emp'=>7900));
	}
	catch  (exception $e) 
	{ 
	die($db->ErrorMsg());
	}
*/
##Librerias oracle y oci8
	/*
    $rs = $db->Execute("select * from emp where empno>:emp order by empno", array('emp' => 7900));
	*/
//echo $rs->RowCount();

function ComenzarTransaccion($db) {
	$db->StartTrans();
}

function FinalizarTransaccion($db) {
	$db->CompleteTrans($autoComplete=true);
}

?>