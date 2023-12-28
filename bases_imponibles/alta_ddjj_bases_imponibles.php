<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");
 include('../jscalendar-1.0/calendario.php'); 

/*$db->debug=true;
print_r($_POST);*/

if (isset($_POST['periodo']) && $_POST['periodo']!='-1') {
      $periodo = $_POST['periodo'];
      $condicion_periodo = "and r.periodo in ($periodo)";
  } else if (isset($_GET['periodo']) && $_GET['periodo']!='-1') {
      $periodo = $_GET['periodo'];
      $condicion_periodo = "and r.periodo in ($periodo)";
  } else {
    $condicion_periodo = "";
  }


if (isset($_POST['id_sucursal']) && $_POST['id_sucursal']!='-1') {
      $id_sucursal = $_POST['id_sucursal'];
      $condicion_suc_ban = " and id_sucursal in ($id_sucursal)";
  } else if (isset($_GET['id_sucursal']) && $_GET['id_sucursal']!='-1') {
      $id_sucursal = $_GET['id_sucursal'];
      $condicion_suc_ban = " and id_sucursal in ($id_sucursal)";
  
  } else {
    $condicion_suc_ban = "and 1=0";
  }

if (isset($_POST['sum_bases_imponibles']))
      $sum_bases_imponibles = $_POST['sum_bases_imponibles'];
    
  
try{  
  $rs_periodo= $db->Execute(" SELECT distinct periodo as codigo, periodo as descripcion
                FROM IMPUESTOS.t_recaudacion
                ORDER BY PERIODO DESC ");
  }catch(exception $e){die($db->ErrorMsg());}

try{  
  $rs_sucursal= $db->Execute("SELECT id_sucursal AS CODIGO, descripcion AS DESCRIPCION
                  from  gestion.t_sucursal
                  WHERE id_sucursal IN (1,20,21,22,23,24,25,26,27,30,31,32,33)");
  }catch(exception $e){die($db->ErrorMsg());}


try{  
  $rs_agencia= $db->Execute("SELECT id_agencia AS CODIGO,  to_char(id_agencia,'00000')||' - '||nombre as descripcion 
                  FROM GESTION.T_AGENCIA
                  WHERE 1=1
                  $condicion_suc_ban
                  ORDER BY id_agencia");
  }catch(exception $e){die($db->ErrorMsg());}
?>
		
        
 <link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
 <link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
 
<div id="ventana" ><div align="center" id="titulo_ventana"> ALTA NUEVA DDJJ BASES IMPONIBLES </div></div>
<br/>

<div id="contenido">
<form name="alta_ddjj_bases_imponibles" id="alta_ddjj_bases_imponibles" action="#" method="post" onsubmit= "validar_alta_ddjj_bases_imponibles('contenido','bases_imponibles/procesar_ddjj_bases_imponibles.php', this); return false;" >

<table width="56%"  border="0" align="center"  class="detalle_tabla">
  <tr>
  	<th colspan="8" align="center" class="titulosgrandes" ></th>
  </tr>
  <tr>
    <td align="center" class="trceleste">PERIODO</td>
    <td width="73%" align="left" ><input name="periodo" type="text" class="td9" id="periodo" size="4" onchange="javascript:validar_solo_numerico(this);" value="<?php echo $periodo;?>" /></td>
  </tr>
  <tr >
    <td align="center" class="trceleste">SUCURSAL</td>
    <td width="73%" align="left" ><?php armar_combo_seleccione_ejecutar_ajax_post($rs_sucursal,"id_sucursal",$id_sucursal,'contenido','bases_imponibles/alta_ddjj_bases_imponibles.php','alta_ddjj_bases_imponibles');?></td>
  </tr>
  <tr >
    <td align="center" class="trceleste">AGENCIA</td>
    <td width="73%" align="left" ><?php armar_combo_seleccione($rs_agencia,"id_agencia",$id_agencia);?></td>
  </tr>
  <tr>
   	<td align="center" class="trceleste">SUM BASES IMPONIBLES</td>
    <td width="73%" align="left" ><input name="sum_bases_imponibles" type="text" class="td9" id="sum_bases_imponibles" size="10" onchange="javascript:validar_solo_numerico(this);" value="<?php echo $sum_bases_imponibles;?>"/></td>
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
  <div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"   /> <a href="#" onClick="ajax_get('contenido','bases_imponibles/abm_ddjj_bases_imponibles.php','');" class="small" >Regresar </a></div>
</div>
</div>
</div>