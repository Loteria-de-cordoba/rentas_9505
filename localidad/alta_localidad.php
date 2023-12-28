<?php session_start();

include ("../db_conecta_adodb.inc.php");
include_once ("../funcion.inc.php");

/*print_r($_GET);
$db->debug=true;*/

$id_provincia=(isset($_GET['id_provincia'])) ? $_GET['id_provincia'] : '';

try{	
	$rs_prov= $db->Execute("select  descripcion 
									from impuestos.t_provincias
									where id_provincia = $id_provincia");
					}
					catch(exception $e){die($db->ErrorMsg());
					}

$row=$rs_prov->FetchNextObject($toupper=true);
$rs_prov->MoveFirst();
$provincia = $row->DESCRIPCION;

?>

 <link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
 <link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
<!--
.style1 {
	color: #000000
}
-->
 </style>
<div id="ventana">
<div id="titulo_ventana" >NUEVA LOCALIDAD</div>

<div id="contenido_ventana" >
<form name="alta_localidad" id="alta_localidad" action="#" method="post" onsubmit= "ajax_post('contenido','localidad/procesar_alta_localidad.php', this); return false;" >
<table width="512" border="0" align="center" cellpadding="0" cellspacing="0" class="detalle_tabla"> 										
  <tr>
    <td colspan="4" align="center" class="trtitulos" > </td>
 </tr>
  <tr>
    <td width="6" align="left" class="trceleste" wid td="15" >&nbsp;</td>
    <td width="158" align="left" class="trceleste" wid td="116" >PROVINCIA </td>
    <td width="129" align="left" class="trceleste" wid td="60" ><input name="id_provincia"  disabled="disabled" type="text" id="id_provincia" size="30" value="<?php echo $id_provincia.' - '.$provincia?>"/></td>
  </tr>
  <tr  >
    <td  align="left" class="trceleste" >&nbsp;</td>
    <td  align="left" class="trceleste" >LOCALIDAD</td>
    <td  align="left" class="trceleste" ><input name="localidad" type="text" class="td9" id="localidad" size="50"   /></td>
  </tr>
 
  <tr class="trblanco"  >
    <td height="41" colspan="4" align="center" >
      <input type="submit" value="Grabar" class="small" align="top" />  
      <input name="id_provincia" type="hidden"  value="<?php echo $id_provincia?>" /> 
       </td>
    </tr>
</table>

</form>
<div id="accion_ventana" >
  <div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"/> <a href="#" onClick="ajax_get('contenido','localidad/abm_localidad.php','');" class="small">Regresar a administracion de Localidades</a>
  </div>
</div>



</div>
</div>
		