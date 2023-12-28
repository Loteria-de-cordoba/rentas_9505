<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

/*$db->debug=true;
print_r($_POST);
echo $id_provincia;

print_r($_SESSION);*/

$variables=array();

$id_localidad= (isset($_POST['id_localidad'])) ? $_POST['id_localidad'] : '-1';
$id_provincia=1;

if(!empty($id_localidad) && $id_localidad!='-1'){
	$condicion_localidad = " AND l.id_localidad = $id_localidad ";
}else {
	$condicion_localidad = " AND 1=1 ";
}


if(!empty($id_provincia) && $id_provincia!='0'){
	$provincia = " AND l.id_provincia = $id_provincia ";
}else {
	$provincia = " AND 1=1 ";
}


if (isset($_POST['id_provincia']) && $_POST['id_provincia']!=0) {
	$id_provincia = $_POST['id_provincia'];
	$condicion_provincia = "and l.id_provincia in ($id_provincia)";
	} else {
		$id_provincia = 1;
		$condicion_provincia = "";
		}
try{	
	$rs_prov= $db->Execute("select id_provincia as codigo, descripcion 
                			from impuestos.t_provincias
							order by descripcion");
	}
	catch(exception $e){die($db->ErrorMsg());
	}


try{	
	$rs_localidad= $db->Execute(" select id_localidad as codigo, descripcion
								from impuestos.t_localidades l
									where  1= 1
									$condicion_provincia
									order by descripcion");
					}
					catch(exception $e){die($db->ErrorMsg());
					}

$_pagi_sql ="select id_localidad as codigo, descripcion
								from impuestos.t_localidades l
									where  1= 1
									$condicion_provincia
									$condicion_localidad
									order by descripcion";

$_SESSION['sql']= $_pagi_sql;
	

$_pagi_cuantos = 15; //OPCIONAL. Entero. Cantidad de registros que contendrá como máximo cada página. Por defecto está en 20.
$_pagi_conteo_alternativo=true;//OPCIONAL Booleano. Define si se utiliza mysql_num_rows() (true) o COUNT(*) (false). Por defecto está en false.
$_pagi_nav_num_enlaces=3;//OPCIONAL Entero. Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
$_pagi_nav_estilo="small_navegacion";//OPCIONAL Cadena. Contiene el nombre del estilo CSS para los enlaces de paginación. Por defecto no se especifica estilo.
$_pagi_propagar[]='id_localidad';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
$_pagi_propagar[]='id_provincia';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
@include("../paginator_adodb_oracle.inc.php"); 
///////////////////////////////////////////////////////////////////////////////////////////

?>
 
<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
<!--
.style1 {color: #000000}
-->
  </style>
  <br/>
<div id="titulo_ventana"  align="center"> LOCALIDADES POR PROVNCIAS </div>
 
 <br/>
<form action="#" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('contenido','localidad/abm_localidad.php',this); return false;">
	
<table border="0" width="30%" cellpadding="2" cellspacing="0" align="center"  >
	
    <th colspan="8" align="center" class="titulosgrandes" ></th>
    <tr class="td5" >
   	  <td width="59">Provincia</td>
      <td width="21"><?php armar_combo_seleccione_ejecutar_ajax_post($rs_prov,"id_provincia",$id_provincia,'contenido','localidad/abm_localidad.php','formulario')?></td>
      <td width="61">Localidad</td>         
	  <td width="22"> <div id="localidad"><?php armar_combo_todos($rs_localidad,"id_localidad",$id_localidad);?></div></td>
	  <td width="70" align="center"> <input name="btnbuscar" type="submit" value="Buscar" alt="buscar" align="middle" width="20" height="20"  /></td>
      <td width="107"  align="center" valign="middle"  >
    	<a href="#" onclick="window.open('localidad/listado_localidad_pdf.php?id_provincia=<?php echo $id_provincia;?>', '_blank', 'height=480, width=640, left=0, top=0, toolbar=no, menubar=no, titlebar=no, resizable=yes, scrollbars=yes')">
        <img src="image/Adobe Acrobat Distiller 7.png" width="25" height="25" border="0" />
         </a></td>
	</tr>
    
    

    <th colspan="8" align="center" class="titulosgrandes" ></th>
  
</table>
</form>
<br/>
<table border="0" width="29%" cellpadding="2" cellspacing="0" align="center"  >
<tr >
  <td colspan="4" align="center">
    <a href="#" onclick="if(document.getElementById('id_provincia').value==0){ alert('Debe seleccionar una provincia..'); } else { ajax_get('contenido','localidad/alta_localidad.php','id_provincia='+document.getElementById('id_provincia').value); } return false;"> <span class="texto3">Nueva Localidad</span><img src="image/New File.png" alt="Regresar" wid td="16" height="16" border="0"/></a></td>
</tr>
</table>
<br/>
<table width="38%" border="0" align="center">
 
<tr><td colspan="4" align="center"> <?php echo $_pagi_navegacion ."   ".$_pagi_info ?> </td></tr>
  	<th colspan="4" align="center" class="titulosgrandes" ></th>
  </tr>
  <tr class="td5">
    
    <td align="right"><div align="center">Localidad</div></td>
    
  </tr>
  <th colspan="4" align="center" class="titulosgrandes" ></th>
 
  <?php while ($row_resul = $_pagi_result->FetchNextObject($toupper=true)){?>
  <tr >
    
    <td align="right"  ><div align="left"><?php echo $row_resul->DESCRIPCION;?></div></td>
    </tr>
      <?php } ?>
  </table>
