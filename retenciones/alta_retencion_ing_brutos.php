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
 
<div id="ventana" ><div align="center" id="titulo_ventana"> ALTA NUEVA RETENCION SOBRE INGRESOS BRUTOS </div></div>
<br/>

<div id="contenido">
<form name="alta_retencion_ingresos_brutos" id="alta_retencion_ingresos_brutos" action="#" method="post" onsubmit= "validar_alta_retencion_ing_brutos('contenido','retenciones/procesar_retencion_ing_brutos.php', this); return false;" >

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
    <td width="73%" align="left" ><?php armar_combo_seleccione($rs_prov,'id_provincia',' ');?> </td>
  </tr>
  <tr>
   	<td align="center" class="trceleste">TOPE DESDE </td>
    <td width="73%" align="left" ><input name="desde" type="text" class="td9" id="desde" size="15" onchange="javascript:validar_solo_numerico(this);" /></td>
  </tr>
  <tr>
   	<td align="center" class="trceleste">TOPE HASTA</td>
    <td width="73%" align="left" ><input name="hasta" type="text" class="td9" id="hasta" size="15" onchange="javascript:validar_solo_numerico(this);" /></td>
  </tr>
  <tr>
   	<td align="center" class="trceleste">ALICUOTA</td>
    <td align="left" > <input name="porcentaje" type="text" class="td9" id="porcentaje" size="15" onchange="javascript:validar_solo_numerico(this);" />
    </td>
  </tr>
  <tr>
   	<td align="center" class="trceleste">PERIODO</td>
    <td width="73%" align="left"><input name="periodo" type="text" class="td9" id="periodo" size="4" onchange="javascript:validar_solo_numerico(this);" /></td>
  </tr>
  <tr>
    <td align="center" class="trceleste">SOBRE DDJJ</td>
    <td width="73%" align="left"><input name="ddjj" type="checkbox" class="td9" id="minimo" size="4" value="ddjj"/>El c&aacute;lculo de la retenci&oacute;n se realizar&aacute; en base a la DDJJ de Bases Imponibles</td>
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
  <div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"   /> <a href="#" onClick="ajax_get('contenido','retenciones/abm_retenciones_ing_brutos.php','');" class="small" >Regresar </a></div>
</div>
</div>
</div>