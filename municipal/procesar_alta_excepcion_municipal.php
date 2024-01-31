<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

//print_r($_POST);
//die();
//$db->debug=true;
// die();
//$id_provincia = $_POST['id_provincia'];
//die('iiiiiiiii');

$localidad = $_POST['descripcion'];
$porcentaje= $_POST['porcentaje'];
$periodo = $_POST['periodo'];
$accion = "alta";
$fecha_desde = $_POST['fecha_desde'];

ComenzarTransaccion($db);

try{	
	$rs = $db->Execute("select e.id_localidad
							   from IMPUESTOS.t_excepcion_municipal_kz e 
							   where e.id_localidad = $localidad
							   and e.periodo = $periodo
							   AND e.aplica_desde= to_date('$fecha_desde','dd/mm/yyyy')");
	}
	catch(exception $e){die($db->ErrorMsg());
	}

try{	
	$rs_1 = $db->Execute("Select nvl(max(periodo),0) as periodo_maximo
						From Impuestos.T_Excepcion_Municipal_Kz
						where id_localidad= $localidad
						AND aplica_desde= to_date('$fecha_desde','dd/mm/yyyy')");
}
	catch(exception $e){die($db->ErrorMsg());
}

$ok=1;

if ($rs_1->RecordCount() > 0){

	$row_resul = $rs_1->FetchNextObject($toupper=true);
	$max = $row_resul->PERIODO_MAXIMO;
	$ok=0; 
	if ($max < $periodo){ $ok=1;}
}


if ($rs->RecordCount() > 0){ ?> 

	<div id="accion_ventana" >
	 	<div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"/>
	   		<a href="#" onClick="ajax_get('contenido','municipal/abm_excepcion_municipal.php','');" class="small"> YA EXISTE IMPUESTO MUNICIPAL CARGADO PARA ESA LOCALIDAD - Regresar </a></div>
			<?php die();?>
	</div>

<?php } elseif ($ok==0) {?>
	<br><br>
	<div align="center"><img src="image/undo.png" alt="Regresar" wid td="20" height="20" border="0"/>
	   		<a href="#" onClick="ajax_get('contenido','municipal/abm_excepcion_municipal.php','');" class="small"> EL PERIODO A CARGAR ES MENOR AL PERIDO YA EXISTENTE !! - Regresar </a></div>
			<?php die();?>
	</div>

<?php }  else {	
				try {
					$db->Execute("INSERT into IMPUESTOS.t_excepcion_municipal_kz(ID_LOCALIDAD,PORCENTAJE,PERIODO,aplica_desde) 
									values (?,?,?,to_date(?,'DD/MM/YYYY'))",array($localidad, $porcentaje,$periodo,$fecha_desde));
				}catch (exception $e) {die ($db->ErrorMsg()); }

			try{ $db->Execute("INSERT INTO IMPUESTOS.t_log(usuario,periodo_cargado,porcentaje,nombre_usuario,accion,nombre_archivo)
									VALUES (?,?,?,?,?,?)",array($_SESSION[usuario],$periodo.' - '.$fecha_desde,$porcentaje,$_SESSION[nombre_usuario],$accion,
										$localidad.'- id_loc'));
			} catch (exception $e){die ($db->ErrorMsg());}
}
	
FinalizarTransaccion($db);
header("location: abm_excepcion_municipal.php"); ?>
