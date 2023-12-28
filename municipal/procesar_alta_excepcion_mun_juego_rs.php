<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

/*print_r($_POST);
 $db->debug=true;
die('lllllllllllllllllllllllllllllllllllll');
*/
 $id_juego = $_POST['id_juego'];

if ($id_juego==-1 || $id_juego == null){
	$condicion_juego="and e.id_juego is null";
	$id_juego=null;
} else {
	$condicion_juego="and e.id_juego = $id_juego";
}
$modificar=  $_POST['modificar'];
$id_localidad = $_POST['id_localidad'];
$localidad = $_POST['descripcion'];
$porcentaje = $_POST['porcentaje'];
$id_provincia = $_POST['id_provincia'];

ComenzarTransaccion($db);

if ($modificar=='si'){
		
		try { $db->Execute("UPDATE IMPUESTOS.T_EXCEPCION_MUNICIPAL_KZ_rs e
							set PORCENTAJE =?
							where id_localidad = ?
							$condicion_juego",array($porcentaje,$id_localidad));
		} catch (exception $e) { die ($db->ErrorMsg());  }
} else {

try{	
	$rs = $db->Execute("SELECT e.id_localidad, e.id_juego
							   from IMPUESTOS.T_EXCEPCION_MUNICIPAL_KZ_rs e 
							   where e.id_localidad = $localidad
							   $condicion_juego");
 } catch(exception $e){die($db->ErrorMsg()); }
	
$row=$rs->FetchNextObject($toupper=true);
$rs->MoveFirst();
		
if ($rs->RecordCount() > 0){ ?>
		
	 
	
	<div id="accion_ventana" >
	    <div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"/>
		<a href="#" onClick="ajax_get('contenido','municipal/abm_excepcion_mun_juego_rs.php','');" class="small"> YA EXISTE EXCEPCION MUNICIPAÑ CARGADO PARA ESE JUEGO Y LOCALIDAD - Regresar </a></div>
		<?php die();?>
	</div>
<?php   
	} else {

		
		try { $db->Execute("INSERT into IMPUESTOS.T_EXCEPCION_MUNICIPAL_KZ_rs(ID_LOCALIDAD,PORCENTAJE,ID_JUEGO) 
							values (?,?,?)",array($localidad, $porcentaje, $id_juego));
		} catch (exception $e) { die ($db->ErrorMsg());  }
	}
}	

FinalizarTransaccion($db);
header("location: abm_excepcion_mun_juego_rs.php"); ?>