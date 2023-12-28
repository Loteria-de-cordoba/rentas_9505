<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

/*$db->debug=true;
print_r($_POST);*/

try{	
	$rs_prov= $db->Execute("SELECT id_provincia as codigo, descripcion 
                			     from impuestos.t_provincias
							           order by id_provincia");
} catch(exception $e){die($db->ErrorMsg()); }
	
try{	
	$rs_juego= $db->Execute("SELECT cod_juego AS codigo,  descripcion 
                  				FROM kaizen.juego
                  				order by descripcion");
 } catch(exception $e){die($db->ErrorMsg()); } ?>
		
<link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />

<p>&nbsp;</p>

<div id="ventana">
  <div id="titulo_ventana" align="center"> ALTA EXCEPCION IMPUESTOS MUNICIPALES POR JUEGOS </div>
   
<table width="56%"  border="0" align="center">
  <tr><td align="center">
    <span class="texto3">REGIMEN SIMPLIFICADO </span>
</td></tr></table>
 
  
  <div id="contenido">
    <form name="alta_excepcion_mun_juego_rs" id="alta_excepcion_mun_juego_rs" action="#" method="post" onsubmit= "validar_alta_excepcion_mun_juego('contenido','municipal/procesar_alta_excepcion_mun_juego_rs.php', this); return false;" >
      

<table width="56%"  border="0" align="center"  class="detalle_tabla">
  <tr>
  	<th colspan="4" align="center" class="titulosgrandes" > </th>
  </tr>
  <tr >
   	<td align="center" class="trceleste"> JUEGOS </td>
   <td width="73%" align="left" > <?php  armar_combo_todos($rs_juego,'id_juego',' ')?> </td>
  </tr>
  <tr >
    <td align="center" class="trceleste"> PROVINCIA </td>
    <td width="73%" align="left" ><?php  armar_combo_ejecutar_ninguno_ajax_get($rs_prov,'id_provincia','div_loc','municipal/localidad.php');?> </td>
  </tr>
  <tr >
   	<td align="center" class="trceleste"> LOCALIDAD </td>
   <td width="73%" align="left" ><div id="div_loc"></div> </td>
  </tr>
    <tr >
   	<td align="center" class="trceleste"> PORCENTAJE </td>
   <td  align="left" > <input name="porcentaje" type="text" class="td9" id="porcentaje" size="10" onchange="javascript:validar_solo_numerico(this);" /></td>
  </tr>
  <tr>
  	<th colspan="4" align="center" class="titulosgrandes" ></th>
  </tr>
   <tr class="trblanco"  >
    <td height="41" colspan="4" align="center" > <input type="submit" value="Grabar" class="small" align="top" /> </td>
  </tr>
  
</table>
</form>

<p>&nbsp;</p>
<div id="accion_ventana" >
  <div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"/> <a href="#" onClick="ajax_get('contenido','municipal/abm_excepcion_mun_juego_rs.php','');" class="small">Regresar</a></div>
</div>
</div>
</div>