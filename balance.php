<?php include ("db_conecta_adodb.inc.php");
include ("funcion.inc.php");
session_start(); 
?>
<script language="javascript" src="funcion2.js"></script>
<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />

<form action="" method="post" enctype="multipart/form-data" name="formulario" id="formulario">
 
<?php	
$_SESSION['script'] =  basename($_SERVER['PHP_SELF']);	
try {
		 $rs = $db->Execute("select c.descripcion, concurso, sum(debe) as debe, sum(haber) as haber, sum(debe-haber) as saldo
	 from (select * from cuenta_corriente.movimiento_cabecera 
		where cod_movimiento_cabecera in (Select min(cod_movimiento_cabecera) 
										   from cuenta_corriente.movimiento_cabecera 
										   where fecha_valor = to_date(?,'dd/mm/yyyy')
										   group by nro_liquidacion_bold)) a, cuenta_corriente.movimiento_detalle b, cuenta_corriente.juego c
	 where a.cod_movimiento_cabecera = b.cod_movimiento_cabecera
	 and b.cod_juego = c.cod_juego
	 and suc_ban = ?
	 and a.activo = 'S'
	 and b.activo = 'S'
	 and fecha_valor = to_date(?,'dd/mm/yyyy')
	 group by c.descripcion,concurso order by 1",array($_SESSION['fecha'],1,$_SESSION['fecha']));
 }
 catch  (exception $e) 
 { 
 die($db->ErrorMsg());
 }
?>   
<?php  if ($rs->RowCount()==0) {
			die ("<br>NO HAY MOVIMIENTOS"); 
		}
?>
	 <table width="100%" border="0">
        <tr class="td2">
          <td colspan="7" align="center" valign="bottom" scope="col"><table width="100%" border="0">
              <tr>
                <td align="center">BALANCE</td>
                <td width="1%"><a href="#" class="Estilo3" onclick="window.open('list/prueba.php','Ventana','width=400,height=400,top=0,Left=0,menubar=no,scrollbars=yes,resizable=yes')"><img src="image/24px-Crystal_Clear_app_printer.png" alt="Imprimir" width="24" height="23" border="0" /></a></td>
              </tr>
            </table></td>
       </tr>
        <tr align="center" class="td2">
          <td width="16%" scope="col">Delegacion</td>
          <td width="14%" scope="col">Juego</td>
          <td width="14%" scope="col">Concurso</td>
          <td width="14%" scope="col">Fecha</td>
          <td width="14%" scope="col">Debe</td>
          <td width="14%" scope="col">Haber</td>
          <td width="14%" scope="col">Saldo</td>
       </tr>
		<?php while ($row = $rs->FetchNextObject($toupper=true))  {?>
        <tr class="td">
          <td width="16%" align="center"><?php echo '1'/* $_POST['suc_ban'] */;?></td>
          <td width="14%" align="left"><?php echo $row->DESCRIPCION;?></td>
          <td width="14%" align="center"><?php echo $row->CONCURSO;?></td>
          <td width="14%" align="center"><?php echo $_SESSION['fecha'];?></td>
          <td width="14%" align="right"><?php echo number_format($row->DEBE,2,',','.');?></td>
          <?php $debet += $row->DEBE;?>
		  <td width="14%" align="right"><?php echo number_format($row->HABER,2,',','.');?></td>
          <?php $habert += $row->HABER;?>
		  <td width="14%" align="right"><?php echo number_format($row->SALDO,2,',','.');?></td>
		  <?php $saldot += $row->SALDO;?>
        </tr>
        <?php  }?>
       <tr class="td2">
         <td colspan="4" align="left" valign="bottom" scope="col">Totales</td>
          <td width="14%" align="right" valign="bottom" scope="col"><?php echo number_format($debet,2,',','.');?></td>
          <td width="14%" align="right" valign="bottom" scope="col"><?php echo number_format($habert,2,',','.');?></td>
          <td width="14%" align="right" valign="bottom" scope="col"><?php echo number_format($saldot,2,',','.');?></td>
        </tr>
	</table>
</form>