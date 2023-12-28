<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

/* 
$db->debug=true;
print_r($_POST); */

$periodo= (isset($_POST['periodo'])) ? $_POST['periodo'] : '0';
$suc_ban= (isset($_POST['suc_ban'])) ? $_POST['suc_ban'] : '1';
$nro_agen= (isset($_POST['nro_agen'])) ? $_POST['nro_agen'] : '0';

// $variables=array();

if (isset($_POST['periodo']) && $_POST['periodo']!='-1') {
	$periodo = $_POST['periodo'];
	$condicion_periodo = "and rM.periodo in ($periodo)";
} else if (isset($_GET['periodo']) && $_GET['periodo']!='-1') {
	$periodo = $_GET['periodo'];
	$condicion_periodo = "and rM.periodo in ($periodo)";
} else {
	$condicion_periodo = "";
}

if (isset($_POST['suc_ban']) && $_POST['suc_ban']!='0') {
			$suc_ban = $_POST['suc_ban'];
			$condicion_suc_ban = "and X.suc_ban in ($suc_ban)";
} else if (isset($_GET['suc_ban']) && $_GET['suc_ban']!='0') {
			$suc_ban = $_GET['suc_ban'];
			$condicion_suc_ban = "and X.suc_ban in ($suc_ban)";
} else {
	//$suc_ban = $_SESSION['suc_ban'];
	$condicion_suc_ban="";	
}

if (isset($_POST['nro_agen']) && $_POST['nro_agen']!='0') {
			$nro_agen = $_POST['nro_agen'];
			$condicion_nro_agen = "and X.nro_agen in ($nro_agen)";
} else if (isset($_GET['nro_agen']) && $_GET['nro_agen']!='0') {
			$nro_agen = $_GET['nro_agen'];
			$condicion_nro_agen = "and X.nro_agen in ($nro_agen)";
} else {
		$condicion_nro_agen = "";
}

$condicion_recien_entro = !isset($_POST['suc_ban']) && !isset($_GET['_pagi_pg']) ? 'AND 1=2' : '';

