<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

error_reporting(E_ALL);
ini_set("display_errors",1);

/*$db->debug=true;
print_r($_POST);*/

$id_localidad=-1;

$localidad=0;
$provincia=0;

$id_provincia =0;
$variables=array();

$id_localidad= (isset($_POST['id_localidad'])) ? $_POST['id_localidad'] : '-1';
$id_provincia= (isset($_POST['id_provincia'])) ? $_POST['id_provincia'] : '';
$periodo = (isset($_POST['periodo'])) ? $_POST['periodo'] : '-1';



if(!empty($id_localidad) && $id_localidad!='-1'){
	$localidad = " AND l.id_localidad = $id_localidad ";
	
}else {

	$localidad = " AND 1=1 ";
	
}

if(!empty($id_provincia) && $id_provincia!='0'){
	$provincia = " AND l.id_provincia = $id_provincia ";
}else {
	$provincia = " AND 1=1 ";
}

if(!empty($periodo) && $periodo!='-1'){
	$cond_periodo = " AND em.periodo = $periodo ";
}else {
	$cond_periodo = " AND 1=1 ";
}


if (isset($_POST['id_provincia']) && $_POST['id_provincia']!=0) {
	$id_provincia = $_POST['id_provincia'];
	$condicion_provincia = "and l.id_provincia in ($id_provincia)";
	} else {
		$id_provincia = 0;
		$condicion_provincia = "";
		}
 try{	
	$rs_prov= $db->Execute("select id_provincia as codigo, descripcion 
                			from impuestos.t_provincias
							order by 2");
	}
	catch(exception $e){die($db->ErrorMsg());
	}


try{	
	$rs_localidad= $db->Execute("SELECT id_localidad as codigo, descripcion
								from impuestos.t_localidades l
									where  1= 1
									$condicion_provincia
									order by 2");
					}
					catch(exception $e){die($db->ErrorMsg());
					}

try{	
	$rs_periodo= $db->Execute("SELECT periodo as codigo, periodo as descripcion
								from impuestos.t_excepcion_municipal_kz l
									group by periodo
									order by 2 desc");
					}
					catch(exception $e){die($db->ErrorMsg());
					}

$_pagi_sql ="SELECT em.id_localidad AS id,
			  l.descripcion        AS nombre,
			  em.porcentaje        AS porcentaje,
			  p.descripcion        AS provincia,
			  em.periodo,
			  TO_CHAR(em.aplica_desde,'DD/MM/YYYY') AS APLICA_DESDE
			FROM IMPUESTOS.t_excepcion_municipal_kz em,
			  IMPUESTOS.t_localidades l,
			  IMPUESTOS.t_provincias p
			WHERE l.id_localidad = em.id_localidad
			AND P.ID_PROVINCIA   = L.ID_PROVINCIA
			$provincia
			$localidad
			$cond_periodo
			ORDER BY 5 desc,2";
			
$_SESSION['sql']= $_pagi_sql;
	

$_pagi_cuantos = 15; //OPCIONAL. Entero. Cantidad de registros que contendrá como máximo cada página. Por defecto está en 20.
$_pagi_conteo_alternativo=true;//OPCIONAL Booleano. Define si se utiliza mysql_num_rows() (true) o COUNT(*) (false). Por defecto está en false.
$_pagi_nav_num_enlaces=3;//OPCIONAL Entero. Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
$_pagi_nav_estilo="small_navegacion";//OPCIONAL Cadena. Contiene el nombre del estilo CSS para los enlaces de paginación. Por defecto no se especifica estilo.
$_pagi_propagar[]='id_localidad';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
$_pagi_propagar[]='id_provincia';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
$_pagi_propagar[]='periodo';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
$_pagi_propagar[]='aplica_desde';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).



@include("../paginator_adodb_oracle.inc.php"); 
///////////////////////////////////////////////////////////////////////////////////////////

?>

        

<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />

 <br/>
<div id="titulo_ventana"  align="center"> IMPUESTOS MUNICIPALES </div>

<br/>
<form action="#" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('contenido','municipal/abm_excepcion_municipal.php',this); return false;">
	
<table border="0" width="39%" cellpadding="2" cellspacing="0" align="center"  >
	
    <th colspan="9" align="center" class="titulosgrandes" ></th>
    <tr class="td5" >
   	  <td width="60">Provincia</td>
	  <td width="22"><?php armar_combo_seleccione_ejecutar_ajax_post($rs_prov,"id_provincia",$id_provincia,'contenido','municipal/abm_excepcion_municipal.php','formulario')?></td>
      <td width="62">Localidad</td>         
	  <td width="23"> <div id="localidad"><?php armar_combo_todos($rs_localidad,"id_localidad",$id_localidad);?></div></td>
	  <td width="23"> <div id="periodo"> <?php armar_combo_seleccione($rs_periodo,"periodo",$periodo);?></div></td>
	  <td width="71" align="center"> <input name="btnbuscar" type="submit" value="Buscar" alt="buscar" align="middle" width="20" height="20"  /></td>
      <td width="221"  align="center" valign="middle"  >
    	<a href="#" onclick="window.open('municipal/listado_excep_municipal.php', '_blank', 'height=480, width=640, left=0, top=0, toolbar=no, menubar=no, titlebar=no, resizable=yes, scrollbars=yes')"><img src="image/Adobe Acrobat Distiller 7.png" width="25" height="25" border="0" /> </a></td>
	</tr>
    
    

    <th colspan="9" align="center" class="titulosgrandes" ></th>
  
</table>
</form>
<br/>
<table border="0" width="29%" cellpadding="2" cellspacing="0" align="center"  >
<tr >
  <td colspan="4" align="center">
     <a href="#" onclick="ajax_get('contenido','municipal/alta_excepcion_municipal.php','')"> <span class="texto3">Nuevo Impuesto Municipal</span><a href="#" onclick="ajax_get('contenido','localidad/alta_localidad.php','');"><img src="image/New File.png" alt="Regresar" wid td="16" height="16" border="0"/></td>
</tr>
</table>
<br/>
<table width="56%" border="0" align="center">
 
 <tr><td colspan="6" align="center"> <?php echo $_pagi_navegacion ."   ".$_pagi_info ?> </td></tr>
  	<th colspan="6" align="center" class="titulosgrandes" ></th>
  </tr>
  <tr class="td5">
    <td align="center"><div align="center">Provincia </div></td>
    <td align="right"><div align="center">Localidad</div></td>
    <td align="center"><div align="center">Porcentaje</div></td>
    <td align="center"><div align="center">Periodo</div></td>
    <td align="center"><div align="center">Aplica Desde</div></td>
    <td align="center"><div align="center">Editar</div></td>
  </tr>
  <th colspan="6" align="center" class="titulosgrandes" ></th>
 
  <?php while ($row_resul = $_pagi_result->FetchNextObject($toupper=true)){?>
  <tr >
    <td align="center" ><div align="left"><span class="td5"><?php echo $row_resul->PROVINCIA ;?></span> </div></td>
    <td align="right"  ><div align="left"><?php echo $row_resul->NOMBRE;?></div></td>
    <td align="center"  ><div align="center"><?php echo number_format($row_resul->PORCENTAJE,2,',','.');?></div></td>
  	<td align="center"  ><div align="center"><?php echo $row_resul->PERIODO;?></div></td>
  	<td align="center"  ><div align="center"><?php echo $row_resul->APLICA_DESDE;?></div></td>
    <td align="center"  ><div align="center"><a href="#" onClick="ajax_get('contenido','municipal/modificar_excep_municipal.php','id_localidad=<?php echo $row_resul->ID;?>&periodo=<?php echo $row_resul->PERIODO;?>')"><img border="0" alt="Editar" src="image/b_edit.png" width="16" height="16"> </a></div></td> 
  </tr>
  <?php } ?>
</table>

    <p >&nbsp;</p>
</div>