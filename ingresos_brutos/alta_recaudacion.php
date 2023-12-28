<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

/*$db->debug=true;
print_r($_POST); */


$periodo= (isset($_POST['periodo'])) ? $_POST['periodo'] : '-1';
//echo 'periodo'.$periodo;
try{	
	$rs_periodo= $db->Execute(" SELECT distinct periodo as codigo, periodo as descripcion
								FROM IMPUESTOS.t_ing_bruto ib,
									 IMPUESTOS.t_provincias p
								WHERE ib.id_provincia = p.id_provincia
								 and IB.PERIODO not in ( select periodo from IMPUESTOS.t_recaudacion )
								ORDER BY PERIODO DESC ");
					}
					catch(exception $e){die($db->ErrorMsg());
					} 

if (isset($_POST['Generar'])){
	//llama al procedimiento para llenar la tabla recaudacion
			
		try {$rs_tmp= $db->Execute("call IMPUESTOS.p_generar_recaudacion(?)",array($periodo));}
		catch (exception $e) {die ($db->ErrorMsg());} 
		
	}	 
?>

<link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />

<br/>
<div id="titulo_ventana"  align="center">GENERAR COMISION</div>
<br/>

<form action="#"  name="formulario" id="formulario" onSubmit="ajax_post('contenido','ingresos_brutos/alta_recaudacion.php',this); return false;">
	


<table width="8%" border="0" align="center"  class="detalle_tabla">
  <th colspan="5" align="center" class="titulosgrandes" ></th>
  <tr class="td5">
   <?php /*?> <td width="38%" align="center"><div align="center">COMISION</div></td><?php */?>
    <td width="62%" align="center"><div align="center">PERIODO</div></td>
  </tr>
  <th colspan="5" align="center" class="titulosgrandes" ></th>
  <tr >
   <?php /*?> <td align="center"><input name="comision" type="text" class="td9" id="comision" size="10"  /></td><?php */?>
    <td align="center"> <?php armar_combo_seleccione($rs_periodo,"periodo",$periodo);?></td>
  </tr>
   <th colspan="5" align="center" class="titulosgrandes" ></th>
  <tr >
    <td height="46" colspan="2" align="center">
    <input name="Generar" type="submit" value="Generar" alt="Generar" align="middle" width="20" height="20"  />
    
    </td>
  </tr>
</table>
</form>
<br/>

</div>
<div id="accion_ventana" >
  <div align="center"><img src="image/undo.png" alt="Regresar" wid td="16" height="16" border="0"/> <a href="#" onClick="ajax_get('contenido','ingresos_brutos/abm_recaudacion.php','');" class="small" >Regresar </a></div>
</div>