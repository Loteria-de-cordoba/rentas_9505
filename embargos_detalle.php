<?php include ("..//cuenta_corriente/db_conecta_adodb.inc.php");
include ("..//cuenta_corriente/funcion.inc.php");
?>
<?php 
	$_SESSION['script'] =  basename($_SERVER['PHP_SELF']);	
?> 
<script language="javascript" src="..//cuenta_corriente/funcion2.js"></script>
<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />



<table width="100%" border="0" cellspacing="0">
  <tr>
  <?php //////////////////// JUEGOS PROPIOS /////////////////////////////
  try {
    $rs = $db -> Execute("select c.descripcion, d.descripcion as des, sum(debe-haber) as saldo
			from (select * from cuenta_corriente.movimiento_cabecera 
			where cod_movimiento_cabecera in (Select min(cod_movimiento_cabecera) 
										   from cuenta_corriente.movimiento_cabecera 
										   where fecha_valor between to_date(?,'dd/mm/yyyy') and to_date(?,'dd/mm/yyyy')
										   group by nro_liquidacion_bold)) a, cuenta_corriente.movimiento_detalle b, 
										   cuenta_corriente.juego c, cuenta_corriente.concepto d 
			where a.cod_movimiento_cabecera = b.cod_movimiento_cabecera
			and b.nro_agen= ?
			and b.cod_juego = c.cod_juego
			and b.cod_juego in (1,2,3)
			and b.cod_concepto = d.cod_concepto
			and b.cod_concepto in (2,3,5)
			and suc_ban = ?
			and a.activo = 'S'
			and b.activo = 'S'
			and fecha_valor between to_date(?,'dd/mm/yyyy') and to_date(?,'dd/mm/yyyy')
			group by d.descripcion, c.descripcion
			order by c.descripcion, d.descripcion",array($_POST['fecha1'],$_POST['fecha2'], $_POST['agencia'],$_POST['delegacion'],$_POST['fecha1'],$_POST['fecha2']));
	}
	catch (exception $e)
	{
	die ($db->ErrorMsg()); 
    }  
  ?>
    <td><table width="90%" border="1" align="center" cellspacing="1">
		  <tr align="center">
			<td class="td2">Juegos Propios </td>
			<td class="td2">Concepto</td>
			<td class="td2">Saldo</td>
	    </tr>
		  <tr>
		  <?php while ($row = $rs->FetchNextObject($toupper=true)){?>
			<td class="td"><?php echo $row->DESCRIPCION;?></td>
			<td class="td"><?php echo $row->DES;?></td>
			<td align="right" class="td"><?php echo number_format($row->SALDO,2,',','.');?></td>
		  </tr>
		  <?php }?>
    </table></td>
	<?php //////////////////////////// FIN JUEGOS PROPIOS //////////////////////////////////////////
	?>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <?php ////////////////////////////// JUEGOS FORANEOS ///////////////////////////////// 
  try {
    $rs = $db -> Execute("select c.descripcion, d.descripcion as des, sum(debe-haber) as saldo
			from (select * from cuenta_corriente.movimiento_cabecera 
			where cod_movimiento_cabecera in (Select min(cod_movimiento_cabecera) 
										   from cuenta_corriente.movimiento_cabecera 
										   where fecha_valor between to_date(?,'dd/mm/yyyy') and to_date(?,'dd/mm/yyyy')
										   group by nro_liquidacion_bold)) a, cuenta_corriente.movimiento_detalle b, 
										   cuenta_corriente.juego c, cuenta_corriente.concepto d 
			where a.cod_movimiento_cabecera = b.cod_movimiento_cabecera
			and b.nro_agen= ?
			and b.cod_juego = c.cod_juego
			and b.cod_juego not in (1,2,3)
			and b.cod_concepto = d.cod_concepto
			and b.cod_concepto in (2,3,5)
			and suc_ban = ?
			and a.activo = 'S'
			and b.activo = 'S'
			and fecha_valor between to_date(?,'dd/mm/yyyy') and to_date(?,'dd/mm/yyyy')
			group by d.descripcion, c.descripcion
			order by c.descripcion, d.descripcion",array($_POST['fecha1'],$_POST['fecha2'], $_POST['agencia'],$_POST['delegacion'],$_POST['fecha1'],$_POST['fecha2']));
	}
	catch (exception $e)
	{
	die ($db->ErrorMsg()); 
    }  
  ?>
    <td><table width="90%" border="1" align="center" cellspacing="1">
		  <tr align="center">
			<td class="td2">Juegos Foraneos</td>
			<td class="td2">Concepto</td>
			<td class="td2">Saldo</td>
		  </tr>
		  <tr>
			<?php while ($row = $rs->FetchNextObject($toupper=true)){?>
			<td class="td"><?php echo $row->DESCRIPCION;?></td>
			<td class="td"><?php echo $row->DES;?></td>
			<td align="right" class="td"><?php echo number_format($row->SALDO,2,',','.');?>s</td>
		  </tr>
		  <?php }?>
		 
    </table></td>
  </tr>
</table>
