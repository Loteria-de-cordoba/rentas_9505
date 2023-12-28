<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

// $db->debug=true;
// print_r($_GET);

$id_localidad= $_GET['id_localidad'];
$periodo= $_GET['periodo'];

try{	
	$rs= $db->Execute("SELECT em.id_localidad AS id,
						  l.descripcion        AS nombre,
						  em.porcentaje        AS porcentaje,
						  p.descripcion        AS provincia,
              em.periodo,
              TO_CHAR(EM.APLICA_DESDE,'DD/MM/YYYY') AS APLICA_DESDE
						FROM IMPUESTOS.t_excepcion_municipal_kz em,
						  IMPUESTOS.t_localidades l,
						  IMPUESTOS.t_provincias p
						WHERE l.id_localidad = em.id_localidad
						AND P.ID_PROVINCIA   = L.ID_PROVINCIA
						and em.id_localidad = $id_localidad
            and em.periodo = $periodo
						");
				}
	catch(exception $e){die($db->ErrorMsg());
	}
	$row=$rs->FetchNextObject($toupper=true);
	$rs->MoveFirst();
?>
		
        
 <link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
 <link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
 
<div id="ventana" >
  <div align="center" id="titulo_ventana"> MODIFICAR IMPUESTOS MUNICIPALES </div>
</div>
<br/>

<div id="contenido">
<form name="modif_excep_municipal" id="modif_excep_municipal" action="#" method="post" onsubmit= "ajax_post('contenido','municipal/procesar_modif_excep_municipal.php', this); return false;" >

<table width="56%"  border="0" align="center"  class="detalle_tabla">
  <tr>
  	<th colspan="4" align="center" class="titulosgrandes" ></th>
  </tr>
  <tr >
    <td align="center" class="trceleste"> PROVINCIA </td>
    <td width="73%" align="left" ><?php echo $row->PROVINCIA;?> </td>
  </tr>
  <tr>
   	<td align="center" class="trceleste"> LOCALIDAD </td>
    <td width="73%" align="left" ><?php echo $row->NOMBRE;?> </td>
  </tr>
  <tr>
    <td align="center" class="trceleste"> PERIODO </td>
    <td align="left" ><?php echo $row->PERIODO;?> </td>
    </tr>
    <tr>
    <td align="center" class="trceleste"> APLICA DESDE </td>
    <td align="left" ><?php echo $row->APLICA_DESDE;?> </td>
    </tr>
    <tr>
   	<td align="center" class="trceleste"> PORCENTAJE </td>
    <td align="left" > <input name="porcentaje" type="text" class="td9" id="porcentaje" size="10" value="<?php echo $row->PORCENTAJE;?>" onchange="javascript:validar_solo_numerico(this);" /> </td>

  </tr>
  
    
  <tr>
  	<th colspan="4" align="center" class="titulosgrandes" ></th>
  </tr>
  <tr class="trblanco"  >
    <td height="41" colspan="4" align="center" >
    <input type="hidden" value="<?php echo $row->ID;?>" align="top" id="localidad" name="localidad" />
    <input type="hidden" value="<?php echo $row->PERIODO;?>" align="top" id="periodo" name="periodo"/>
    <input type="submit" value="Modificar" class="small" align="top" /></td>
  </tr>
</table>
</form>  

<p>&nbsp;</p>
<div id="accion_ventana" >
  <div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"   /> <a href="#" onClick="ajax_get('contenido','municipal/abm_excepcion_municipal.php','');" class="small" >Regresar </a></div>
</div>
</div>
</div>