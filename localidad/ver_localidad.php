<?php session_start();
include ("../db_conecta_adodb.inc.php");
include_once ("../funcion.inc.php");

error_reporting(E_ERROR);
ini_set("display_errors",1);

/*print_r($_GET);
$db->debug=true;*/

if ($_GET['id_provincia']!=0) {

							$id_provincia=$_GET['id_provincia'];
							
							$_pagi_sql ="select id_localidad, descripcion 
												from impuestos.t_localidades l 
												where l.id_provincia = $id_provincia
												order by 2";
							 
								$_pagi_cuantos = 15; //OPCIONAL. Entero. Cantidad de registros que contendrá como máximo cada página. Por defecto está en 20.
								$_pagi_conteo_alternativo=true;//OPCIONAL Booleano. Define si se utiliza mysql_num_rows() (true) o COUNT(*) (false). Por defecto está en false.
								$_pagi_nav_num_enlaces=3;//OPCIONAL Entero. Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
								$_pagi_nav_estilo="small_navegacion";//OPCIONAL Cadena. Contiene el nombre del estilo CSS para los enlaces de paginación. Por defecto no se especifica estilo.
								$_pagi_div="div_localidad";  

								include("../paginator_adodb_oracle.inc.php");

		
?>
<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />

<table width="57%" border="0" cellpadding="0">
<tr >
    	<td colspan="8" align="center"  ><?php echo $_pagi_navegacion ."   ".$_pagi_info ?></td>
    </tr>
    <th colspan="4" align="center" class="titulosgrandes" ></th>
<tr align="center">
     
   </tr>
  	 <?php if  ($_pagi_result->Rowcount()>0) {?> 
   			 <?php  while ($row=$_pagi_result->FetchNextObject($toupper=true)) {?>
   				 <tr>
    			   <td align="left" class="td5"> <?php echo utf8_decode($row->DESCRIPCION); ?> </td>
				 </tr>
    
 			 <?php } ?>   
   
   <?php } else { ?>
               	 <tr>	
                 	 <td align="center" class="td5"> <?php echo "NO EXISTEN LOCALIDADES PARA ESTA PROVINCIA" ?> </td>
                  </tr>     
                       
 <?php } ?> 
   
    <th colspan="4" align="center" class="titulosgrandes" ></th>  
</table>
    	 
<?php } else { 
		include('../../blanco.php');
}?>


