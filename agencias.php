<?php 
include ("db_conecta_adodb.inc.php");
include ("funcion.inc.php");
session_start();
?>
<?php 
	$_SESSION['script'] =  basename($_SERVER['PHP_SELF']);	
?> 
<script language="javascript" src="funcion2.js"></script>
<style type="text/css">
<!--
.Estilo4 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo6 {font-size: 14px}
-->
</style>

<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
<form action="#" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('agencia_detalle','agencia_detalle.php',this); return false;">
  <?php   
 try {
    $rs_sucursal = $db -> Execute("select suc_ban as codigo, nombre as descripcion from juegos.sucursal where suc_ban in (1,20,21,22,23,24,25,26,27,30,31,32,33)");
	}
	catch (exception $e)
	{
	die ($db->ErrorMsg()); 
    } 
try {
    $rs_juego = $db -> Execute("select cod_juego as codigo, descripcion as descripcion from cuenta_corriente.juego order by 1");	}
	catch (exception $e)
	{
	die ($db->ErrorMsg()); 
    }	
try {
    $rs_agencia = $db -> Execute("select nro_agen as codigo,to_char(nro_agen,'0009')||'---->'||nombre as descripcion from juegos.agencia where suc_ban='1' and nro_agen<4000 order by nro_agen");	}
	catch (exception $e)
	{
	die ($db->ErrorMsg()); 
    }	
?> 
<table width="100%" border="0" bordercolor="#CCCCCC">
   <tr>
      <th colspan="7" bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="td4" scope="col">
	     <table width="100%" border="0" cellspacing="1">
   <tr align="center" class="td2">
          	   <td class="td3">Delegacion</td>
            <td class="td3">Agencia</td>
   	        <td class="td3">Juego</td>
            <td class="td3">&nbsp;</td>
            <td class="td3">&nbsp;</td>
   	       </tr>
     	    <tr align="center" class="small">
     	      <td class="td3"><span class="Estilo6">
     	        <?php armar_combo($rs_sucursal,'delegacion',$row->SUC_BAN);?>
     	      </span></td>
            <td class="td3"><span class="Estilo6">
   	            <?php armar_combo($rs_agencia,"agencia",$row->CODIGO);?>
   	          </span></td>
            <td class="td3"><span class="Estilo6">
   	            <?php armar_combo($rs_juego,"juego",$row->COD_JUEGO);?>
   	          </span></td>
   	          <td class="td3"><input name="Submit" type="submit" value="Ver Movimeintos" class="small"/></td>
   	          <td width="1%" class="td3"><a href="#" onclick="window.open('list/prueba1.php','Ventana','width=400,height=400,top=0,Left=0,menubar=no,scrollbars=yes,resizable=yes')"><img src="image/24px-Crystal_Clear_app_printer.png" alt="Imprimir" width="24" height="23" border="0" /></a></td>
   	       </tr>
        </table>		
      </th>
   </tr>
</table>
</form>
<div id="agencia_detalle"></div>
