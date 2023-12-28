<?php set_time_limit(0);?>
<?php require('encabezado.php'); ?>
<?php require('db_conecta_adodb_mysql.inc.php'); ?>
<?php require('db_conecta_adodb_jue.inc.php'); ?>
<?php include('calendario/calendario.php'); ?>
<?php print("<div id='pagecell1'>"); ?>
<?php 
switch ($_SESSION['tipo']) 
		{
		case 'administrador':
		break;
		case 'usuario':
		break;
		default:
		die("<p align='center' style='color: #FFFFCC'>Ud no tiene acceso para realizar esta operacion.....</p>
		<p align='center' style='color: #FFFFCC'>Consulte con el Administrador del Sistema. </p>");
		break;
		}
?>
<?php
$array_fecha = getdate();
	  $fecha = str_pad($array_fecha["mday"],2,'0',STR_PAD_LEFT).'/'.str_pad($array_fecha["mon"],2,'0',STR_PAD_LEFT).'/'.$array_fecha["year"].' '.str_pad($array_fecha["hours"],2,'0',STR_PAD_LEFT).':'.str_pad($array_fecha["minutes"],2,'0',STR_PAD_LEFT).':'.str_pad($array_fecha["seconds"],2,'0',STR_PAD_LEFT);
try {
	$rs_filtro = $db_jue->Execute("select
		lpad(to_char(suc_ban),2,'0')||lpad(to_char(zona),2,'0') as codigo, 
		'Sucursal->'||lpad(to_char(suc_ban),2,'0')||'  Zona->'|| lpad(to_char(zona),2,'0')||' Cantidad Agencias->  '||to_char(count(*)) as descripcion 
		from agencia group by suc_ban, zona order by suc_ban, zona");
	}
	 catch  (exception $e) 
	{ 
	 die($db_jue->ErrorMsg());
	}
if (!isset($_POST['suc_zona'])) {
	    $suc_zona = '';
		$filtro_suc_zona = "";
		?>
    <form name="form1" id="form1" action="<?php echo $PHP_SELF; ?>" method="POST" onSubmit="return validar_consulta_quiniela_recaudacion(this.fecha_desde,this.fecha_hasta)">
      <table border="0">
        <tr>
          <td><?php echo armar_combo($rs_filtro,'suc_zona',$suc_zona);?></td>
          <td><?php abrir_calendario('fecha_desde','form1',$fecha) ?></td>
          <td><?php abrir_calendario('fecha_hasta','form1',$fecha) ?></td>
          <td><input name="Envar2" type="Submit" class="small" id="Envar2" value="Consultar"></td>
        </tr>
      </table>
    </form>
	<?php
	} else {
		$suc_zona = $_POST['suc_zona'];
		$filtro_suc_zona = "and lpad(to_char(b.suc_ban),2,'0')||lpad(to_char(b.zona),2,'0') = ".$_POST['suc_zona'];
		$fecha_desde = $_POST['fecha_desde'];
		$fecha_desde_corta = substr($_POST['fecha_desde'],6,4).'-'.substr($_POST['fecha_desde'],3,2).'-'.substr($_POST['fecha_desde'],0,2);
		$fecha_hasta = $_POST['fecha_hasta'];
		$fecha_hasta_corta = substr($_POST['fecha_hasta'],6,4).'-'.substr($_POST['fecha_hasta'],3,2).'-'.substr($_POST['fecha_hasta'],0,2);
	?>
    <form name="form1" id="form1" action="<?php echo $PHP_SELF; ?>" method="POST" onSubmit="return validar_consulta_quiniela_recaudacion(this.fecha_desde,this.fecha_hasta)">
            <table border="0">
              <tr>
                <td><?php echo armar_combo($rs_filtro,'suc_zona',$suc_zona);?></td>
                <td><?php abrir_calendario('fecha_alta','form1',$fecha_desde) ?></td>
                <td><?php abrir_calendario('fecha_entrega','form1',$fecha_hasta) ?></td>
                <td><input name="Envar" type="Submit" class="small" id="Envar" value="Consultar"></td>
              </tr>
            </table>
    </form>
        <?php
		include("db_conecta_jue.inc.php");
		$link_jue=conectarse_jue();
		$cursor=sql_jue($link_jue,"select b.suc_ban, b.zona, b.nro_agen, b.nombre, b.ingbrutos, to_char(fechactu,'dd-mm-yyyy') as fechactu, 
												nvl(saldactu,0) + nvl(dif_cer,0) + nvl(dif_interes,0) + nvl(saldactu_bco,0) + nvl(dif_cer_b,0) + nvl(dif_interes_b,0) +
												nvl(saldo_pesos,0) as saldactu,
												(nvl(dif_cot_pesos_b,0) + nvl(dif_cot_pesos,0)) as saldo_bodem
												from juegos.cta a, agencia b  
												where a.suc_ban (+) = b.suc_ban
												and a.nro_agen (+) = b.nro_agen
												$filtro_suc_zona order by suc_ban, zona, nro_agen");
		?>
		<table border="0">
			  <tr align="center">
				<th colspan="16"><a href="ConsultaQuinielaRecaudacionPlano.php?fecha_desde=<?php echo $fecha_desde_corta ?>&fecha_hasta=<?php echo $fecha_hasta_corta ?>">Descargar Archivo Plano Comprimido</a></th>
			  </tr>
			  <tr align="center">
				<th>Reg</th>
				<th>Sucursal</th>
				<th>Zona</th>
				<th>Agencia</th>
				<th>Nombre</th>
				<th>Promedio Rec. Diario Quin.</th>
				<th>Entrega</th>
				<th>Devolucion</th>
				<th>Venta Neta</th>
				<th>Zona loteria</th>
				<th>Fecha Actualizacion</th>
				<th>Saldo Actual</th>
				<th>Saldo Bobem</th>
			  </tr>
			  <?php $n=0; ?>
			  <?php 
			  while ($row_gestion = ora_fetch($cursor)){ 
						$sucursal =  ora_getcolumn($cursor, 0);
						$zona = ora_getcolumn($cursor, 1);
						$agencia = ora_getcolumn($cursor, 2);
						$nombre = ora_getcolumn($cursor, 3);
						$ingbrutos = ora_getcolumn($cursor, 4);
						$fechactu = ora_getcolumn($cursor, 5);
						$saldactu = ora_getcolumn($cursor, 6);
						$saldo_bodem = ora_getcolumn($cursor, 7);
				   try {
						$rs_files = $DB_mysql->Execute("select a.sucursal, a.agencia, b.recaudacion/c.dias as promedio, d.entrega, d.devolucion
															from 
															(select * from unifiles where fecha between ? and ? and sucursal in (?) and agencia in (?) group by sucursal, agencia)  a
															left outer join  
															(select sucursal, agencia, sum(recaudacion) as recaudacion from unifiles 
																where fecha between ? and ? 																
																and cod_juego in (?,?) 
																and sucursal in (?) and agencia in (?)
																group by sucursal, agencia) b  on  a.sucursal = b.sucursal and a.agencia = b.agencia
															left outer join 
															(select sucursal, agencia, count(*) as dias from (
																		 select sucursal, agencia, fecha
																				from unifiles 
																				where fecha between ? and ? 																
																				and cod_juego in (?,?)
																				and sucursal in (?) and agencia in (?)
																				group by sucursal, agencia, fecha) a
																				group by sucursal, agencia) c on a.sucursal = c.sucursal and a.agencia = c.agencia
															left outer join 
															(select sucursal, agencia, sum(entrega) as entrega, sum(devolucion)  as devolucion from unifiles 
																			where fecha between ? and ?
																			and cod_juego in (?)
																			and sucursal in (?)  and agencia in (?) group by sucursal, agencia) d  on a.sucursal = d.sucursal and a.agencia = d.agencia",array($fecha_desde_corta,$fecha_hasta_corta,$sucursal,$agencia,$fecha_desde_corta,$fecha_hasta_corta,'QM','QU',$sucursal,$agencia,$fecha_desde_corta,$fecha_hasta_corta,'QM','QU',$sucursal,$agencia,$fecha_desde_corta,$fecha_hasta_corta,'LE',$sucursal,$agencia));
					}
					 catch  (exception $e) 
					{ 
					 die($DB_mysql->ErrorMsg());
					}
					$row = $rs_files->FetchNextObject($toupper=true);
			  ?>
			  <?php /*if ($row->ENTREGA-$row->DEVOLUCION!=0) { */ $n++; ?>
			  <tr align="right">
				<th><?php echo $n; ?>&nbsp;</th>
				<th><?php echo $sucursal; ?>&nbsp;</th>
				<th><?php echo $zona; ?>&nbsp;</th>
				<th><?php echo $agencia; ?>&nbsp;</th>
				<th><?php echo $nombre; ?>&nbsp;</th>
				<th align="left"><?php echo @number_format($row->PROMEDIO,2,',','.'); ?>&nbsp;</th>
				<th><?php echo @$row->ENTREGA; ?>&nbsp;</th>
				<th><?php echo @$row->DEVOLUCION; ?>&nbsp;</th>
				<th><?php echo @$row->ENTREGA-$row->DEVOLUCION; ?>&nbsp;</th>
				<th><?php echo $ingbrutos; ?>&nbsp;</th>
				<th align="center"><?php echo $fechactu; ?>&nbsp;</th>
				<th><?php echo number_format($saldactu,2,',','.') ?>&nbsp;</th>
				<th><?php echo number_format($saldo_bodem,2,',','.'); ?>&nbsp;</th>
			  </tr>
			  <?php /*}*/} ?>
</table>
<?php } require('pie.php'); ?>