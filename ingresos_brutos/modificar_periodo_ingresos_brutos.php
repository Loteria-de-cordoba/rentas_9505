<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

/*$db->debug=true;
print_r($_POST);
print_r($_GET);
*/
try{	
	$rs_prov= $db->Execute("select id_provincia as codigo, descripcion 
                			from impuestos.t_provincias
							order by id_provincia");
	}
	catch(exception $e){die($db->ErrorMsg());
	}

try {	$rs = $db -> Execute("select porcentaje, id_provincia, tope_desde, tope_hasta, periodo 
								from impuestos.t_ing_bruto
								where id_ing_bruto = ?",array($_GET['id_ing_bruto']));
											 }	catch (exception $e) {	
												die ($db->ErrorMsg()); 
											 }
$row=$rs->FetchNextObject($toupper=true);
?>
		
        
 <link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
 <link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
 
<div id="ventana" ><div align="center" id="titulo_ventana"> MODIFICAR PERIODO INGRESOS BRUTOS </div></div>
<br/>

<div id="contenido">
<form name="alta_ingresos_brutos" id="alta_ingresos_brutos" action="#" method="post" onsubmit= "validar_alta_periodo_ing_brutos('contenido','ingresos_brutos/procesar_modif_ingresos_brutos.php', this); return false;" >

<table width="56%"  border="0" align="center"  class="detalle_tabla">
  <tr>
  	<th colspan="4" align="center" class="titulosgrandes" ></th>
  </tr>
  <tr >
    <td align="center" class="trceleste">PROVINCIA </td>
    <td width="73%" align="left" ><?php armar_combo_seleccione($rs_prov,'id_provincia',$row->ID_PROVINCIA);?> </td>
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
  <tr>
  	<th colspan="4" align="center" class="titulosgrandes" ></th>
  </tr>
  <tr class="trblanco"  >
    <td height="41" colspan="4" align="center" > <input type="submit" value="Grabar" class="small" align="top" /> </td>
    <input  type="hidden" name="id_ing_bruto" value="<?php echo $_GET['id_ing_bruto']; ?>"/>
    <input  type="hidden" name="accion" value="modificar"/>
  </tr>
</table>
</form>  

<p>&nbsp;</p>
<div id="accion_ventana" >
  <div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"   /> <a href="#" onclick="ajax_get('contenido','ingresos_brutos/abm_ingresos_brutos.php','');" class="small" >Regresar </a></div>
</div>
</div>
</div>