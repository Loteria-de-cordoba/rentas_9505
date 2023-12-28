<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

/*$db->debug=true;
print_r($_GET);*/

 $id_localidad= $_GET['id_localidad'];
$id_juego=$_GET['id_juego'];
$provincia=1;

if(!empty($id_localidad) && $id_localidad!='999'){
  $localidad = " AND l.id_localidad = $id_localidad ";
  $localidad1= " AND RS.ID_localidad = $id_localidad ";
}else {
  $localidad = " AND 1=1 ";
}

if(!empty($id_provincia) && $id_provincia!='0'){
  $provincia = " AND l.id_provincia = $id_provincia ";
}else {
  $provincia = " AND 1=1 ";
}

if(!empty($id_juego) && $id_juego!='-1'){
  $juego = " AND RS.ID_JUEGO  = $id_juego ";
}else {
  $juego = " AND 1=1 ";
}

try{	
	$rs= $db->Execute("SELECT rs.id_localidad AS id,
            l.descripcion         AS nombre,
            rs.porcentaje        AS porcentaje,
            p.descripcion         AS provincia,
            rs.id_juego          AS id_juego,
            DECODE(RS.ID_JUEGO,NULL,'TODOS',kzj.descripcion)       AS juego
          FROM IMPUESTOS.T_EXCEPCION_MUNICIPAL_KZ_rs rs,
            kaizen.juego kzj,
            IMPUESTOS.t_localidades l,
            IMPUESTOS.t_provincias p
          WHERE l.id_localidad = rs.id_localidad
          AND P.ID_PROVINCIA   = L.ID_PROVINCIA
          AND RS.ID_JUEGO = KZJ.ID_JUEGO(+)
          $localidad
          $provincia
          $juego
          ORDER BY rs.id_localidad ASC");
	}catch(exception $e){die($db->ErrorMsg());}

	$row=$rs->FetchNextObject($toupper=true);
	$rs->MoveFirst();?>
        
<link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
 
<div id="ventana" >
  <div align="center" id="titulo_ventana"> MODIFICAR IMPUESTOS MUNICIPALES POR JUEGO - REGIMEN SIMPLIFICADO</div>
</div>
<br/>

<div id="contenido">
<form name="modif_excep_juego" id="modif_excep_juego" action="#" method="post" onsubmit= "ajax_post('contenido','municipal/procesar_alta_excepcion_mun_juego_rs.php', this); return false;" >

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
     <input type="hidden" value="<?php echo $row->ID;?>" align="top" id="id_localidad" name="id_localidad" />
      
     <input type="hidden" value="<?php echo $row->ID_JUEGO;?>" align="top" id="id_juego" name="id_juego" />

    <input type="submit" value="Modificar" class="small" align="top" />
    <input type="hidden" value="si" class="small" align="top" name="modificar" />
  </td>
  </tr>
</table>
</form>  

<p>&nbsp;</p>
<div id="accion_ventana" >
  <div align="center">
    <img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"   /> 
    <a href="#" onClick="ajax_get('contenido','municipal/abm_excepcion_mun_juego_rs.php','');" class="small" >Regresar </a></div>
</div>
</div>
</div>