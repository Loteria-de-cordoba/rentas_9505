<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");   

//$db->debug=true;
//print_r($_POST); 

////

$provincia=0;
$variables=array();

$id_sucursal= (isset($_POST['id_sucursal'])) ? $_POST['id_sucursal'] : '';
$id_agencia= (isset($_POST['id_agencia'])) ? $_POST['id_agencia'] : '';


if (isset($id_sucursal) && $id_sucursal!=0 && $id_sucursal!=999 && $id_sucursal!=-1) {
  $id_sucursal = $_POST['id_sucursal'];
  $condicion_sucursal = "and d.id_sucursal in ($id_sucursal)";
  } else {
    $id_sucursal = 0;
    $condicion_sucursal = "";
}

if (isset($id_agencia) && $id_agencia!='') {
  $id_agencia = $_POST['id_agencia'];
  $condicion_agencia = "and d.id_agencia in ($id_agencia)";
  } else {
    $id_agencia = 0;
    $condicion_agencia = "";
}

try{  
  $rs_sucursal= $db->Execute(" SELECT distinct B.id_sucursal as codigo, S.DESCRIPCION as descripcion
                FROM IMPUESTOS.T_CARTELERIA B,GESTION.T_SUCURSAL S
                WHERE B.ID_SUCURSAL = S.ID_SUCURSAL
                ORDER BY 1");
  }catch(exception $e){die($db->ErrorMsg());}


$_pagi_sql ="SELECT D.ID_SUCURSAL,S.DESCRIPCION AS SUCURSAL,D.ID_AGENCIA,A.NOMBRE AS AGENCIA
             FROM IMPUESTOS.T_CARTELERIA D,GESTION.T_SUCURSAL S,GESTION.T_AGENCIA A
        WHERE D.ID_SUCURSAL=S.ID_SUCURSAL
        AND D.ID_SUCURSAL=A.ID_SUCURSAL
        AND D.ID_AGENCIA=A.ID_AGENCIA
        $condicion_sucursal
        $condicion_agencia  
        ORDER BY D.ID_SUCURSAL,D.ID_AGENCIA";
  

$_pagi_cuantos = 15; //OPCIONAL. Entero. Cantidad de registros que contendrá como máximo cada página. Por defecto está en 20.
$_pagi_conteo_alternativo=true;//OPCIONAL Booleano. Define si se utiliza mysql_num_rows() (true) o COUNT(*) (false). Por defecto está en false.
$_pagi_nav_num_enlaces=3;//OPCIONAL Entero. Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
$_pagi_nav_estilo="small_navegacion";//OPCIONAL Cadena. Contiene el nombre del estilo CSS para los enlaces de paginación. Por defecto no se especifica estilo.
$_pagi_propagar[]='periodo';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
$_pagi_propagar[]='id_sucursal';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
$_pagi_propagar[]='id_agencia';

include("../paginator_adodb_oracle.inc.php"); 
?>

<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
<br/>
<div id="titulo_ventana" align="center"> DDJJ CARTELERIA </div>
<br/>

<form action="#" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('contenido','carteleria/abm_carteleria.php',this); return false;">
  
<table border="0" width="29%" cellpadding="2" cellspacing="0" align="center"  >
    <th colspan="6" align="center" class="titulosgrandes"></th>
      <tr class="td5" >
        <td>Sucursal</td>         
        <td><?php armar_combo_todos($rs_sucursal,"id_sucursal",$id_sucursal)?></td>
        <td><input name="btnbuscar" type="submit" value="Buscar" alt="buscar" align="middle" width="20" height="20"  /></td>
      </tr>
    <th colspan="6" align="center" class="titulosgrandes"></th>
</table>

</form>
<br/>
<table border="0" width="29%" cellpadding="2" cellspacing="0" align="center" >
    <tr>
      <td colspan="3" align="center"><a href="#" onclick="ajax_get('contenido','carteleria/alta_carteleria.php',this);"> <span class="texto3"> NUEVA DDJJ CARTELERIA</span><img src="image/New File.png" alt="Regresar" wid td="16" height="16" border="0"/></td>
    </tr>
    
    <td width="75" align="center" valign="middle">&nbsp;</td>
</table>
<br/>

<table width="52%" border="0" align="center" >
  <tr>
      <td colspan="10" align="center"> <?php echo $_pagi_navegacion ."   ".$_pagi_info ?> </td></tr>
    <th colspan="10" align="center" class="titulosgrandes"></th>
  </tr>
    <tr class="td5">
        <td align="center"><div align="center">Sucursal/Delegaci&oacute;n</div></td>
        <td align="center"><div align="center">Agencia</div></td>
        <td align="center"><div align="center">Eliminar</div></td>
    </tr>
      <th colspan="10" align="center" class="titulosgrandes"></th>
 
  <?php while ($row_resul = $_pagi_result->FetchNextObject($toupper=true)){?>
  <tr>
        <td align="left"><div align="left"><?php echo $row_resul->ID_SUCURSAL." - ".$row_resul->SUCURSAL;?> </div></td>
        <td align="left"><div align="left"><?php echo $row_resul->ID_AGENCIA." - ".$row_resul->AGENCIA;?> </div></td>
        <td align="center"><div align="center"><a href="#" onClick="if (confirm ('Esta seguro que desea eliminar esta DDJJ?')) {ajax_get('contenido','carteleria/procesar_carteleria.php','id_sucursal=<?php echo $row_resul->ID_SUCURSAL;?>&id_agencia=<?php echo $row_resul->ID_AGENCIA;?>&accion=eliminar')}"><img border="0" alt="Eliminar" src="image/b_drop.png" width="16" height="16"> </a></div></td>
  </tr>
  <?php } ?>
</table>

</div>