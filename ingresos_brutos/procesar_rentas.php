<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php"); 

//print_r($_GET);
//$db->debug=true;
$periodo = $_GET['periodo'];
//die('procesarrrrrrrrrrrrr');
?>
 

<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />

<br>
<br>


 
<form name="iform2" id="iform2" method="post" class="td9" enctype="multipart/form-data" >  
	<table width="50%" align="center" border ="0">
        <th colspan="4" align="center" class="titulosgrandes"></th>
        <tr class="td5"> <td colspan="4"><br/> </td></tr>
       	<tr class="td5">
			<td colspan="4" align="center"><strong>Archivo del periodo <?php echo $periodo ?></strong></td>
        </tr>
        <tr class="td5">
            <td colspan="4">
            <iframe width="500" height="200" src="upload/uploadRentas.php?periodo=<?php echo $periodo;?>"></iframe>
            </td>    
		</tr>
        <tr class="td5">
				<td class="box_deco" colspan="6"> 
					 
				<a href="#" onClick="ajax_get('contenido','ingresos_brutos/importar_excel_rentas.php','');">Regresar</a>
				 
				 </td>
				</td></tr>
           
        <th colspan="4" align="center" class="titulosgrandes"></th>
    </table>
</form>