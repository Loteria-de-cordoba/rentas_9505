<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");
include('../jscalendar-1.0/calendario.php'); 
error_reporting(E_ALL);
ini_set("display_errors",1);
//print_r($_GET);  
//$variables=array();
//$db->debug=true;
//print_r($_POST); 

$comision=0;

$suc_ban= (isset($_POST['suc_ban'])) ? $_POST['suc_ban'] : '-1';
$suc_ban= (isset($_GET['suc_ban'])) ? $_GET['suc_ban'] : '-1';
$nro_agen= (isset($_POST['nro_agen'])) ? $_POST['nro_agen'] : '-1';
$nro_agen= (isset($_GET['nro_agen'])) ? $_GET['nro_agen'] : '-1';
$cuit= (isset($_POST['cuit'])) ? $_POST['cuit'] : '-1';
$cuit= (isset($_GET['cuit'])) ? $_GET['cuit'] : '-1';

if (isset($_POST['fecha_desde']))
{
			$fecha_desde = $_POST['fecha_desde'];
			$fecha_hasta = $_POST['fecha_hasta'];
}
 else if (isset($_GET['fecha_desde']) && $_GET['fecha_desde']!="") {
			$fecha_desde = $_GET['fecha_desde'];
			$fecha_hasta = $_GET['fecha_hasta'];
} else {
			$array_fecha = FechaServer();
	  		$fecha_desde = str_pad($array_fecha["mday"],2,'0',STR_PAD_LEFT).'/'.str_pad($array_fecha["mon"],2,'0',STR_PAD_LEFT).'/'.$array_fecha["year"];
	  		$fecha_hasta = str_pad($array_fecha["mday"],2,'0',STR_PAD_LEFT).'/'.str_pad($array_fecha["mon"],2,'0',STR_PAD_LEFT).'/'.$array_fecha["year"];
}
		



if (isset($_POST['suc_ban']) && $_POST['suc_ban']!='-1') {
			$suc_ban = $_POST['suc_ban'];
			$condicion_suc_ban = "and r.suc_ban in ($suc_ban)";
			$condicion_sucursal = "and md.suc_ban in ($suc_ban)";
	} else if (isset($_GET['suc_ban']) && $_GET['suc_ban']!='-1') {
			$suc_ban = $_GET['suc_ban'];
			$condicion_suc_ban = "and r.suc_ban in ($suc_ban)";
			$condicion_sucursal = "and md.suc_ban in ($suc_ban)";
	} else {	
		$condicion_suc_ban = "";
		$condicion_sucursal = "";
	}
	

if (isset($_POST['nro_agen']) && $_POST['nro_agen']!='-1') {
			$nro_agen = $_POST['nro_agen'];
			$condicion_nro_agen = "and md.nro_agen in ($nro_agen)";
	} else if (isset($_GET['nro_agen']) && $_GET['nro_agen']!='-1') {
			$nro_agen = $_GET['nro_agen'];
			$condicion_nro_agen = "and md.nro_agen in ($nro_agen)";
	} else {
		$condicion_nro_agen = "";
	}
	
if (isset($_POST['cuit']) && $_POST['cuit']!='999') {
			$cuit = $_POST['cuit'];
			$condicion_cuit = "and ($cuit) in (select JUEGOS.f_cuit($suc_ban,$nro_agen,0) as cuit from dual)";
	} else if (isset($_GET['cuit']) && $_GET['nro_agen']!='999') {
			$cuit = $_GET['cuit'];
			$condicion_cuit = "and ($cuit) in (select JUEGOS.f_cuit($suc_ban,$nro_agen,0) as cuit from dual)";
	} else {
		$condicion_cuit = "";
	}
	
	
