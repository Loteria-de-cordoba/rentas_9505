<?php 
session_start(); 
include ("db_conecta_adodb.inc.php");
include ("funcion.inc.php");
try {
	 $rs_mep = $db->Execute("select id_mep, a.concepto, quincena, mes, anio, to_char(fechamep,'YYYY-MM-DD') as fecha, 
	 monto, recargo, cuit, c.cbu
	 from impuestos.mep9505 a, impuestos.parametros b, impuestos.cuenta_deposito c
	 where a.concepto = c.concepto
	 and id_mep = ?",array($_GET['id_mep']) );
	 }
	 catch  (exception $e) 
	 { 
	 die($db->ErrorMsg());
	 }
$row_mep = $rs_mep->FetchNextObject($toupper=true);
$filename = "FOPAISL_".$row_mep->ID_MEP.".xml";
$contenido = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>
<MEP_FDO_INC_SOC>
  <SUJETO CUIT=\"".$row_mep->CUIT."\">
	<MEPS>
	  <MEP numero=\"".$row_mep->ID_MEP."\" cuentaDeposito=\"".$row_mep->CBU."\" concepto=\"".$row_mep->CONCEPTO."\" Año=\"".$row_mep->ANIO."\" mes=\"".$row_mep->MES."\" periodo=\"".$row_mep->QUINCENA."\" fechaMEP=\"".$row_mep->FECHA."\" montoCapital=\"".$row_mep->MONTO."\" montoRecargo=\"".$row_mep->RECARGO."\"/>
	</MEPS>
  </SUJETO>
</MEP_FDO_INC_SOC>";
file_put_contents($filename, $contenido);
// downloading a file
//$filename = $_GET['path'];
// fix for IE catching or PHP bug issue
header("Pragma: public");
header("Expires: 0"); // set expiration time
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
// browser must download file from server instead of cache
// force download dialog
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
// use the Content-Disposition header to supply a recommended filename and
// force the browser to display the save dialog.
header("Content-Disposition: attachment; filename=".basename($filename).";");
/*
The Content-transfer-encoding header should be binary, since the file will be read
directly from the disk and the raw bytes passed to the downloading computer.
The Content-length header is useful to set for downloads. The browser will be able to
show a progress meter as a file downloads. The content-lenght can be determines by
filesize function returns the size of a file.
*/
header("Content-Transfer-Encoding: binary");
@header("Content-Length: ".filesize($filename));
@readfile($filename);
@unlink($filename);
try {
	 $rs_mep = $db->Execute("update impuestos.mep9505 
	 							set presentado = 1
								where id_mep = ?",array($_GET['id_mep']) );
	 }
	 catch  (exception $e) 
	 { 
	 die($db->ErrorMsg());
	 }

exit(0);
//header("Pragma: public");
//header("Expires: 0");
//header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//header("Cache-Control: public"); 
//header("location: reload(true)");
?>