<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

//$db->debug= true;

$suc_ban= $_GET['suc_ban'];
$nro_agen= $_GET['nro_agen'];

$mensaje= 'NO SE ENCONTRO CUIT PARA ESTA AGENCIA';
$cuit = '';
 
 try {$rs_cuit= $db->Execute("select JUEGOS.f_cuit(?,?,?) as cuit from dual",array($suc_ban,$nro_agen,0));}
	catch (exception $e){	die ($db->ErrorMsg()); 	}	

if ($rs_cuit->RecordCount() > 0) {
	$row_cuit = $rs_cuit->FetchNextObject($toupper=true);
	  $cuit = $row_cuit->CUIT;}
?>
    
<table border="0" width="29%" cellpadding="2" cellspacing="0" align="center"  >
	<tr class="td5" >
      <td>Cuit</td>   
      <td><?php if ($cuit == ''){ echo $mensaje;} else {echo $cuit;} ?></td> 
</tr></table>
<input name="cuit1" type="hidden" value="<?php echo $cuit; ?>" id="cuit1"/>
