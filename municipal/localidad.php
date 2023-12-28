<?php session_start();

include ("../db_conecta_adodb.inc.php");
include_once ("../funcion.inc.php");

/*print_r($_POST);
$db->debug=true;*/

$id_provincia=(isset($_GET['id_provincia'])) ? $_GET['id_provincia'] : '';


try{	
	$rs_localidad= $db->Execute(" select id_localidad as codigo, descripcion
								from impuestos.t_localidades
									where id_provincia = $id_provincia
									order by 2");
					}
					catch(exception $e){die($db->ErrorMsg());
					}

$row=$rs_localidad->FetchNextObject($toupper=true);
$rs_localidad->MoveFirst();


?>
 <link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
 <link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
<!--
.style2 {color: #FF0000}
-->
 </style>

<table width="82%"  border="0" align="left" >
<tr  >
    
    <td width="5%"  align="left">
   <?php if ($rs_localidad->recordcount() > 0){ armar_combo($rs_localidad,'descripcion','');?></td>
   <?php } else {?>
   
   <td width="95%" align="left" class="small_sbCopy">  NO EXISTEN LOCALIDADES PARA ESA PROVINCIA </td>
   <?php  }?>
  </tr>
 
</table>