<?php include("../funcion.inc.php"); ?>
<?php ValidarPermiso(8); ?>
<?php 
//$key=1;
$variables[0]=$_SESSION['cod_sucursal']; //array de variables bind
$_pagi_sql = "select a.cod_caja, b.descripcion as sucursal, lpad(a.numero,6,'0') as numero, a.descripcion,
					(select sum(debe-haber) from si_asiento_cabecera x, si_asiento_detalle y, si_cuenta_automatica z
											where x.cod_asiento_cabecera = y.cod_asiento_cabecera
											and y.cod_cuenta = z.cod_cuenta
											and z.cod_cuenta_automatica in (1,5)
											and y.cod_caja = a.cod_caja
											and x.cod_sucursal = b.cod_sucursal
											and x.fecha >= (select min(fecha_valor) from si_asiento_cabecera)
					) as saldo,
					c.cod_tipo_caja, c.descripcion as tipo, d.descripcion as moneda
					from  si_caja a, si_sucursal b, si_tipo_caja c, si_moneda d, si_tipo_caja e
					where a.cod_sucursal = b.cod_sucursal
					and a.cod_tipo_caja = c.cod_tipo_caja
					and a.cod_moneda = d.cod_moneda
					and a.cod_tipo_caja = e.cod_tipo_caja
					and b.cod_sucursal = ?
					group by a.cod_caja, b.descripcion, a.numero
					order by b.descripcion, a.numero"; 
$_pagi_cuantos = 20; //OPCIONAL. Entero. Cantidad de registros que contendrá como máximo cada página. Por defecto está en 20.
$_pagi_conteo_alternativo=true;//OPCIONAL Booleano. Define si se utiliza mysql_num_rows() (true) o COUNT(*) (false). Por defecto está en false.
$_pagi_nav_num_enlaces=3;//OPCIONAL Entero. Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
$_pagi_nav_estilo="small_navegacion";//OPCIONAL Cadena. Contiene el nombre del estilo CSS para los enlaces de paginación. Por defecto no se especifica estilo.
//$_pagi_propagar[0]='_POST_descripcion';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
include("../paginator.inc.php"); 
//if (!$rs = $DB->Execute("select cod_usuario, descripcion, tipo_usuario from policor_usuario")) die($DB->ErrorMsg());
//$offset = 0; $limitrows = 2;
//$rs = $DB->SelectLimit('select * from pucara_agenda ', $limitrows, $offset);
//echo $rs->RowCount(); 
?>
<link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="33%" align="center"><img src="image/Bittorrent Plus.gif" alt="Nuevo" width="30" height="30" border="0" onClick="ajax_get('contenido','caja/agregar_caja.php','')"/><a href="#" onClick="ajax_get('contenido','caja/agregar_caja.php','')">Nuevo Registro</a></td>
    <td width="33%" align="left"><img src="image/Adobe Acrobat Distiller 7.gif" width="30" height="27" border="0" />Acrobat Reader</td>
    <td width="33%" align="center"><img src="image/Microsoft Office Excel.gif" width="30" height="27" border="0" />Microsoft Excel</td>
  </tr>
</table>
<br />
<?php
##calculo de visitante
if ($_pagi_result->RowCount()==0) { echo '<br><span class="smallTahoma"> No existen caja para consultar... '.'<a href="#" onClick="ajax_get(\'contenido\',\'caja/agregar_caja.php\',\'\')"> Agregar uno nuevo aqui</a></span><br><br>'; exit();}?>
<table width="50%" border="0" cellspacing="1" class="small">
  <tr>
    <td colspan="11" align="center"><span class="th5"><a href="#">ADMINISTRACION DE CAJAS</a> </span>: P&aacute;gina <?php echo $_pagi_navegacion.' '.$_pagi_info ?></td>
  </tr>
  <tr class="th">
    <td align="center" class="th">Numero</td>
    <td align="left" class="th">Descripcion</td>
    <td align="left" class="th">Tipo</td>
    <td align="left" class="th">Moneda</td>
    <td align="left" class="th">Sucursal</td>
    <td align="center" class="th">Saldo actual</td>
    <td align="center" class="th">Administrar</td>
    <td align="center">Eliminar</td>    
  </tr>
  <?php while ($row = $_pagi_result->FetchNextObject($toupper=true)) { ?>
  <tr class="td">
    <td align="center" valign="center"><?php echo $row->NUMERO; ?>&nbsp;</td>
    <td align="left" valign="middle"><?php echo $row->DESCRIPCION; ?>&nbsp;</td>
    <td align="left" valign="middle"><?php echo $row->TIPO; ?>&nbsp;</td>
    <td align="left" valign="middle"><?php echo $row->MONEDA; ?></td>
    <td align="left" valign="middle"><?php echo $row->SUCURSAL; ?>&nbsp;</td>
    <td align="right" valign="middle"><?php echo  number_format($row->SALDO,2,',','.'); ?>&nbsp;</td>
    <td align="center" valign="middle"><a href="#" onClick="ajax_get('contenido','<?php if($row->COD_TIPO_CAJA==1) {echo "caja/adm_movimiento_caja.php";} else {echo "caja/adm_movimiento_caja_cheque.php";} ?>','cod_caja=<?php echo $row->COD_CAJA; ?>&cod_sucursal=<?php echo $row->COD_SUCURSAL; ?>')"><img src="image/folder_16.png" alt="Administrar" width="16" height="16" border="0" /></a></td>
    <td align="center" valign="middle"><a href="#" onClick="if (confirmSubmit('<?php echo $row->SUCURSAL."-> Caja: ".$row->NUMERO; ?>')) { ajax_get('contenido','caja/eliminar_caja.php','codigo=<?php echo $row->COD_CAJA; ?>')}"><img src="image/C_DeleteState_md.png" alt="Eliminar" width="16" height="16" border="0"></a></td>
  </tr>
<?php } ?>
</table>