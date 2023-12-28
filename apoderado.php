<?php include ("..//cuenta_corriente/db_conecta_adodb.inc.php");
include ("..//cuenta_corriente/funcion.inc.php");
session_start(); 
?>
<?php  $_SESSION['script'] =  basename($_SERVER['PHP_SELF']); ?> 
<?php 
if(isset($_POST['descrip'])){
	$descrip= $_POST['descrip'];
	} else if(isset($_GET['descrip'])){
		$descrip = $_GET['descrip'];
	} else {
		$descrip = "";
	}
		
?>

<table width="100%" border="0" cellspacing="0">
  <tr>
    <form action="#" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('contenido1','apoderado.php',this); return false;">
		<td><table width="100%" border="0">
      	<tr>
        <td><h4>Apoderado
            <input name="descrip" type="text" id="descrip" value="<?php echo $descrip; ?>" />
                <input type="submit" name="Submit" value="Consultar" />
                <?php  if(!isset($_POST['descrip'])) {die();}?>
                <?php 
////////////////////////////////////////////////////////////////////////
$variables[0]=$descrip; //array de variables bind
$variables[1]=$descrip; //array de variables bind
$_pagi_sql= "select d.apellido, d.nombre, b.suc_ban, b.nro_agen, sum(debe) as debe, sum(haber) as haber, sum(debe-haber) as saldo
from cuenta_corriente.movimiento_detalle b, juegos.persagen c, juegos.persona d 
where c.tipo_doc= d.tipo_doc
and c.nro_doc =  d.nro_doc
and c.nro_agen = b.nro_agen
and c.tipo_rel= 'APO'
and (d.nombre like upper('%'||?||'%') or d.apellido like upper('%'||?||'%'))
and b.suc_ban = c.suc_ban
and b.activo = 'S'
group by d.apellido, d.nombre, b.suc_ban, b.nro_agen order by 3,4";
		 
/////////////////////////////////////////////////////////////					
$_pagi_cuantos = 15; //OPCIONAL. Entero. Cantidad de registros que contendrá como máximo cada página. Por defecto está en 20.
$_pagi_conteo_alternativo=true;//OPCIONAL Booleano. Define si se utiliza mysql_num_rows() (true) o COUNT(*) (false). Por defecto está en false.
$_pagi_nav_num_enlaces=3;//OPCIONAL Entero. Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
$_pagi_nav_estilo="small_navegacion";//OPCIONAL Cadena. Contiene el nombre del estilo CSS para los enlaces de paginación. Por defecto no se especifica estilo.
$_pagi_propagar[0]='descripcion';//OPCIONAL Array de cadenas. Contiene los nombres de las variables que se quiere propagar por el url. Por defecto se propagarán todas las que ya vengan por el url (GET).
include("paginator_adodb_oracle.inc.php"); 
///////////////////////////////////////////////////////////////////////////////////////////

?>
                <?php  if($_pagi_result->RowCount()==0) {die ("<br>NO HAY MOVIMIENTOS "); }?>
        </h4></td>
      </tr>
    </table></td>
  </form>
  </tr>
  <tr>
    <td><table width="90%" border="1" align="center">
  <tr class="td3">
    <td width="25%" align="center" bgcolor="#CCCCCC"><span class="Estilo2 Estilo6"><strong>Apellido</strong></span></td>
    <td width="30%" align="center" bgcolor="#CCCCCC"><span class="Estilo2 Estilo6"><strong>Nombre</strong></span></td>
    <td width="20%" align="center" bgcolor="#CCCCCC"><span class="Estilo2 Estilo6"><strong>Delegacion</strong></span></td>
    <td width="15%" align="center" bgcolor="#CCCCCC"><span class="Estilo2 Estilo6"><strong>Agencia</strong></span></td>
    <td width="10%" align="center" bgcolor="#CCCCCC"><span class="Estilo6 Estilo2"><strong>Saldo</strong></span></td>
  </tr>
  <?php while ($row = $_pagi_result->FetchNextObject($toupper=true)){?>
  <tr class="td">
    <td><?php echo $row->APELLIDO;?></td>
    <td><?php echo $row->NOMBRE;?></td>
    <td align="center"><?php echo $row->SUC_BAN;?></td>
    <td align="center"><?php echo $row->NRO_AGEN;?></td>
    <td align="right"><?php echo  $row->SALDO;?></td>
  </tr>
    <?php }?>
  
  <tr class="td3">
    <td colspan="5" align="center"><?php echo $_pagi_navegacion ."   ".$_pagi_info ?></td>
  </tr>

</table></td>
  </tr>
</table>

