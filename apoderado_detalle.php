<?php

include ("..//cuenta_corriente/db_conecta_adodb.inc.php");
include ("..//cuenta_corriente/funcion.inc.php");
session_start(); 
?>
<?php 
	$_SESSION['script'] =  basename($_SERVER['PHP_SELF']);	
	
	
		?> 
<script language="javascript" src="..//cuenta_corriente/funcion2.js"></script>


<?php 
try{
	$rs = $db->Execute("select d.apellido, d.nombre, b.suc_ban, b.nro_agen, sum(debe) as debe, sum(haber) as haber, sum(debe-haber) as saldo
from cuenta_corriente.movimiento_detalle b, juegos.persagen c, juegos.persona d 
where c.tipo_doc= d.tipo_doc
and c.nro_doc =  d.nro_doc
and c.nro_agen = b.nro_agen
and c.tipo_rel= 'APO'
and (d.nombre like upper('%'||?||'%') or d.apellido like upper('%'||?||'%'))
and b.suc_ban = c.suc_ban
and b.activo = 'S'
group by d.apellido, d.nombre, b.suc_ban, b.nro_agen order by 3,4",array($descripcion,$descripcion));
}
catch(exception $e)
{
die($db->ErrorMsg());
}
	?>

	 <?php  
		  if ($rs->RowCount()==0) {
 			die ("<br>NO HAY MOVIMIENTOS "); 
 					}?>
<table width="90%" border="1" align="center">
  <tr>
    <td width="25%" align="center" bgcolor="#CCCCCC"><span class="Estilo2 Estilo6"><strong>Apellido</strong></span></td>
    <td width="30%" align="center" bgcolor="#CCCCCC"><span class="Estilo2 Estilo6"><strong>Nombre</strong></span></td>
    <td width="20%" align="center" bgcolor="#CCCCCC"><span class="Estilo2 Estilo6"><strong>Delegacion</strong></span></td>
    <td width="15%" align="center" bgcolor="#CCCCCC"><span class="Estilo2 Estilo6"><strong>Agencia</strong></span></td>
    <td width="10%" align="center" bgcolor="#CCCCCC"><span class="Estilo6 Estilo2"><strong>Saldo</strong></span></td>
  </tr>
  <?php while ($row = $rs->FetchNextObject($toupper=true)){?>
  <tr>
     <td width="25%"><?php echo $row->APELLIDO;?></td>
    <td width="30%"><?php echo $row->NOMBRE;?></td>
    <td width="20%"><?php echo $row->SUC_BAN;?></td>
    <td width="15%"><?php echo $row->NRO_AGEN;?></td>
    <td width="10%"><?php echo  $row->SALDO;?></td>
  </tr>
 <?php  }?>
</table>