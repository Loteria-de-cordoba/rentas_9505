<?php session_start(); 
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

//$db->debug=true;
?>
<script language="javascript" src="funcion2.js"></script>
 <link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
 <link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
<?php 

$_pagi_sql = "select id_mep, b.descripcion as concepto, quincena, mes, anio, to_char(fechamep,'DD/MM/YYYY') as fecha_deposito, 
					monto, recargo, presentado 
					from impuestos.mep9505 a, 
					     impuestos.cuenta_deposito b
					where a.concepto = b.concepto
					order by fechamep desc";
					
$_pagi_cuantos = 20; //OPCIONAL. Entero. Cantidad de registros que contendrá como máximo cada página. Por defecto está en 20.
$_pagi_conteo_alternativo=true;//OPCIONAL Booleano. Define si se utiliza mysql_num_rows() (true) o COUNT(*) (false). Por defecto está en false.
$_pagi_nav_num_enlaces=3;//OPCIONAL Entero. Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
$_pagi_nav_estilo="small_navegacion";//OPCIONAL Cadena. Contiene el nombre del estilo CSS para los enlaces de paginación. Por defecto no se especifica estilo.
$_pagi_propagar[0]='descripcion';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).

@include("../paginator_adodb_oracle.inc.php"); 
///////////////////////////////////////////////////////////////////////////////////////////
?>
<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
<br />
<a href="#" onClick="ajax_get('contenido','mep/agregar_detalle_mep.php','');"><img src="image/Plus20.png" width="18" height="18" border="0"/></a>
<a href="#" onClick="ajax_get('contenido','mep/agregar_detalle_mep.php','');">Nuevo</a> 
<?php if ($_pagi_result->RowCount()==0) { die("<br><br><br><span class=\"small\">No existen movimientos ingresados!...</span>"); }?> 
<table width="90%" border="0" align="center">
    <tr class="td2">
      <th colspan="12" scope="col">Detalle MEP </th>
    </tr>
    <tr bordercolor="#FFFFFF" class="td3">
      <td colspan="12" align="center"><?php echo $_pagi_navegacion ."   ".$_pagi_info ?></td>
    </tr> 
    <tr align="center" class="td2">
      <td width="20%" scope="col">MEP</td>
      <td width="20%" scope="col">Concepto</td>
      <td width="20%" scope="col">Quincena</td>
      <td width="20%" scope="col">Mes</td>
      <td width="20%" scope="col"><?php echo utf8_encode("Año") ?></td>
      <td width="20%" scope="col">Fecha Deposito</td>
      <td width="20%" scope="col">Monto</td>
      <td width="20%" scope="col">Recargo</td>
      <td width="20%" scope="col">Estado</td>
      <td width="20%" scope="col">&nbsp;</td>
      <td width="20%" scope="col">&nbsp;</td>
      <td width="20%" scope="col">&nbsp;</td>
    </tr>
    <?php while ($row = $_pagi_result->FetchNextObject($toupper=true)){?>
    <tr align="center" class="td">
      <td width="20%"><?php echo $row->ID_MEP;?></td>
      <td width="20%"><?php echo $row->CONCEPTO;?></td>
      <td width="20%"><?php echo $row->QUINCENA;?></td>
      <td width="20%"><?php echo $row->MES;?></td>
      <td width="20%"><?php echo $row->ANIO;?></td>
      <td width="20%"><?php echo $row->FECHA_DEPOSITO;?></td>
      <td width="20%" align="right"><?php echo number_format($row->MONTO,2,',','.');?></td>
      <td width="20%" align="right"><?php echo number_format($row->RECARGO,2,',','.');?></td>
      <td width="20%" align="right"><?php if ($row->PRESENTADO==1) { echo "Generado"; } 	else {echo "&nbsp;"; } ?></td>
      <td width="20%" align="right"><?php if ($row->PRESENTADO==0) { ?><a href="#" onclick="ajax_get('contenido','modificar_detalle_mep.php','id_mep=<?php echo $row->ID_MEP;?>');"><img src="image/C_EditState_md - Copy.png" width="25" height="25" border="0"/></a><?php } 	else {echo "&nbsp;"; } ?></td>
      <td width="20%" align="right"><?php if ($row->PRESENTADO==0) { ?><a href="#" onclick="if (confirmSubmit('MEP: '+<?php echo $row->ID_MEP;?>)) {ajax_get('contenido','eliminar_detalle_mep.php','id_mep=<?php echo $row->ID_MEP;?>');}"><img src="image/Trash-Empty.png" width="32" height="32" border="0"/></a><?php } 	else {echo "&nbsp;"; } ?></td>
      <td width="20%" align="center"><?php if ($row->PRESENTADO==0) { ?><a href="exportar_detalle_mep.php?id_mep=<?php echo $row->ID_MEP;?>" onclick="RefrescarDetalleMep()" ><img src="image/New Document.png" width="32" height="32" border="0"/></a><?php } 	else {echo "&nbsp;"; } ?></td>
    </tr>
    <?php  } ?>
    <tr bordercolor="#FFFFFF" class="td3">
      <td colspan="12" align="center"><?php echo $_pagi_navegacion ."   ".$_pagi_info ?></td>
    </tr> 
</table>
