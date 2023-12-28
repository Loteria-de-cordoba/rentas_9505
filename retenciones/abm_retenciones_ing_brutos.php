<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");   

//$db->debug=true;
//print_r($_POST); 

////

$provincia=0;
$variables=array();

$periodo= (isset($_POST['periodo'])) ? $_POST['periodo'] : '-1';
$id_sucursal= (isset($_POST['id_sucursal'])) ? $_POST['id_sucursal'] : '';
$id_agencia= (isset($_POST['id_agencia'])) ? $_POST['id_agencia'] : '';


if (isset($periodo) && $periodo!=-1) {
        $periodo = $_POST['periodo'];
        $condicion_periodo = "and ib.periodo in ($periodo)";
  } else {
    $condicion_periodo = " AND 1=1 ";
}

if (isset($id_sucursal) && $id_sucursal!='') {
  $id_sucursal = $_POST['id_sucursal'];
  $condicion_sucursal = "and s.id_sucursal in ($id_sucursal)";
  } else {
    $id_sucursal = 0;
    $condicion_sucursal = "";
}

if (isset($id_agencia) && $id_agencia!='') {
  $id_agencia = $_POST['id_agencia'];
  $condicion_agencia = "and s.id_agencia in ($id_agencia)";
  } else {
    $id_agencia = 0;
    $condicion_agencia = "";
}



