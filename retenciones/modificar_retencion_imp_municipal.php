<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");
 include('../jscalendar-1.0/calendario.php'); 

//$db->debug=true;
//print_r($_POST);

try{	
	$rs_prov= $db->Execute("select id_provincia as codigo, descripcion 
                			from impuestos.t_provincias
							order by id_provincia");
	}
	catch(exception $e){die($db->ErrorMsg());
	}

try { $rs = $db -> Execute("select porcentaje, id_provincia, id_localidad, tope_desde, tope_hasta, 
                periodo,TO_CHAR(imputa_desde,'DD/MM/YYYY') imputa_desde,cod_concepto,minimo,tipo_imputacion,momento_imputacion,sobre_carteleria
                from impuestos.t_retencion_imp_municipal
                where id_retencion_imp_municipal = ?",array($_GET['id_retencion_imp_municipal']));
                       }  catch (exception $e) {  
                        die ($db->ErrorMsg());
                       }
$row=$rs->FetchNextObject($toupper=true);

  try{
  $rs_localidad= $db->Execute(" select id_localidad as codigo, descripcion
                from impuestos.t_localidades
                  where id_provincia = ?
                  order by 2",array($row->ID_PROVINCIA));
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

<div id="ventana" ><div align="center" id="titulo_ventana"> MODIFICAR RETENCION SOBRE IMPUESTO MUNICIPAL </div></div>
<br/>

<div id="contenido">
<form name="modificar_retencion_imp_municipal" id="modificar_retencion_imp_municipal" action="#" method="post" onsubmit= "validar_alta_retencion_imp_municipal('contenido','retenciones/procesar_retencion_imp_municipal.php', this); return false;" >

<table width="56%"  border="0" align="center"  class="detalle_tabla">
  <tr>
  	<th colspan="8" align="center" class="titulosgrandes" ></th>
  </tr>
  <tr >
    <td align="center" class="trceleste"> CONCEPTO </td>
    <td width="73%" align="left" ><?php armar_combo_seleccione($rs_concepto,'cod_concepto',$row->COD_CONCEPTO);?> </td>
  </tr>
  <tr >
    <td align="center" class="trceleste"> PROVINCIA </td>
    <td width="73%" align="left" ><?php  armar_combo_ejecutar_ninguno_ajax_get_puntero($rs_prov,'id_provincia',$row->ID_PROVINCIA,'div_loc','municipal/localidad.php');?> </td>
  </tr>
  <tr>
    <td align="center" class="trceleste"> LOCALIDAD </td>
    <td width="73%" align="left" >
      <div id="div_loc"><?php armar_combo_seleccione($rs_localidad,'descripcion',$row->ID_LOCALIDAD);?></div></td>
  </tr>
  <tr>
    <td align="center" class="trceleste">TOPE DESDE </td>
    <td width="73%" align="left" ><input name="desde" type="text" class="td9" id="desde" size="10" onchange="javascript:validar_solo_numerico(this);" value="<?php echo $row->TOPE_DESDE; ?> "/></td>
  </tr>
  <tr>
    <td align="center" class="trceleste">TOPE HASTA</td>
    <td width="73%" align="left" ><input name="hasta" type="text" class="td9" id="hasta" size="10" onchange="javascript:validar_solo_numerico(this);" value="<?php echo $row->TOPE_HASTA; ?>" /></td>
  </tr>
    <tr>
    <td align="center" class="trceleste">PORCENTAJE </td>
    <td align="left" > <input name="porcentaje" type="text" class="td9" id="porcentaje" size="10" onchange="javascript:validar_solo_numerico(this);" value="<?php echo $row->PORCENTAJE; ?>"/>
    </td>
  </tr>
  <tr>
    <td align="center" class="trceleste">PERIODO</td>
    <td width="73%" align="left"><input name="periodo" type="text" class="td9" id="periodo" size="4" onchange="javascript:validar_solo_numerico(this);" value="<?php echo $row->PERIODO; ?>"/></td>
  </tr>
    <td align="center" class="trceleste">TIPO DE IMPUTACIÓN</td>
    <td width="73%" align="left">
      <input name="tipo_imputacion" type="radio" id="tipo_imputacion" value="diaria" onclick="$('#momento_div').hide();" <?php if($row->TIPO_IMPUTACION=='0'){echo "checked";}?>/>Diaria
      <input name="tipo_imputacion" type="radio" id="tipo_imputacion" value="mensual" onclick="$('#momento_div').show();"<?php if($row->TIPO_IMPUTACION=='1'){echo "checked";}?>/>Mensual
      <div id="momento_div">
        <input name="momento_imputacion" type="radio" class="td9" id="momento_imputacion" size="4" value="ultimo_dia" <?php if($row->TIPO_IMPUTACION=='1'){if($row->MOMENTO_IMPUTACION=='0'){echo "checked";}}?>/>Ultimo Día del Mes Actual
        <input name="momento_imputacion" type="radio" class="td9" id="momento_imputacion" size="4" value="primer_dia" <?php if($row->TIPO_IMPUTACION=='1'){if($row->MOMENTO_IMPUTACION=='1'){echo "checked";}}?>/>Primer Día del Mes Siguiente
      </div>
    </td>
  </tr>
  <tr>
    <td align="center" class="trceleste">SOBRE CARTELERIA</td>
    <td width="73%" align="left"><input name="sobre_carteleria" type="checkbox" class="td9" id="sobre_carteleria" size="4" <?php if($row->SOBRE_CARTELERIA=='1') echo "checked";?>/>El c&aacute;lculo de la retenci&oacute;n se realizar&aacute; sobre las agencias con DDJJ de Carteler&iacute;a</td>
  </tr>
  <tr>
    <td align="center" class="trceleste">MINIMO</td>
    <td width="73%" align="left"><input name="minimo" type="text" class="td9" id="minimo" size="10" onchange="javascript:validar_solo_numerico(this);" value="<?php echo $row->MINIMO; ?>"/><img src="image/smYellowInfo_mac.png"/> Importe Minimo a Retener</td>
  </tr>
  <tr>
    <td align="center" class="trceleste">IMPUTA DESDE</td>
    <td width="73%" align="left"> <?php abrir_calendario_s_hora('imputa_desde',$row->IMPUTA_DESDE); ?><img src="image/smYellowInfo_mac.png"/> Fecha a partir de la cual comienza a imputar la Retencion</td>
  </tr>
  <tr>
  	<th colspan="8" align="center" class="titulosgrandes" ></th>
  </tr>
  <tr class="trblanco"  >
    <td height="41" colspan="4" align="center" > <input type="submit" value="Grabar" class="small" align="top" />
    <input  type="hidden" name="id_retencion_imp_municipal" value="<?php echo $_GET['id_retencion_imp_municipal']; ?>"/>
    <input  type="hidden" name="accion" value="modificar"/> </td>
  </tr>
</table>
</form>  

<p>&nbsp;</p>
<div id="accion_ventana" >
  <div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"   /> <a href="#" onClick="ajax_get('contenido','retenciones/abm_retenciones_imp_municipal.php','');" class="small" >Regresar </a></div>
</div>
</div>