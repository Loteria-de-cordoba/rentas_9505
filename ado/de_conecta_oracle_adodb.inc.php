<?php 
//include "adodb/adodb.inc.php";//ya las llamo en la conexion de mysql
//include('adodb/adodb-exceptions.inc.php');//ya las llamo en la conexion de mysql
$db = NewADOConnection("oci8po"); //oracle 9.2 o superior
//$db = NewADOConnection("oci8"); //oracle 8i 0 9i
//$db_jue = NewADOConnection("oracle"); //oracle 7
$db_jue->Connect("central9", "juegos", "juegos");
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
?>