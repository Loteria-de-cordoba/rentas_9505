<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

 //print_r($_POST);die();
//$db->debug=true;

//die('iiiiiiiii');

$comision = $_POST['comision'];
$cuit= $_POST['cuit1'];
$periodo = $_POST['periodo'];


ComenzarTransaccion($db);
try{	
	$rs = $db->Execute("select *
							   from IMPUESTOS.t_recaudacion  
							   where cuit= $cuit
							   and periodo = $periodo");
	}
	catch(exception $e){die($db->ErrorMsg());
	}
	
if ($rs->RecordCount() > 0){ ?> 

				<div id="accion_ventana" >
  				<div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"/>
  			    <a href="#" onClick="ajax_get('contenido','municipal/abm_recaudacion.php','');" class="small"> YA EXISTE RECAUDACION CARGADA PARA ESTE PEIODO Y CUIT - Regresar </a></div>
				<?php die();?></div>

	<?php } else { 
				try {
					$db->Execute("insert into IMPUESTOS.t_recaudacion(PERIODO,COMiSION,CUIT) 
									values (?,?,?)",array($periodo,$comision,$cuit));
							}
							catch (exception $e) {die ($db->ErrorMsg()); }
 } 
	
FinalizarTransaccion($db);
header("location: abm_recaudacion.php"); ?>
