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

if (isset($_POST['fecha_desde'])){
      $fecha_desde = $_POST['fecha_desde'];
      $fecha_hasta = $_POST['fecha_hasta'];
} else if (isset($_GET['fecha_desde']) && $_GET['fecha_desde']!="") {
      $fecha_desde = $_GET['fecha_desde'];
      $fecha_hasta = $_GET['fecha_hasta'];
} else {
   $array_fecha = FechaServer();
   $fecha_desde = str_pad($array_fecha["mday"],2,'0',STR_PAD_LEFT).'/'.str_pad($array_fecha["mon"],2,'0',STR_PAD_LEFT).'/'.$array_fecha["year"];
   $fecha_hasta = str_pad($array_fecha["mday"],2,'0',STR_PAD_LEFT).'/'.str_pad($array_fecha["mon"],2,'0',STR_PAD_LEFT).'/'.$array_fecha["year"];
}
?>
		
        
 <link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
 <link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
 
<div id="ventana" ><div align="center" id="titulo_ventana"> ALTA IMPUESTOS MUNICIPALES </div></div>
<br/>

<div id="contenido">
<form name="alta_excepcion_municipal" id="alta_excepcion_municipal" action="#" method="post" onsubmit= "validar_alta_excepcion_mun('contenido','municipal/procesar_alta_excepcion_municipal.php', this); return false;" >

<table width="56%"  border="0" align="center"  class="detalle_tabla">
  <tr>
  	<th colspan="4" align="center" class="titulosgrandes" ></th>
  </tr>
  <tr >
    <td align="center" class="trceleste"> PROVINCIA </td>
    <td width="73%" align="left" ><?php  armar_combo_ejecutar_ninguno_ajax_get($rs_prov,'id_provincia','div_loc','municipal/localidad.php');?> </td>
  </tr>
  <tr>
   	<td align="center" class="trceleste"> LOCALIDAD </td>
    <td width="73%" align="left" ><div id="div_loc"></div> </td>
  </tr>
    
  <tr>
   	<td align="center" class="trceleste"> PORCENTAJE </td>
    <td align="left" > <input name="porcentaje" type="text" class="td9" id="porcentaje" size="10" onchange="javascript:validar_solo_numerico(this);" /></td>
  </tr>
  <tr>
    <td align="center" class="trceleste"> PERIODO </td>
    <td align="left" > <input name="periodo" type="text" class="td9" id="periodo" size="4" onchange="javascript:validar_solo_numerico(this);" /></td></tr>
    <tr>
      <td align="center" class="trceleste"> APLICA DESDE </td>
      <td  align="left" width="20%"><?php abrir_calendario('fecha_desde',$fecha_desde) ?></td>
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
  <div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"   /> <a href="#" onClick="ajax_get('contenido','municipal/abm_excepcion_municipal.php','');" class="small" >Regresar </a></div>
</div>
</div>
</div>