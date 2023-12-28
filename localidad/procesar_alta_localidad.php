<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");
//print_r($_POST);
//$db->debug=true;

$id_provincia = $_POST['id_provincia'];
$localidad = $_POST['localidad'];

ComenzarTransaccion($db);

try {
	 $rs = $db->Execute("select *
				from impuestos.t_localidades
				where descripcion = ?
				and id_provincia = ?",array(strtoupper($localidad),$id_provincia));}
		
	 catch (exception $e){	die ($db->ErrorMsg()); 	}	

if ($rs->RecordCount() == 0) {
	try { $db->Execute("insert into impuestos.t_localidades(descripcion,id_provincia) 
					values (?,?)",array(strtoupper($localidad),$id_provincia));	}
			catch (exception $e)	{	die ($db->ErrorMsg()); 		}	
} else { ?>
	<div id="accion_ventana" >
  	<div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"/>
  	<a href="#" onClick="ajax_get('contenido','localidad/abm_localidad.php','');" class="small"> YA EXISTE ESTA LOCALIDAD - Regresar </a></div>
	<?php die();?></div>
<?php }

FinalizarTransaccion($db);
header("location: abm_localidad.php");
?>