try{	
	$rs_sucursal= $db->Execute("  select SUC_BAN AS CODIGO, NOMBRE AS DESCRIPCION
								  from  juegos.sucursal
								  WHERE SUC_BAN IN (1,20,21,22,23,24,25,26,27,30,31,32,33)");
	}catch(exception $e){die($db->ErrorMsg());}


try{	
	$rs_agencia= $db->Execute(" SELECT R.NRO_AGEN AS CODIGO,  to_char(r.nro_agen,'0000')||' - '||r.nombre as descripcion 
								  FROM JUEGOS.AGENCIA R
								  WHERE 1=1
								  $condicion_suc_ban
								  ORDER BY NRO_AGEN ");
	}catch(exception $e){die($db->ErrorMsg());}
	
try {$rs_cuit_combo= $db->Execute("select JUEGOS.f_cuit(?,?,?) as codigo, JUEGOS.f_cuit(?,?,?) as descripcion from dual",array($suc_ban,$nro_agen,0,$suc_ban,$nro_agen,0));
	}catch (exception $e){die($db->ErrorMsg());}	


$variables[0]=$fecha_desde;
$variables[1]=$fecha_hasta; //array de variables bind

/*$_pagi_sql ="SELECT SUM(debe - haber)*-1 AS comision,
					  md.suc_ban ,
					  md.nro_agen,
					  r.nombre AS agencia,
					  s.nombre AS sucursal
				   FROM
					  kaizen.movimiento_cabecera mc,
					  kaizen.movimiento_detalle md,
					  JUEGOS.AGENCIA R,
					  juegos.sucursal s
					where mc.cod_movimiento_cabecera = md.cod_movimiento_cabecera
					and md.cod_concepto in (2,122)
					and mc.fecha_valor between to_date(?,'dd/mm/yyyy') and to_date(?,'dd/mm/yyyy')
					  $condicion_sucursal
					  $condicion_nro_agen
					 AND R.SUC_BAN  = MD.SUC_BAN
					 AND R.NRO_AGEN = MD.NRO_AGEN
					 AND s.suc_ban  = md.suc_ban	
					GROUP BY md.suc_ban, md.nro_agen, r.nombre, s.nombre 
					order by md.suc_ban, md.nro_agen, r.nombre, s.nombre  ";*/
					
$_pagi_sql ="SELECT SUM(debe - haber)*-1 AS comision,
			  md.suc_ban ,
			  md.nro_agen,
			  r.nombre AS agencia,
			  s.nombre AS sucursal, 
			  to_char(mc.fecha_valor,'MONTH') as mes, 
			  to_char(mc.fecha_valor,'YYYY') as anio, 
			  to_char(mc.fecha_valor,'MM') as mes_1,
			  to_char(p.fec_rel,'dd/mm/yyyy') as fecha_alta
			FROM kaizen.movimiento_cabecera mc,
			  kaizen.movimiento_detalle md,
			  JUEGOS.AGENCIA R,
			  juegos.sucursal s,
			  juegos.persagen p
			WHERE mc.cod_movimiento_cabecera = md.cod_movimiento_cabecera
			AND md.cod_concepto             IN (2,122)
			and mc.fecha_valor between to_date(?,'dd/mm/yyyy') and to_date(?,'dd/mm/yyyy')
			$condicion_sucursal
			$condicion_nro_agen					 
			AND R.SUC_BAN   = MD.SUC_BAN
			AND R.NRO_AGEN  = MD.NRO_AGEN
			AND s.suc_ban   = md.suc_ban
			and P.SUC_BAN   = MD.SUC_BAN
			and P.NRO_AGEN  = MD.NRO_AGEN
			and p.tipo_rel = 'TIT'
			--and p.fec_rel <= mc.fecha_valor
			GROUP BY md.suc_ban, md.nro_agen, r.nombre, s.nombre, to_char(mc.fecha_valor,'MONTH'), to_char(mc.fecha_valor,'YYYY'), to_char(mc.fecha_valor,'MM'),p.fec_rel
			ORDER BY to_char(mc.fecha_valor,'YYYY'), to_char(mc.fecha_valor,'MM'), md.suc_ban,  md.nro_agen,  r.nombre,  s.nombre";			
	

$_pagi_cuantos = 20; 
$_pagi_conteo_alternativo=true;
$_pagi_nav_num_enlaces=10;
$_pagi_div="contenido";
$_pagi_nav_estilo="small_navegacion";
$_pagi_propagar[]='fecha_desde';
$_pagi_propagar[]='fecha_hasta';
$_pagi_propagar[]='suc_ban';
$_pagi_propagar[]='nro_agen';

include("../paginator_adodb_oracle.inc.php"); 

try {
	
	 $rs_comision= $db->Execute("SELECT SUM(debe - haber)*-1 AS comision
							   FROM
								  kaizen.movimiento_cabecera mc,
								  kaizen.movimiento_detalle md,
								  JUEGOS.AGENCIA R,
								  juegos.sucursal s,
									juegos.persagen p
								where mc.cod_movimiento_cabecera = md.cod_movimiento_cabecera
								and md.cod_concepto in (2,122)
								and mc.fecha_valor between to_date(?,'dd/mm/yyyy') and to_date(?,'dd/mm/yyyy')
								  $condicion_sucursal
								  $condicion_nro_agen
								 AND R.SUC_BAN  = MD.SUC_BAN
								 AND R.NRO_AGEN = MD.NRO_AGEN
								 AND s.suc_ban  = md.suc_ban
								 and P.SUC_BAN   = MD.SUC_BAN
								and P.NRO_AGEN  = MD.NRO_AGEN
								and p.tipo_rel = 'TIT'
								--and p.fec_rel <= mc.fecha_valor
								",array($fecha_desde,$fecha_hasta));
					
					
		}		catch (exception $e){	die ($db->ErrorMsg()); 	}	
		
$row = $rs_comision->FetchNextObject($toupper=true); 
$comision = $row->COMISION;


?>

<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />

<br/>
<div id="titulo_ventana"  align="center">INFORME DE COMISIONES</div>
<br/>

<form action="#" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('contenido','ingresos_brutos/informe_comisiones.php',this); return false;">
	
<table border="0" width="84%" cellpadding="2" cellspacing="0" align="center">
    <th colspan="11" align="center" class="titulosgrandes" ></th>
    <tr  valign="middle" >
      <td width="3%" height="31" align="center">Desde</td>
      <td width="28%" align="center"><?php abrir_calendario('fecha_desde',$fecha_desde) ?></td>
      <td width="3%" align="center">Hasta</td>
      <td width="29%" align="center"><?php abrir_calendario('fecha_hasta',$fecha_hasta) ?></td>
      <td width="5%" align="center">Sucursal</td>   
      <td width="10%" align="center"><?php armar_combo_seleccione_ejecutar_ajax_post_fer($rs_sucursal,'suc_ban',$suc_ban,'contenido','ingresos_brutos/informe_comisiones.php','formulario');?></td>
      <td width="5%" align="center">Agencia</td>   
      <td width="5%" align="center"><?php armar_combo_seleccione($rs_agencia,'nro_agen',$nro_agen);?></td>
      <!--<td width="5%" align="center">Cuit</td>    armar_combo_seleccione_ejecutar_ajax_post_fer($rs_agencia,'nro_agen',$nro_agen,'contenido','ingresos_brutos/informe_comisiones.php','formulario')
      <td width="5%" align="center"><?php //armar_combo_seleccione($rs_cuit_combo,'cuit',$cuit);?></td>-->
      
      
      <td width="8%" align="center"><input name="btnbuscar" type="submit" value="Buscar" alt="buscar" align="middle" width="20" height="20"/></td>
	</tr>
    <th colspan="11" align="center" class="titulosgrandes"></th>
</table>

<br/>
</form>
<table width="71%" border="0" align="center">
<tr>
 <td width="4%" align="center"><a href="ingresos_brutos/informe_comisiones_pdf.php?suc_ban=<?php echo $suc_ban;?>&fecha_desde=<?php echo $fecha_desde;?>&fecha_hasta=<?php echo $fecha_hasta;?>&nro_agen=<?php echo $nro_agen;?>&cuit=<?php echo $cuit;?>" target="_blank"><img src="image/Adobe Acrobat Distiller 7.png" width="25" height="25" border="0" /><br />
      </a></td></tr>
</table>
<br/>
<br/>
<table width="699"  border="0" align="center">
  <tr>
  <td colspan="6" align="center"> <?php echo $_pagi_navegacion ."   ".$_pagi_info ?> </td></tr>
  		<th colspan="6" align="center" class="titulosgrandes" ></th>
  	</tr>
  <tr class="td5">
    <td width="54" align="center">CUIT</td>
    <td width="97" align="center">SUCURSAL</td>
    <td width="277" align="center">AGENCIA - (fecha alta)</td>
    <td width="85" align="center">MES</td>
    <td width="77" align="center">A&Ntilde;O</td>
    <td width="83" align="center">COMISION</td>
  </tr>
  	<th colspan="6" align="center" class="titulosgrandes"></th>
 
  <?php while ($row_resul = $_pagi_result->FetchNextObject($toupper=true)){?>
  <tr>
  	<?php  try {$rs_cuit= $db->Execute("select JUEGOS.f_cuit(?,?,?) as cuit from dual",array($row_resul->SUC_BAN,$row_resul->NRO_AGEN,0));}
	catch (exception $e){die($db->ErrorMsg());}	

		if ($rs_cuit->RecordCount() > 0) {
				$row_cuit = $rs_cuit->FetchNextObject($toupper=true);
			    $cuit = $row_cuit->CUIT;}?>

	<?php switch ($row_resul->MES_1)
	{
	case 1:
	  $nombre_mes='ENERO';
	  break;
	case 2:
	  $nombre_mes='FEBRERO';
	  break;
	case 3:
	  $nombre_mes='MARZO';
	  break;
	case 4:
	  $nombre_mes='ABRIL';
	  break;
	case 5:
	  $nombre_mes='MAYO';
	  break;
	case 6:
	  $nombre_mes='JUNIO';
	  break;
	case 7:
	  $nombre_mes='JULIO';
	  break;
	case 8:
	  $nombre_mes='AGOSTO';
	  break;
	case 9:
	  $nombre_mes='SEPTIEMBRE';
	  break;
	case 10:
	  $nombre_mes='OCTUBRE';
	  break;
	case 11:
	  $nombre_mes='NOVIEMBRE';
	  break;
	case 12:
	  $nombre_mes='DICIEMBRE';
	  break;
	default:
	  $nombre_mes='S/P';
	}?>


       <td align="right"><?php echo $cuit;?></td>
   	   <td align="center"><?php echo $row_resul->SUCURSAL;?></td>
       <td align="left"><?php echo str_pad($row_resul->NRO_AGEN, 4, "0",STR_PAD_LEFT).' - '.$row_resul->AGENCIA.' ('.$row_resul->FECHA_ALTA.')';?></td>
       <td align="left"><?php echo $nombre_mes;?></td>
       <td align="left"><?php echo $row_resul->ANIO;?></td>
       <td align="right"><?php echo number_format($row_resul->COMISION,2,',','.');?></td>
 	</tr>
  <?php } ?>
</table>
</div>
<table width="699"  border="0" align="center">
<th colspan="4" align="center" class="titulosgrandes" ></th>
<tr class="td5">
  <td colspan="3" align="right" width="599"> TOTAL: </td>
  <td width="100" colspan="1" align="right"><?php echo number_format($comision,2,',','.');?></td>
 </tr>
 <th colspan="4" align="center" class="titulosgrandes" ></th>
 </table>
