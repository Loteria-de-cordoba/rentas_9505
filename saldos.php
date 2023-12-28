<?php include ("db_conecta_adodb.inc.php");
include ("funcion.inc.php");
session_start(); 
?>
<table width="100%" border="0">
    <tr>
      <td>
      <form action="" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="ajax_post('contenido','index.php',this); return false;">
	  <table width="75%" border="0" align="center">
			<tr>
              <td colspan="4" align="center" bordercolor="#FFFFFF"><?php $_SESSION['script'] =  basename($_SERVER['PHP_SELF']); ?> SALDOS</td>
            </tr>
            <tr>
              <td width="25%" bordercolor="#FFFFFF"><div align="center" class="Estilo2"><a href="#" onClick="ajax_get('contenido1','agencias.php','');">Agencias</a></div></td>
              <td width="25%" bordercolor="#FFFFFF"><div align="center" class="Estilo2"><a href="#" onClick="ajax_get('contenido1','titular_detalle.php','');">Titular</a></div></td>
              <td width="25%" bordercolor="#FFFFFF"><div align="center" class="Estilo2"><a href="#" onClick="ajax_get('contenido1','apoderado.php','');">Apoderado</a></div></td>
              <td width="25%" bordercolor="#FFFFFF"><div align="center" class="Estilo2"><a href="#" onClick="ajax_get('contenido1','embargos.php','');">Consulta para Embargos </a></div></td>
            </tr>
  	  </table>
	  </form>
      </td>
    </tr>
    <tr>
      <td><div id="contenido1" ><?php //require ("agencias.php");?></div></td>
    </tr>
</table>