try{	
	$rs_periodo= $db->Execute(" SELECT distinct periodo as codigo, periodo as descripcion
								FROM IMPUESTOS.T_DGR_REPORTE_MENSUAL
								ORDER BY PERIODO DESC ");
	}catch(exception $e){die($db->ErrorMsg());}
	
try{	
	$rs_sucursal= $db->Execute("  SELECT SUC_BAN AS CODIGO, NOMBRE AS DESCRIPCION
								  from  juegos.sucursal 
								   where suc_ban in (1,20,21,22,23,24,25,26,27,30,31,32,33)");
	}catch(exception $e){die($db->ErrorMsg());}


try{	
	$rs_agencia= $db->Execute(" SELECT x.NRO_AGEN AS CODIGO,  to_char(x.nro_agen,'0000')||' - '||x.nombre as descripcion 
								  FROM JUEGOS.AGENCIA x
								  where 1=1
								  $condicion_suc_ban
								ORDER BY NRO_AGEN ");
	}catch(exception $e){die($db->ErrorMsg());}

// $variables[]=$suc_ban;
// $variables[]=$periodo;
// $variables[]=$nro_agen;

$_pagi_sql = "SELECT RM.PERIODO,
					  RM.CUIT,
					  X.SUC_BAN,
					  (S.NOMBRE ) AS sucursal,
					  X.NRO_AGEN,
					  (B.APELLIDO
					  ||' '
					  ||B.NOMBRE) AS AGENCIA
					FROM IMPUESTOS.T_DGR_REPORTE_MENSUAL RM,
					  JUEGOS.PERSAGEN X,
					  JUEGOS.PERSONA B,
					  JUEGOS.SUCURSAL S
					WHERE 1               = 1
					AND b.tipo_doc        = x.tipo_doc
					AND b.nro_doc         = x.nro_doc
					AND NVL(X.TIT_CC,'S') ='S'
					AND X.TIPO_REL        = 'TIT'
					AND RM.CUIT           = B.CUIT
					AND S.SUC_BAN         = X.SUC_BAN
         			$condicion_periodo
					$condicion_suc_ban
					$condicion_nro_agen 
					$condicion_recien_entro
		   ORDER BY RM.PERIODO, X.SUC_BAN, X.NRO_AGEN,
		  	        RM.CUIT, B.CUIT,B.APELLIDO,B.NOMBRE";

$_pagi_div='contenido';
$_pagi_cuantos = 20;
$_pagi_conteo_alternativo=true;
$_pagi_nav_num_enlaces=3;
$_pagi_nav_estilo="small_navegacion";
$_pagi_propagar[0]='suc_ban';
$_pagi_propagar[1]='periodo';
$_pagi_propagar[3]='nro_agen';

$_SESSION['sql']=$_pagi_sql;
 

 include_once("../paginator_adodb_oracle.inc.php"); 
 ?>

<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
<br/>
<div id="titulo_ventana"  align="center">SUJETOS NO PASIBLES DE PERCEPCIÓN INCISO E ART. 195 DECRETO 1205/15</div>
<br/>

<form action="#" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('contenido','ingresos_brutos/agencias_exceptuadas_rentas.php',this); return false;">
	
<table border="0" width="38%" cellpadding="2" cellspacing="0" align="center">
    <th colspan="10" align="center" class="titulosgrandes" ></th>
    <tr class="td5" >
      <td><div align="center">Periodo</div></td>   
      <td><?php armar_combo_seleccione($rs_periodo,"periodo",$periodo);?></td>
      <td><div align="center">Sucursal</div></td>   
      <td><?php armar_combo_seleccione($rs_sucursal,"suc_ban",$suc_ban);?></td>
      <td><div align="center">Agencia</div></td>   
      <td><?php armar_combo_seleccione($rs_agencia,"nro_agen",$nro_agen);?></td>
      
      <td> <div align="center"><input name="btnbuscar" type="submit" value="Buscar" alt="buscar" align="middle" width="20" height="20"/></div></td>
      <td align="center"><a href="ingresos_brutos/rentas_pdf.php?periodo=<?php echo $periodo; ?>" target="_blank"><img src="image/Adobe Acrobat Distiller 7.png" width="25" height="25" border="0" /><br /></a></td>
	</tr>
    <th colspan="10" align="center" class="titulosgrandes"></th>
</table>

<br/>
</form>

 

<table width="71%" border="0" align="center">
	<tr>
		<td colspan="6" align="center"><div class="paginador"><?php echo $_pagi_navegacion ."   ".$_pagi_info ?></div> </td>
	</tr>
		<tr><td><br/></td></tr>
		<br/>
		<th colspan="6" align="center" class="titulosgrandes" ></th>
	 
		<tr class="td5">
			<td width="16%" align="center"> <div align="center"> SUCURSAL</div></td>
			<td width="34%" align="center"> <div align="center"> AGENCIA </div></td>
			<td width="13%" align="right">  <div align="center"> CUIT    </div></td>
			<td width="12%" align="center"> <div align="center"> PERIODO </div></td>
		</tr>
		
		<th colspan="6" align="center" class="titulosgrandes"></th>

		<?php while ($row_resul = $_pagi_result->FetchNextObject($toupper=true)){?>
		<tr>
			<td align="center"><div align="LEFT">   <?php echo str_pad($row_resul->SUC_BAN, 2, "0",STR_PAD_LEFT).' - '.$row_resul->SUCURSAL;?> </div></td>
			<td align="center"><div align="LEFT">   <?php echo str_pad($row_resul->NRO_AGEN, 4, "0",STR_PAD_LEFT).' - '.$row_resul->AGENCIA;?> </div></td>
			<td align="right"><div align="center">  <?php echo $row_resul->CUIT;?></div></td>
			<td align="center"><div align="center"> <?php echo $row_resul->PERIODO ;?></div></td>
		</tr>

	<?php }?>
</table>
</div>