<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

/*print_r($_POST);
 $db->debug=true;
die('lllllllllllllllllllllllllllllllllllll');*/

$id_juego = $_POST['id_juego'];
$localidad = $_POST['descripcion'];
$porcentaje= $_POST['porcentaje'];
   $id_provincia = $_POST['id_provincia'];

ComenzarTransaccion($db);


try{	
	$rs = $db->Execute("select e.id_localidad, e.id_juego
							   from IMPUESTOS.t_excepcion_municipal_kz_juego e 
							   where e.id_localidad = $localidad
							   and e.id_juego = $id_juego");
	}
	catch(exception $e){die($db->ErrorMsg());
	}
	
		$row=$rs->FetchNextObject($toupper=true);
		$rs->MoveFirst();
		
if ($rs->RecordCount() > 0){ ?> 
		
		<div id="accion_ventana" >
		  <div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"/>
		   <a href="#" onClick="ajax_get('contenido','municipal/abm_excepcion_municipal_juego.php','');" class="small"> YA EXISTE IMPUESTO MUNICIPAL CARGADO PARA ESE JUEGO Y LOCALIDAD - Regresar </a></div>
			<?php die();?>
		</div>

<?php } else {
				try { $rs = $db->Execute(" SELECT impuestos.sec_excep_municipal_kz_juego.NEXTVAL AS SECUENCIA 
											FROM DUAL");
						} catch (exception $e) { die ($db->ErrorMsg());  }
					
					$row=$rs->FetchNextObject($toupper=true);
					$secuencia = $row->SECUENCIA;

				    try { $db->Execute("INSERT into IMPUESTOS.t_excepcion_municipal_kz_juego(ID_EXCEPCION,	ID_LOCALIDAD,PORCENTAJE,ID_JUEGO) 
									values (?,?,?,?)",array($secuencia,$localidad, $porcentaje, $id_juego));
					} catch (exception $e) { die ($db->ErrorMsg());  }
}
	
FinalizarTransaccion($db);
header("location: abm_excepcion_municipal_juego.php"); ?>