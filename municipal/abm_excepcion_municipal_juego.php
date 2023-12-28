<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

/*$db->debug=true;
print_r($_POST);*/ 

$localidad=0;
$provincia=0;
$juego=999;
$variables=array();


$id_localidad= (isset($_POST['id_localidad'])) ? $_POST['id_localidad'] : '';
$id_juego= (isset($_POST['id_juego'])) ? $_POST['id_juego'] : '';
$id_provincia= (isset($_POST['id_provincia'])) ? $_POST['id_provincia'] : '';


if(!empty($id_localidad) && $id_localidad!='999'){
	$localidad = " AND l.id_localidad = $id_localidad ";
	$localidad1= " AND emj.ID_localidad = $id_localidad ";
}else {

	$localidad = " AND 1=1 ";
	
}

if(!empty($id_provincia) && $id_provincia!='0'){
	$provincia = " AND l.id_provincia = $id_provincia ";
}else {
	$provincia = " AND 1=1 ";
}

if(!empty($id_juego) && $id_juego!='999'){
	$juego = " AND EMJ.ID_JUEGO  = $id_juego ";
}else {

	$juego = " AND 1=1 ";
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
	$rs_localidad= $db->Execute(" select id_localidad as codigo, descripcion
								from impuestos.t_localidades l
									where  1= 1
									$condicion_provincia
									order by 2");
					}
					catch(exception $e){die($db->ErrorMsg());
					}

try{	
	$rs_juego= $db->Execute("SELECT cod_juego AS codigo,  descripcion 
                				from kaizen.juego
										order by 2");
	}
	catch(exception $e){die($db->ErrorMsg());
	}


$_pagi_sql ="SELECT emj.id_localidad AS id,
						  l.descripcion        AS nombre,
						  emj.porcentaje        AS porcentaje,
						  p.descripcion        AS provincia,
						  emj.id_juego   as id_juego,
						 kzj.descripcion as juego
						  
						FROM 
						  IMPUESTOS.T_EXCEPCION_MUNICIPAL_KZ_JUEGO emj,
						  kaizen.juego kzj,
						  IMPUESTOS.t_localidades l,
						  IMPUESTOS.t_provincias p
						WHERE l.id_localidad = emj.id_localidad
						AND P.ID_PROVINCIA   = L.ID_PROVINCIA
						and kzj.COD_JUEGO = emj.id_juego
						$localidad
						$provincia
						$juego
						group by kzj.descripcion, emj.id_juego, p.descripcion,l.descripcion, EMJ.PORCENTAJE, EMJ.ID_LOCALIDAD
						ORDER BY emj.id_localidad ASC ";

$_SESSION['sql']= $_pagi_sql;
	 
$_pagi_cuantos = 10; //OPCIONAL. Entero. Cantidad de registros que contendrá como máximo cada página. Por defecto está en 20.
$_pagi_conteo_alternativo=true;//OPCIONAL Booleano. Define si se utiliza mysql_num_rows() (true) o COUNT(*) (false). Por defecto está en false.
$_pagi_nav_num_enlaces=3;//OPCIONAL Entero. Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
$_pagi_nav_estilo="small_navegacion";//OPCIONAL Cadena. Contiene el nombre del estilo CSS para los enlaces de paginación. Por defecto no se especifica estilo.
$_pagi_propagar[]='id_localidad';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
$_pagi_propagar[]='id_provincia';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).


include("../paginator_adodb_oracle.inc.php"); 
///////////////////////////////////////////////////////////////////////////////////////////

?>

        
 <link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
 <link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
 <br/>
<div id="titulo_ventana"  align="center"> IMPUESTOS MUNICIPALES POR JUEGOS</div>

<br/>
<form action="#" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('contenido','municipal/abm_excepcion_municipal_juego.php',this); return false;">
	
<table border="0" width="80%" cellpadding="2" cellspacing="0" align="center">
	
     <th colspan="9" align="center" class="titulosgrandes"   ></th>
    	<tr class="td5">
   	 		 <td>Provincia</td>
	 		 <td><?php armar_combo_seleccione_ejecutar_ajax_post($rs_prov,"id_provincia",$id_provincia,'contenido','municipal/abm_excepcion_municipal_juego.php','formulario')?> </td>
             <td>Localidad</td>         
	 		 <td><?php armar_combo_seleccione($rs_localidad,"id_localidad",$id_localidad);?></td>
     		 <td>Juegos</td>
	  		 <td><?php armar_combo_seleccione($rs_juego,"id_juego",$id_juego);?></td>
	 		 <td><input type="submit" alt="buscar" value="Buscar" name="btnbuscar"   width="20" height="20"></td>
             <td width="221"  align="center" valign="middle"  >
    	<a href="#" onclick="window.open('municipal/listado_excep_municipal_juego.php', '_blank', 'height=480, width=640, left=0, top=0, toolbar=no, menubar=no, titlebar=no, resizable=yes, scrollbars=yes')"><img src="image/Adobe Acrobat Distiller 7.png" width="25" height="25" border="0" /> </a></td>

		</tr>
          <th colspan="9" align="center" class="titulosgrandes" ></th>
</table>
</form>
<br/>
<table border="0" width="29%" cellpadding="2" cellspacing="0" align="center"  >
<tr >
  <td colspan="4" align="center">
     <a href="#" onclick="ajax_get('contenido','municipal/alta_excepcion_municipal_juego.php','');"> <span class="texto3">Nuevo Impuesto Municipal por Juego</span><a href="#" onclick="ajax_get('contenido','municipal/alta_excepcion_municipal_juego.php','');">
     <img src="image/New File.png" alt="Regresar" wid td="16" height="16" border="0"/></td>
</tr>
</table>

<br/>

<table width="56%" border="0" align="center">
 
 
  	<th colspan="5" align="center" class="titulosgrandes" ></th>
 
  <tr class="td5">
    <td align="center"><div align="center">Provincia </div></td>
    <td align="right"><div align="center">Localidad</div></td>
    <td align="center"><div align="center">Juego</div></td>
    <td align="center"><div align="center">Porcentaje</div></td>
    <td align="center"><div align="center">Editar</div></td>
  </tr>
  <th colspan="5" align="center" class="titulosgrandes" ></th>
  <?php while ($row_resul = $_pagi_result->FetchNextObject($toupper=true)){?>
  <tr >
    <td align="center"><div align="left"><?php echo $row_resul->PROVINCIA ;?> </div></td>
    <td align="right"><div align="left"><?php echo $row_resul->NOMBRE;?></div></td>
    <td align="center"><div align="left"><?php echo $row_resul->JUEGO;?>   </div>   </td>
    <td align="center"><div align="center"><?php echo number_format($row_resul->PORCENTAJE,2,',','.') ;?></div></td> 
    <td  align="center"><a href="#" onClick="ajax_get('contenido','municipal/modificar_excep_municipal_juego.php','id_localidad=<?php echo $row_resul->ID;?>&id_juego=<?php echo $row_resul->ID_JUEGO;?>')"><img border="0" alt="Editar" src="image/b_edit.png" width="16" height="16"> </a></td> 

  </tr>
  <?php } ?>
</table>

</div>