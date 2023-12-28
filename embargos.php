<?php include ("..//cuenta_corriente/db_conecta_adodb.inc.php");
include ("..//cuenta_corriente/funcion.inc.php");

session_start(); 
$_SESSION['script'] =  basename($_SERVER['PHP_SELF']);	
?> 
<script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
<script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
<!--<link rel="stylesheet" type="text/css" media="all" href="jscalendar-1.0/calendar-system.css" title="blue" />-->
<link rel="stylesheet" type="text/css" media="all" href="jscalendar-1.0/calendar-brown.css" title="summer" />
<!--<link rel="stylesheet" type="text/css" media="all" href="skins/aqua/theme.css" title="Aqua" />-->
<!--<link rel="alternate stylesheet" type="text/css" media="all" href="jscalendar-1.0/calendar-blue.css" title="winter" />-->
<!--<link rel="alternate stylesheet" type="text/css" media="all" href="jscalendar-1.0/calendar-blue2.css" title="blue" />-->
<!--<link rel="alternate stylesheet" type="text/css" media="all" href="jscalendar-1.0/calendar-brown.css" title="summer" />-->
<!--<link rel="alternate stylesheet" type="text/css" media="all" href="jscalendar-1.0/calendar-green.css" title="green" />-->
<!--<link rel="alternate stylesheet" type="text/css" media="all" href="jscalendar-1.0/calendar-win2k-1.css" title="win2k-1" />-->
<!--<link rel="alternate stylesheet" type="text/css" media="all" href="jscalendar-1.0/calendar-win2k-2.css" title="win2k-2" />-->
<!--<link rel="alternate stylesheet" type="text/css" media="all" href="jscalendar-1.0/calendar-win2k-cold-1.css" title="win2k-cold-1" />-->
<!--<link rel="alternate stylesheet" type="text/css" media="all" href="jscalendar-1.0/calendar-win2k-cold-2.css" title="win2k-cold-1" />-->
<!--<link rel="alternate stylesheet" type="text/css" media="all" href="jscalendar-1.0/calendar-system.css" title="system" />-->
<!--<style type="text/css">@import url(calendar-win2k-1.css);</style>-->
<!--<script language="JavaScript" src="calendario/javascripts.js"></script>-->

<?php include ("jscalendar-1.0/calendario.php");?>

<script language="javascript" src="..//cuenta_corriente/funcion2.js"></script>
<?php 
try {
    $rs_sucursal = $db -> Execute("select suc_ban as codigo, nombre as descripcion from juegos.sucursal where suc_ban in (1,20,21,22,23,24,25,26,27,30,31,32,33)");
	}
	catch (exception $e)
	{
	die ($db->ErrorMsg()); 
    } 
	
try {
    $rs_agencia = $db -> Execute("select nro_agen as codigo,to_char(nro_agen,'0009')||'---->'||nombre as descripcion from juegos.agencia where suc_ban='1' and nro_agen<4000 order by nro_agen");	}
	catch (exception $e)
	{
	die ($db->ErrorMsg()); 
    }?>	
<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
<form action="#" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('embargos_detalle','embargos_detalle.php',this); return false;">
<table width="100%" border="0" align="center">
  <tr>
    <td align="center" class="td3"><span class="Estilo1">Sucursal:</span></td>
    <td align="center" class="td3"><span class="Estilo1">Agencia:</span></td>
    <td align="center" class="td3"><span class="Estilo1">Desde:</span></td>
    <td align="center" class="td3"><span class="Estilo1">Hasta:</span></td>
    <td class="td3"><span class="Estilo1"></span></td>
  </tr>
  <tr>
    <td align="center" class="td3"><span class="Estilo1">
      <?php armar_combo($rs_sucursal,'delegacion',$row->SUC_BAN);?>
    </span></td>
    <td align="center" class="td3"><span class="Estilo1">
      <?php armar_combo($rs_agencia,"agencia",$row->CODIGO);?>
    </span></td>
    <td align="center" class="td3"><span class="Estilo1">
      <?php  abrir_calendario('fecha1','form', $_SESSION['fecha']); ?>
    </span></td>
    <td align="center" class="td3"><span class="Estilo1">
      <?php  abrir_calendario('fecha2','formulario', $_SESSION['fecha']); ?>
    </span></td>
    <td align="center" class="td3"><input name="Submit" type="submit" value="Consultar" /></td>
  </tr>
</table>
</form>
<div id="embargos_detalle"></div>
