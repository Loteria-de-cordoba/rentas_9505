<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

/*$db->debug=true;
print_r($_POST);  */

$periodo= (isset($_POST['periodo'])) ? $_POST['periodo'] : '-1';
$suc_ban= (isset($_POST['suc_ban'])) ? $_POST['suc_ban'] : '-1';
$nro_agen= (isset($_POST['nro_agen'])) ? $_POST['nro_agen'] : '-1';

$variables=array();


if (isset($_POST['periodo']) && $_POST['periodo']!='-1') {
			$periodo = $_POST['periodo'];
			$condicion_periodo = "and r.periodo in ($periodo)";
	} else if (isset($_GET['periodo']) && $_GET['periodo']!='-1') {
			$periodo = $_GET['periodo'];
			$condicion_periodo = "and r.periodo in ($periodo)";
	} else {
		$condicion_periodo = "";
	}


if (isset($_POST['suc_ban']) && $_POST['suc_ban']!='-1') {
			$suc_ban = $_POST['suc_ban'];
			$condicion_suc_ban = "and r.suc_ban in ($suc_ban)";
	} else if (isset($_GET['suc_ban']) && $_GET['suc_ban']!='-1') {
			$suc_ban = $_GET['suc_ban'];
			$condicion_suc_ban = "and r.suc_ban in ($suc_ban)";
	
	} else {
		$condicion_suc_ban = "";
	}

if (isset($_POST['nro_agen']) && $_POST['nro_agen']!='-1') {
			$nro_agen = $_POST['nro_agen'];
			$condicion_nro_agen = "and r.nro_agen in ($nro_agen)";
	} else if (isset($_GET['nro_agen']) && $_GET['nro_agen']!='-1') {
			$nro_agen = $_GET['nro_agen'];
			$condicion_nro_agen = "and r.nro_agen in ($nro_agen)";
	} else {
		$condicion_nro_agen = "";
	}
	
try{	
	$rs_periodo= $db->Execute(" SELECT distinct periodo as codigo, periodo as descripcion
								FROM IMPUESTOS.t_recaudacion
								WHERE 1=1
								ORDER BY PERIODO DESC ");
	}catch(exception $e){die($db->ErrorMsg());}
	
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



$_pagi_sql ="SELECT r.periodo, r.comision, r.cuit, R.SUC_BAN, s.nombre as sucursal, R.NRO_AGEN, a.nombre as agencia
						FROM IMPUESTOS.t_recaudacion r, juegos.agencia a, juegos.sucursal s
						where 1=1
						$condicion_periodo
						$condicion_suc_ban
						$condicion_nro_agen
						and r.suc_ban = s.suc_ban(+)
            			and r.suc_ban = a.suc_ban(+)
            			and r.nro_agen = a.nro_agen(+)
						order by r.periodo desc,r.comision desc, R.SUC_BAN, R.NRO_AGEN";
	

$_pagi_cuantos = 20; //OPCIONAL. Entero. Cantidad de registros que contendrá como máximo cada página. Por defecto está en 20.
$_pagi_conteo_alternativo=true;//OPCIONAL Booleano. Define si se utiliza mysql_num_rows() (true) o COUNT(*) (false). Por defecto está en false.
$_pagi_nav_num_enlaces=10;//OPCIONAL Entero. Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
$_pagi_nav_estilo="small_navegacion";//OPCIONAL Cadena. Contiene el nombre del estilo CSS para los enlaces de paginación. Por defecto no se especifica estilo.
$_pagi_propagar[]='periodo';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
$_pagi_propagar[]='nro_agen';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
$_pagi_propagar[]='suc_ban';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).

include("../paginator_adodb_oracle.inc.php"); 
?>

<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
<br/>
<div id="titulo_ventana"  align="center">COMISIONES</div>
<br/>

<form action="#" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('contenido','ingresos_brutos/abm_recaudacion.php',this); return false;">
	
<table border="0" width="38%" cellpadding="2" cellspacing="0" align="center">
    <th colspan="10" align="center" class="titulosgrandes" ></th>
    <tr class="td5" >
      <td><div align="center">Periodo</div></td>   
      <td><?php armar_combo_todos($rs_periodo,"periodo",$periodo);?></td>
      <td><div align="center">Sucursal</div></td>   
      <td><?php armar_combo_seleccione_ejecutar_ajax_post_fer($rs_sucursal,"suc_ban",$suc_ban,'contenido','ingresos_brutos/abm_recaudacion.php','formulario');?></td>
      <td><div align="center">Agencia</div></td>   
      <td><?php armar_combo_todos($rs_agencia,"nro_agen",$nro_agen);?></td>
      
      <td> <div align="center"><input name="btnbuscar" type="submit" value="Buscar" alt="buscar" align="middle" width="20" height="20"/></div></td>
      <td align="center"><a href="ingresos_brutos/recaudacion_pdf.php?periodo=<?php echo $periodo; ?>" target="_blank"><img src="image/Adobe Acrobat Distiller 7.png" width="25" height="25" border="0" /><br /></a></td>
	</tr>
    <th colspan="10" align="center" class="titulosgrandes"></th>
</table>

<br/>
</form>

<br/>
<br/>
<table width="71%" border="0" align="center">
  <tr>
  <td colspan="6" align="center"> <?php echo $_pagi_navegacion ."   ".$_pagi_info ?> </td></tr>
  		<th colspan="6" align="center" class="titulosgrandes" ></th>
  	</tr>
  <tr class="td5">
    <td width="13%" align="right"><div align="center">CUIT</div></td>
    <td width="14%" align="center"><div align="center">COMISION</div></td>
    <td width="12%" align="center"><div align="center">PERIODO</div></td>
    <td width="16%" align="center"><div align="center">SUCURSAL</div></td>
    <td width="34%" align="center"><div align="center">AGENCIA</div></td>
    <td width="11%" align="center"><div align="center">ALICUOTA</div></td>
  </tr>
  	<th colspan="6" align="center" class="titulosgrandes"></th>
 
  <?php while ($row_resul = $_pagi_result->FetchNextObject($toupper=true)){?>
  <tr>
    <td align="right"><div align="center"><?php echo $row_resul->CUIT;?></div></td>
   	   <td align="center"><div align="right"><?php echo number_format($row_resul->COMISION,2,',','.');?></div></td>
   
    <?php   $fecha = '01/01/'.$row_resul->PERIODO; 
			try{ $rs= $db->Execute("SELECT impuestos.F_ING_BRUTOS(1,to_date('$fecha','dd/mm/yyyy'),$row_resul->CUIT) as porcentaje FROM DUAL");}
			catch(exception $e){die($db->ErrorMsg());}
			$row_porcentaje = $rs->FetchNextObject($toupper=true);
	?>
    
    <td align="center"><div align="center"><?php echo $row_resul->PERIODO ;?></div></td>
       <td align="center"><div align="LEFT"><?php echo $row_resul->SUCURSAL;?> </div></td>
       <td align="center"><div align="LEFT"><?php echo str_pad($row_resul->NRO_AGEN, 4, "0",STR_PAD_LEFT).' - '.$row_resul->AGENCIA;?> </div></td>
       <td align="center"><div align="right"><?php echo $row_porcentaje->PORCENTAJE; ?></div></td>
 	</tr>
  <?php } ?>
</table>
</div>