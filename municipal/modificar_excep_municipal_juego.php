<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

//$db->debug=true;
/*print_r($_GET);*/

$id_localidad= $_GET['id_localidad'];
$id_juego=$_GET['id_juego'];

try{	
	  $rs= $db->Execute("SELECT emj.id_localidad AS id,
						  l.descripcion        AS nombre,
						  emj.porcentaje        AS porcentaje,
						  p.descripcion        AS provincia,
						  emj.id_juego   as id_juego,
						  kzj.descripcion as juego
						  
						FROM 
						  IMPUESTOS.T_EXCEPCION_MUNICIPAL_KZ_JUEGO emj,
						  kaizen.juego kzj,
						  IMPUESTOS.t_localidades l,
						  IMPUESTOS.t_provincias p
						WHERE l.id_localidad = emj.id_localidad
						AND P.ID_PROVINCIA   = L.ID_PROVINCIA
						and kzj.cod_juego = emj.id_juego
						AND emj.id_localidad = $id_localidad
						and emj.id_juego = $id_juego
						group by kzj.descripcion, emj.id_juego, p.descripcion,l.descripcion, EMJ.PORCENTAJE, EMJ.ID_LOCALIDAD
						ORDER BY emj.id_localidad ASC ");
				}
	catch(exception $e){die($db->ErrorMsg());
	}
	$row=$rs->FetchNextObject($toupper=true);
	$rs->MoveFirst();
?>
		
        
 <link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
 <link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
 
<div id="ventana" >
  <div align="center" id="titulo_ventana"> MODIFICAR IMPUESTOS MUNICIPALES POR JUEGO</div>
</div>
<br/>

<div id="contenido">
<form name="modif_excep_juego" id="modif_excep_juego" action="#" method="post" onsubmit= "ajax_post('contenido','municipal/procesar_modif_excep_municipal_juego.php', this); return false;" >

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
   	<td align="center" class="trceleste"> JUEGO </td>
    <td width="73%" align="left" ><?php echo $row->JUEGO;?></td>
  </tr>
    <tr>
   	<td align="center" class="trceleste"> PORCENTAJE </td>
    <td align="left" > <input name="porcentaje" type="text" class="td9" id="porcentaje" size="10" value="<?php echo $row->PORCENTAJE;?>" onchange="javascript:validar_solo_numerico(this);" /> </td>
  <tr>
  	<th colspan="4" align="center" class="titulosgrandes" ></th>
  </tr>
  <tr class="trblanco"  >
    <td height="41" colspan="4" align="center" >
     <input type="hidden" value="<?php echo $row->ID;?>" align="top" id="localidad" name="localidad" />
     <input type="hidden" value="<?php echo $row->ID_JUEGO;?>" align="top" id="id_juego" name="id_juego" />

    <input type="submit" value="Modificar" class="small" align="top" /></td>
  </tr>
</table>
</form>  

<p>&nbsp;</p>
<div id="accion_ventana" >
  <div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"   /> <a href="#" onClick="ajax_get('contenido','municipal/abm_excepcion_municipal_juego.php','');" class="small" >Regresar </a></div>
</div>
</div>
</div>