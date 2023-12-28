<?php session_start();
include_once("../../ftp.inc.php");
include("../db_conecta_adodb.inc.php");
include("../funcion.inc.php");

//die("hola");
// $db->debug=true;
// print_r($_FILES);
// print_r($_GET);

$ftmp    = $_FILES['adjunto']['tmp_name'];
$fname   = $_FILES['adjunto']['name'];
$periodo = $_GET['periodo'];

// Directorio de Produccion
$_SESSION['local'] = "../impuestos/";


$_SESSION['local_file']     = $_FILES['adjunto']['tmp_name'];
$_SESSION['nombre_archivo'] = $_FILES['adjunto']['name'];

$_SESSION['archivo'] = "impuestos/";	

$archi = $_SESSION['nombre_archivo'];
$archi = '"'.$_SESSION['nombre_archivo'].'"';

//conexion//	
$conexion = ConectarFtpOracle_PRODUCCION_SUBIR_ARCHIVO($_SESSION['archivo'],$_FILES['adjunto']['tmp_name'],$_SESSION['nombre_archivo']);

if(is_string($conexion) && !empty($conexion)){
	echo "<div style='background-color:#DB8080;color:white'>".$conexion."</div>";
	die();
} 
	
 if($conexion==true){ 

		ComenzarTransaccion($db);

		try{    $ok = $db->Execute("call IMPUESTOS.PR_IMP_CSV_COMPLETO(?)",
						 array($periodo));
		} catch (exception $e){die ($db->ErrorMsg());}

		FinalizarTransaccion($db);
		
		try{ $rs_verificar_perioro = $db->Execute("SELECT count(*) as cantidad from IMPUESTOS.t_dgr_reporte_mensual
			where periodo=?",array($periodo));
		} catch (exception $e){die ($db->ErrorMsg());}
		
		$row = $rs_verificar_perioro->FetchNextObject($toupper=true); 
		$cantidad = $row->CANTIDAD;

		ComenzarTransaccion($db);

		try{ $db->Execute("INSERT INTO IMPUESTOS.t_log(usuario,periodo_cargado,inserto,nombre_usuario,nombre_archivo)
									VALUES (?,?,?,?,?)",array($_SESSION[usuario],$periodo,$cantidad,$_SESSION[nombre_usuario],$archi));
		} catch (exception $e){die ($db->ErrorMsg());}

		FinalizarTransaccion($db);?>

		<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />

		<br><br>
		<table  border="0" width="70%" align="center" cellpadding="2" cellspacing="0" >
			<th colspan="4" align="center" class="titulosgrandes"></th>
			<tr class="td5"> <td colspan="6"><br/></td></tr>
			<tr class="td5">
				<td class="box_deco" colspan="6"><p>El ARCHIVO SE HA SUBIDO CORRECTAMENTE</p></td>
			</tr>
			<tr class="td5"> <td colspan="6"><br/></td></tr>
			<tr class="td5">
				<td class="box_deco" colspan="6">
				<?php	
					if ($ok) {?>
						<p> PROCESO TERMINO CORRECTAMENTE E INSERTO REGISTROS: <?php echo $cantidad; ?></p></td>
					<?php } else { ?>
						<p> HUBO UN ERROR EN EL PROCEDIMIENTO QUE INSERTA LOS ARCHIVOS</p></td>
					<?php }?>
			</tr>
			
			<tr class="td5"> <td colspan="6"><br/></td></tr>
			<!-- <tr class="td5">
				<td class="box_deco" colspan="6"> 
					 
				<a href="#" onClick="ajax_get('contenido','ingresos_brutos/importar_excel_rentas.php','');">Regresar</a>
				 
				 </td>
				</td></tr> -->
			<th colspan="4" align="center" class="titulosgrandes"></th>
		</table>

<?php }?>

