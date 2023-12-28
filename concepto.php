<?php include ("db_conecta_adodb.inc.php");
include ("funcion.inc.php");
session_start(); 
?>
<script language="javascript" src="funcion2.js"></script>
<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
<?php 
$_SESSION['script'] =  basename($_SERVER['PHP_SELF']);	
///////////////////////////////////////////////////////////////////////	
$variables[0]=$_SESSION['fecha']; //array de variables bind
$variables[1]=1; //array de variables bind
$variables[2]=$_SESSION['fecha']; //array de variables bind
$_pagi_sql = "select d.descripcion as des,c.descripcion, concurso, sum(debe) as debe, sum(haber) as haber, 
			sum(debe-haber) as saldo
			from (select * from cuenta_corriente.movimiento_cabecera 
			where cod_movimiento_cabecera in (Select min(cod_movimiento_cabecera) 
										   from cuenta_corriente.movimiento_cabecera 
										   where fecha_valor = to_date(?,'dd/mm/yyyy')
										   group by nro_liquidacion_bold)) a, cuenta_corriente.movimiento_detalle b, 
										   cuenta_corriente.juego c, cuenta_corriente.concepto d 
			where a.cod_movimiento_cabecera = b.cod_movimiento_cabecera
			and b.cod_juego = c.cod_juego
			and b.cod_concepto = d.cod_concepto
			and suc_ban = ?
			and a.activo = 'S'
			and b.activo = 'S'
			and fecha_valor = to_date(?,'dd/mm/yyyy')
			group by d.descripcion, c.descripcion, concurso
			order by d.descripcion, c.descripcion, concurso";
								
$_pagi_cuantos = 20; //OPCIONAL. Entero. Cantidad de registros que contendrá como máximo cada página. Por defecto está en 20.
$_pagi_conteo_alternativo=true;//OPCIONAL Booleano. Define si se utiliza mysql_num_rows() (true) o COUNT(*) (false). Por defecto está en false.
$_pagi_nav_num_enlaces=3;//OPCIONAL Entero. Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
$_pagi_nav_estilo="small_navegacion";//OPCIONAL Cadena. Contiene el nombre del estilo CSS para los enlaces de paginación. Por defecto no se especifica estilo.
$_pagi_propagar[0]='descripcion';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
include("paginator_adodb_oracle.inc.php"); 
///////////////////////////////////////////////////////////////////////////////////////////
?>
<?php if ($_pagi_result->RowCount()==0) { die ("<br>NO HAY MOVIMIENTOS <a href=\"index.php\">Volver </a>"); } ?>
<form action="" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('contenido','index.php',this); return false;">
	  <table width="100%" border="0">
        <tr class="td2">
          <th colspan="7" scope="col"><p>CONCEPTO</th>
        </tr>
        <tr align="center" class="td2">
          <td width="20%" scope="col">Delegacion</td>
          <td width="20%" scope="col">Concepto</td>
		  <td width="20%" scope="col">Juego</td>
          <td width="20%" scope="col">Debe</td>
          <td width="20%" scope="col">Haber</td>
        </tr>
        <?php while ($row = $_pagi_result->FetchNextObject($toupper=true)){?>
        <tr class="td">
          <td width="20%" align="center"><?php echo '1';//$row->SUC_BAN;?></td>
          <td width="20%" align="right"><?php echo $row->DES;?></td>
		  <td width="20%" align="right"><?php echo $row->DESCRIPCION;?></td>
          <td width="20%" align="right"><?php echo number_format($row->DEBE,2,',','.');?></td>
		   <?php $debet += $row->DEBE;?>
          <td width="20%" align="right"><?php echo number_format($row->HABER,2,',','.');?></td>
		   <?php $habert += $row->HABER;?>
        </tr>
        <?php  } ?>
        <tr bordercolor="#FFFFFF" class="td2">
          <td colspan="5" align="left">&nbsp;</td>
        </tr>
        <tr bordercolor="#FFFFFF" class="td3">
   	   <td colspan="5" align="center"><?php echo $_pagi_navegacion ."   ".$_pagi_info ?></td>
       </tr> 
  </table>
</form>