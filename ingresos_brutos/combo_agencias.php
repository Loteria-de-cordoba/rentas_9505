<?php session_start(); 

include("../db_conecta_adodb.inc.php");
include("../funcion.inc.php");

/*$db->debug= true;
print_r($_GET);*/
	
$suc_ban= $_GET['suc_ban'];

if (isset($_GET['nro_agen']) && $_GET['nro_agen']!=0) {
		$nro_agen = $_GET['nro_agen'];
		} else if (isset($_POST['nro_agen']) && $_POST['nro_agen']!=0) {
			$nro_agen = $_POST['nro_agen'];
			} else {
				$nro_agen = "0";
				}




try {$rs_agencia= $db->Execute("select nro_agen as codigo, lpad( nro_agen,4,0)||' - '|| nombre as descripcion 
	from juegos.v_agencia_abierta
	where suc_ban =?
	and  nro_agen < 3009 
	order by nro_agen",array($suc_ban));}
	catch (exception $e){	die ($db->ErrorMsg()); 	}	

armar_combo_ejecutar_ajax_get_seleccione_variables($rs_agencia,'nro_agen',$nro_agen,'cuit','ingresos_brutos/cuit.php','suc_ban='.$suc_ban);
	
?>