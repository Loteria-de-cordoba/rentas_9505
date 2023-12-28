<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");
 include('../jscalendar-1.0/calendario.php'); 

/*$db->debug=true;
print_r($_POST);*/

try{	
	$rs_prov= $db->Execute("select id_provincia as codigo, descripcion 
                			from impuestos.t_provincias
							order by id_provincia");
	}
	catch(exception $e){die($db->ErrorMsg());
	}

  try{  
  $rs_concepto= $db->Execute("select cod_concepto as codigo, cod_concepto||' - '||descripcion as descripcion 
                      from kaizen.concepto
                      where cod_concepto not in (1,2,3,4,5)
              order by cod_concepto");
  }
  catch(exception $e){die($db->ErrorMsg());
  }
?>
		
        
 <link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
 <link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
 
<div id="ventana" ><div align="center" id="titulo_ventana"> ALTA NUEVA RETENCION SOBRE IMPUESTO MUNICIPAL </div></div>
<br/>

<div id="contenido">
<form name="alta_retencion_imp_municipal" id="alta_retencion_imp_municipal" action="#" method="post" onsubmit= "validar_alta_retencion_imp_municipal('contenido','retenciones/procesar_retencion_imp_municipal.php', this); return false;" >

<table width="56%"  border="0" align="center"  class="detalle_tabla">
  <tr>
  	<th colspan="8" align="center" class="titulosgrandes" ></th>
  </tr>
  <tr >
    <td align="center" class="trceleste">CONCEPTO </td>
    <td width="73%" align="left" ><?php armar_combo_seleccione($rs_concepto,'cod_concepto',' ');?> </td>
  </tr>
  <tr >
    <td align="center" class="trceleste">PROVINCIA </td>
    <td width="73%" align="left" ><?php  armar_combo_ejecutar_ninguno_ajax_get($rs_prov,'id_provincia','div_loc','municipal/localidad.php');?> </td>
  </tr>
  <tr>
    <td align="center" class="trceleste"> LOCALIDAD </td>
    <td width="73%" align="left" ><div id="div_loc"></div> </td>
  </tr>
  <tr>
   	<td align="center" class="trceleste">TOPE DESDE </td>
    <td width="73%" align="left" ><input name="desde" type="text" class="td9" id="desde" size="10" onchange="javascript:validar_solo_numerico(this);" /></td>
  </tr>
  <tr>
   	<td align="center" class="trceleste">TOPE HASTA</td>
    <td width="73%" align="left" ><input name="hasta" type="text" class="td9" id="hasta" size="10" onchange="javascript:validar_solo_numerico(this);" /></td>
  </tr>
  <tr>
   	<td align="center" class="trceleste">PORCENTAJE </td>
    <td align="left" > <input name="porcentaje" type="text" class="td9" id="porcentaje" size="10" onchange="javascript:validar_solo_numerico(this);" />
    </td>
  </tr>
  <tr>
   	<td align="center" class="trceleste">PERIODO</td>
    <td width="73%" align="left"><input name="periodo" type="text" class="td9" id="periodo" size="4" onchange="javascript:validar_solo_numerico(this);" /></td>
  </tr>
  <tr>
    <td align="center" class="trceleste">TIPO DE IMPUTACIÓN</td>
    <td width="73%" align="left">
      <input name="tipo_imputacion" type="radio" id="tipo_imputacion" value="diaria" onclick="$('#momento_div').hide();"/>Diaria
      <input name="tipo_imputacion" type="radio" id="tipo_imputacion" value="mensual" onclick="$('#momento_div').show();" checked/>Mensual
      <div id="momento_div">
        <input name="momento_imputacion" type="radio" class="td9" id="momento_imputacion" size="4" value="ultimo_dia" checked/>Ultimo Día del Mes Actual
        <input name="momento_imputacion" type="radio" class="td9" id="momento_imputacion" size="4" value="primer_dia"/>Primer Día del Mes Siguiente
      </div>
    </td>
  </tr>
  <tr>
    <td align="center" class="trceleste">SOBRE CARTELERIA</td>
    <td width="73%" align="left"><input name="sobre_carteleria" type="checkbox" class="td9" id="sobre_carteleria" size="4" value="sobre_carteleria" />El c&aacute;lculo de la retenci&oacute;n se realizar&aacute; sobre las agencias con DDJJ de Carteler&iacute;a</td>
  </tr>
  <tr>
    <td align="center" class="trceleste">MINIMO</td>
    <td width="73%" align="left"><input name="minimo" type="text" class="td9" id="minimo" size="10" onchange="javascript:validar_solo_numerico(this);" /><img src="image/smYellowInfo_mac.png"/> Importe Minimo a Retener</td>
  </tr>
  <tr>
    <td align="center" class="trceleste">IMPUTA DESDE</td>
    <td width="73%" align="left"> <?php abrir_calendario_s_hora('imputa_desde',$imputa_desde); ?><img src="image/smYellowInfo_mac.png"/> Fecha a partir de la cual comienza a imputar la Retencion</td>
  </tr>
  <tr>
  	<th colspan="8" align="center" class="titulosgrandes" ></th>
  </tr>
  <tr class="trblanco"  >
    <td height="41" colspan="4" align="center" > <input type="submit" value="Grabar" class="small" align="top" />
    <input  type="hidden" name="accion" value="alta"/> </td>
  </tr>
</table>
</form>  

<p>&nbsp;</p>
<div id="accion_ventana" >
  <div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"   /> <a href="#" onClick="ajax_get('contenido','retenciones/abm_retenciones_imp_municipal.php','');" class="small" >Regresar </a></div>
</div>
</div>