try{  
  $rs_prov= $db->Execute("select id_provincia as codigo, descripcion 
                      from impuestos.t_provincias
              order by 2");
  }catch(exception $e){die($db->ErrorMsg());}


try{  
  $rs_periodo= $db->Execute(" SELECT distinct periodo as codigo, periodo as descripcion
                FROM IMPUESTOS.t_retencion_ing_bruto ib,
                   IMPUESTOS.t_provincias p
                WHERE ib.id_provincia = p.id_provincia
                $condicion_provincia 
                ORDER BY PERIODO DESC ");
  }catch(exception $e){die($db->ErrorMsg());}


$_pagi_sql ="SELECT P.ID_PROVINCIA, P.DESCRIPCION, IB.PORCENTAJE, IB.TOPE_DESDE, IB.TOPE_HASTA, IB.PERIODO, IB.ID_RETENCION_ING_BRUTO,IB.COD_CONCEPTO,C.DESCRIPCION AS CONCEPTO,to_char(IB.IMPUTA_DESDE,'DD/MM/YYYY') as imputa_desde,IB.VALIDA_CONTRA_DDJJ
        FROM IMPUESTOS.t_retencion_ing_bruto ib,
             IMPUESTOS.t_provincias p,
             KAIZEN.concepto c
        WHERE ib.id_provincia = p.id_provincia
        and ib.cod_concepto=c.cod_concepto
                  $condicion_provincia 
                  $condicion_periodo  
                order by IB.PERIODO desc, IB.TOPE_DESDE, IB.TOPE_HASTA";
  

$_pagi_cuantos = 15; //OPCIONAL. Entero. Cantidad de registros que contendrá como máximo cada página. Por defecto está en 20.
$_pagi_conteo_alternativo=true;//OPCIONAL Booleano. Define si se utiliza mysql_num_rows() (true) o COUNT(*) (false). Por defecto está en false.
$_pagi_nav_num_enlaces=3;//OPCIONAL Entero. Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
$_pagi_nav_estilo="small_navegacion";//OPCIONAL Cadena. Contiene el nombre del estilo CSS para los enlaces de paginación. Por defecto no se especifica estilo.
$_pagi_propagar[]='periodo';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
$_pagi_propagar[]='id_provincia';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).

include("../paginator_adodb_oracle.inc.php"); 
?>

<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
<br/>
<div id="titulo_ventana" align="center"> RETENCIONES SOBRE INGRESOS BRUTOS </div>
<br/>

<form action="#" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('contenido','retenciones/abm_retenciones_ing_brutos.php',this); return false;">
  
<table border="0" width="29%" cellpadding="2" cellspacing="0" align="center"  >
    <th colspan="6" align="center" class="titulosgrandes"></th>
      <tr class="td5" >
              <td>Provincia</td>
              <td><?php armar_combo_seleccione_ejecutar_ajax_post($rs_prov,"id_provincia",$id_provincia,'contenido','retenciones/abm_retenciones_ing_brutos.php','formulario')?></td>
              <td>Periodo</td>         
              <td> <div id="periodo"><?php armar_combo_todos($rs_periodo,"periodo",$periodo);?></div></td>
              <td> <input name="btnbuscar" type="submit" value="Buscar" alt="buscar" align="middle" width="20" height="20"  /></td>
 <!-- HACER PDF             <td align="center"><a href="retenciones/ingresos_brutos_pdf.php?id_provincia=<?php echo $id_provincia; ?>&periodo=<?php echo $periodo; ?>" target="_blank"><img src="image/Adobe Acrobat Distiller 7.png" width="25" height="25" border="0" /><br /></a></td>
  --> 
    </tr>
    <th colspan="6" align="center" class="titulosgrandes"></th>
</table>

</form>
<br/>
<table border="0" width="29%" cellpadding="2" cellspacing="0" align="center" >
    <tr>
      <td colspan="3" align="center"><a href="#" onclick="ajax_get('contenido','retenciones/alta_retencion_ing_brutos.php',this);"> <span class="texto3"> NUEVA RETENCION </span><img src="image/New File.png" alt="Regresar" wid td="16" height="16" border="0"/></td>
    </tr>
    
    <td width="75" align="center" valign="middle">&nbsp;</td>
</table>
<br/>

<table width="52%" border="0" align="center" >
  <tr>
      <td colspan="10" align="center"> <?php echo $_pagi_navegacion ."   ".$_pagi_info ?> </td></tr>
    <th colspan="10" align="center" class="titulosgrandes"></th>
  </tr>
    <tr class="td5">
        <td align="center"><div align="center">Concepto </div></td>
        <td align="center"><div align="center">Provincia </div></td>
        <td align="right"><div align="center">Alicuota</div></td>
        <td align="center"><div align="center">Tope Desde</div></td>
        <td align="center"><div align="center">Tope Hasta</div></td>
        <td align="center"><div align="center">Periodo</div></td>
        <td align="center"><div align="center">Sobre DDJJ</div></td>
        <td align="center"><div align="center">Imputa Desde</div></td>
        <td align="center"><div align="center">Editar</div></td>
        <td align="center"><div align="center">Eliminar</div></td>
    </tr>
      <th colspan="10" align="center" class="titulosgrandes"></th>
 
  <?php while ($row_resul = $_pagi_result->FetchNextObject($toupper=true)){?>
  <tr>
        <td align="left"><div align="left"><?php echo $row_resul->COD_CONCEPTO." - ".$row_resul->CONCEPTO;?> </div></td>
        <td align="center"><div align="center"><?php echo $row_resul->DESCRIPCION;?> </div></td>
        <td align="right"><div align="center"><?php echo $row_resul->PORCENTAJE;?>%</div>
        <td align="center"><div align="right">$ <?php echo number_format($row_resul->TOPE_DESDE,2,',','.');?></div></td>
        <td align="center"><div align="right">$ <?php echo number_format($row_resul->TOPE_HASTA,2,',','.');?></div></td>
        <td align="center"><div align="center"><?php echo $row_resul->PERIODO ;?> </div></td>
        <td align="center"><div align="center"><?php if ($row_resul->VALIDA_CONTRA_DDJJ==1) echo 'Si'; else echo 'No';?></div></td>
        <td align="center"><div align="center"><?php echo $row_resul->IMPUTA_DESDE;?> </div></td>
        <td align="center"><div align="center"><a href="#" onClick="ajax_get('contenido','retenciones/modificar_retencion_ing_brutos.php','id_retencion_ing_bruto=<?php echo $row_resul->ID_RETENCION_ING_BRUTO;?>')"><img border="0" alt="Editar" src="image/b_edit.png" width="16" height="16"> </a></div></td>
        <td align="center"><div align="center"><a href="#" onClick="if (confirm ('Esta seguro que desea eliminar esta Retencion?')) {ajax_get('contenido','retenciones/procesar_retencion_ing_brutos.php','id_retencion_ing_bruto=<?php echo $row_resul->ID_RETENCION_ING_BRUTO;?>&accion=eliminar')}"><img border="0" alt="Eliminar" src="image/b_drop.png" width="16" height="16"> </a></div></td>
  </tr>
  <?php } ?>
</table>

</div>