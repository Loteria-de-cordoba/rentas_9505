<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

//$db->debug=true;

error_reporting(E_ALL);
ini_set("display_errors",1);

$periodo= (isset($_POST['periodo']) && $_POST['periodo']!='-1' && $_POST['periodo']!='0') ? $_POST['periodo'] : null;
$id_localidad= (isset($_POST['id_localidad']) && $_POST['id_localidad']!='-1' && $_POST['id_localidad']!='0') ? $_POST['id_localidad'] : null;
$id_provincia= (isset($_POST['id_provincia']) && $_POST['id_provincia']!='-1' && $_POST['id_provincia']!='0') ? $_POST['id_provincia'] : null;

$variables=array($id_provincia,$id_localidad,$periodo);


try{	
	$rs_prov= $db->Execute("SELECT id_provincia as codigo, descripcion 
                			from impuestos.t_provincias
							order by 2");
	}
	catch(exception $e){die($db->ErrorMsg());
	}


try{	
	$rs_localidad= $db->Execute(" SELECT id_localidad as codigo, descripcion
								from impuestos.t_localidades
									where id_provincia = nvl(?,id_provincia)
									order by 2",array($id_provincia));
					}
					catch(exception $e){die($db->ErrorMsg());
					}

try{  
  $rs_periodo= $db->Execute(" SELECT distinct periodo as codigo, periodo as descripcion
                FROM IMPUESTOS.t_retencion_imp_municipal
                WHERE id_provincia = nvl(?,id_provincia)
                and id_localidad = nvl(?,id_localidad)
                ORDER BY PERIODO DESC ",array($id_provincia,$id_localidad));
  }
  catch(exception $e){
  		die($db->ErrorMsg());
  	}

$_pagi_sql ="SELECT P.ID_PROVINCIA, P.DESCRIPCION AS PROVINCIA, L.ID_LOCALIDAD,L.DESCRIPCION AS LOCALIDAD,
		im.PORCENTAJE, im.TOPE_DESDE, im.TOPE_HASTA, im.PERIODO, im.ID_RETENCION_IMP_MUNICIPAL,im.COD_CONCEPTO,
		C.DESCRIPCION AS CONCEPTO,to_char(im.IMPUTA_DESDE,'DD/MM/YYYY') as IMPUTA_DESDE,im.MINIMO,
		im.TIPO_IMPUTACION,im.MOMENTO_IMPUTACION,im.SOBRE_CARTELERIA
        FROM IMPUESTOS.t_retencion_imp_municipal im,
             IMPUESTOS.t_provincias p,
             KAIZEN.concepto c,
             IMPUESTOS.t_localidades l
        WHERE im.id_provincia = p.id_provincia
        AND IM.id_localidad=L.id_localidad
        and im.cod_concepto=c.cod_concepto
        and im.id_provincia=nvl(?,im.id_provincia)
        and im.id_localidad=nvl(?,im.id_localidad)
        and im.periodo=nvl(?,im.periodo)
        order by im.PERIODO desc, im.TOPE_DESDE, im.TOPE_HASTA";
			
$_SESSION['sql']= $_pagi_sql;
$_pagi_cuantos = 15; //OPCIONAL. Entero. Cantidad de registros que contendrá como máximo cada página. Por defecto está en 20.
$_pagi_conteo_alternativo=true;//OPCIONAL Booleano. Define si se utiliza mysql_num_rows() (true) o COUNT(*) (false). Por defecto está en false.
$_pagi_nav_num_enlaces=3;//OPCIONAL Entero. Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
$_pagi_nav_estilo="small_navegacion";//OPCIONAL Cadena. Contiene el nombre del estilo CSS para los enlaces de paginación. Por defecto no se especifica estilo.
$_pagi_propagar[]='id_localidad';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
$_pagi_propagar[]='id_provincia';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
$_pagi_propagar[]='periodo';

@include("../paginator_adodb_oracle.inc.php"); 
///////////////////////////////////////////////////////////////////////////////////////////
?>

<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />

<br/>
<div id="titulo_ventana"  align="center"> RETENCIONES SOBRE IMPUESTO MUNICIPAL </div>

<br/>
<form action="#" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('contenido','retenciones/abm_retenciones_imp_municipal.php',this); return false;">
	
<table border="0" width="39%" cellpadding="2" cellspacing="0" align="center"  >
	
    <th colspan="8" align="center" class="titulosgrandes" ></th>
    <tr class="td5" >
   	  <td width="60">Provincia</td>
	  <td width="22"><?php armar_combo_seleccione_ejecutar_ajax_post($rs_prov,"id_provincia",$id_provincia,'contenido','retenciones/abm_retenciones_imp_municipal.php','formulario')?></td>
      <td width="62">Localidad</td>         
	  <td width="23"> <div id="localidad"><?php armar_combo_todos($rs_localidad,"id_localidad",$id_localidad);?></div></td>
	  <td> <div id="periodo"><?php armar_combo_todos($rs_periodo,"periodo",$periodo);?></div></td>
	  <td width="71" align="center"> <input name="btnbuscar" type="submit" value="Buscar" alt="buscar" align="middle" width="20" height="20"  /></td>
      <td width="221"  align="center" valign="middle"  >
    	<!--<a href="#" onclick="window.open('municipal/listado_excep_municipal.php', '_blank', 'height=480, width=640, left=0, top=0, toolbar=no, menubar=no, titlebar=no, resizable=yes, scrollbars=yes')"><img src="image/Adobe Acrobat Distiller 7.png" width="25" height="25" border="0" /> </a>--></td>
	</tr>
    
    

    <th colspan="8" align="center" class="titulosgrandes" ></th>
  
</table>
</form>
<br/>
<table border="0" width="29%" cellpadding="2" cellspacing="0" align="center"  >
<tr >
  <td colspan="12" align="center">
     <a href="#" onclick="ajax_get('contenido','retenciones/alta_retencion_imp_municipal.php','')"> <span class="texto3">NUEVA RETENCIÓN</span><a href="#" onclick="ajax_get('contenido','localidad/alta_localidad.php','');"><img src="image/New File.png" alt="Regresar" wid td="16" height="16" border="0"/></td>
</tr>
</table>

<br/>
<table width="95%" border="0" align="center">
 <tr><td colspan="14" align="center"> <?php echo $_pagi_navegacion ."   ".$_pagi_info ?> </td></tr>
  	<th colspan="14" align="center" class="titulosgrandes" ></th>
  <tr class="td5">
  	<td align="center"><div align="center">Concepto </div></td>
    <td align="center"><div align="center">Provincia </div></td>
    <td align="center"><div align="center">Localidad</div></td>
    <td align="center"><div align="center">Porcentaje</div></td>
    <td align="center"><div align="center">Tope Desde</div></td>
    <td align="center"><div align="center">Tope Hasta</div></td>
    <td align="center"><div align="center">Periodo</div></td>
    <td align="center"><div align="center">Tipo Imputación</div></td>
    <td align="center"><div align="center">Momento Imputación</div></td>
    <td align="center"><div align="center">Sobre Carteler&iacute;a</div></td>
    <td align="center"><div align="center">Mínimo</div></td>
    <td align="center"><div align="center">Imputa Desde</div></td>
    <td align="center"><div align="center">Editar</div></td>
    <td align="center"><div align="center">Eliminar</div></td>
  </tr>
  <th colspan="14" align="center" class="titulosgrandes" ></th>
 
  <?php while ($row_resul = $_pagi_result->FetchNextObject($toupper=true)){?>
  <tr>
  	<td align="left"><div align="left"><?php echo $row_resul->COD_CONCEPTO." - ".$row_resul->CONCEPTO;?> </div></td>
    <td align="center"><div align="left"><?php echo $row_resul->PROVINCIA;?></div></td>
    <td align="center"><div align="left"><?php echo $row_resul->LOCALIDAD;?></div></td>
    <td align="center"><div align="center"><?php echo number_format($row_resul->PORCENTAJE,2,',','.');?></div></td>
	<td align="center"><div align="right">$ <?php echo number_format($row_resul->TOPE_DESDE,2,',','.');?></div></td>
    <td align="center"><div align="right">$ <?php echo number_format($row_resul->TOPE_HASTA,2,',','.');?></div></td>
    <td align="center"><div align="center"><?php echo $row_resul->PERIODO;?> </div></td>
    <td align="center"><div align="center"><?php if($row_resul->TIPO_IMPUTACION == '0') echo "Diaria"; else echo "Mensual";?> </div></td>
    <td align="center"><div align="center"><?php if($row_resul->MOMENTO_IMPUTACION == '0') echo "Ult. Día del Mes"; elseif($row_resul->MOMENTO_IMPUTACION == '1') echo "Primer Día Mes Sig."; else echo "";?> </div></td>
    <td align="center"><div align="center"><?php if($row_resul->SOBRE_CARTELERIA == '1') echo "SI"; else echo "NO";?> </div></td>
    <td align="center"><div align="right">$ <?php echo number_format($row_resul->MINIMO,2,',','.');?></div></td>
    <td align="center"><div align="center"><?php echo $row_resul->IMPUTA_DESDE;?> </div></td>
    <td align="center"><div align="center"><a href="#" onClick="ajax_get('contenido','retenciones/modificar_retencion_imp_municipal.php','id_retencion_imp_municipal=<?php echo $row_resul->ID_RETENCION_IMP_MUNICIPAL;?>')"><img border="0" alt="Editar" src="image/b_edit.png" width="16" height="16"> </a></div></td>
    <td align="center"><div align="center"><a href="#" onClick="if (confirm ('Esta seguro que desea eliminar esta Retencion?')) {ajax_get('contenido','retenciones/procesar_retencion_imp_municipal.php','id_retencion_imp_municipal=<?php echo $row_resul->ID_RETENCION_IMP_MUNICIPAL;?>&accion=eliminar')}"><img border="0" alt="Eliminar" src="image/b_drop.png" width="16" height="16"> </a></div></td>  
  </tr>
  <?php } ?>
</table>

</div>