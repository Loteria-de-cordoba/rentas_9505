<?php session_start();
   
    include_once("../db_conecta_adodb.inc.php");
	include_once("../funcion.inc.php");

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public"); 
	header("Content-type: application/vnd.ms-excel"); 
	header("Content-Disposition: attachment; filename=excel.xls");

// ##48350## : Modificaciones Percepciones Ingresos Brutos

try {$rs= $db->Execute("SELECT a.SUC_BAN,
						  a.NRO_AGEN,
						  NOMBRE,
						  IMPUESTOS.F_ING_BRUTOS(1,SYSDATE,JUEGOS.F_CUIT(a.SUC_BAN,a.NRO_AGEN,0)) AS INGRESOS_BRUTOS,
						  (SELECT COUNT(*)
						  FROM juegos.persagen x
						  WHERE b.tipo_doc     = x.tipo_doc
						  AND b.nro_doc        = x.nro_doc
						  AND NVL(x.tit_cc,'S')='S'
						  AND x.tipo_rel       = 'TIT'
						  ) AS cant
						FROM JUEGOS.AGENCIA a,
						  juegos.persagen b
						WHERE a.suc_ban      = b.suc_ban
						AND a.nro_agen       = b.nro_agen
						AND b.tipo_rel       = 'TIT'
						AND NVL(b.tit_cc,'S')='S'
						AND a.nro_agen       < 3000
						AND a.nro_agen NOT  IN (1450)
						ORDER BY 1,2");}
	catch (exception $e){die ($db->ErrorMsg()); } 

?>

<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
<table width="81%" border="2" align="center">
  <tr>
    <td colspan="6" align="center" valign="bottom"  ><table width="99%" border="1" cellpadding="0" cellspacing="0">
       
        <tr align="center">
          <td colspan="5" class="titulosprincipales"><strong><?php echo $tituloA;?></strong><br />
            <strong><?php echo $tituloB;?></strong></td>
        </tr>
        <tr align="center" class="tdtituloscolumnas">
          <td width="22%"><strong>Delegaci&oacute;n</strong></td>
          <td width="40%"><strong>Agencia</strong></td>
          <td width="12%"><strong>Nombre</strong></td>
          <td width="12%"><strong>Ingresos Brutos</strong></td>
          <td width="11%"><strong>Cantidad de Agencias</strong></td>
        </tr>
        <?php while ($row = $rs->FetchNextObject($toupper=true)) {?>
        <tr class="tdcolumnasdatos">
          <td><?php  echo $row->SUC_BAN;  ?></td>
          <td><?php  echo $row->NRO_AGEN; ?></td>
          <td><?php  echo $row->NOMBRE; ?></td>
          <td><?php  echo '$ '.number_format($row->INGRESOS_BRUTOS,2,',','.') ?></td>
          <td><?php  echo $row->CANT;?></td>
        </tr>
        <?php  }  ?>
        
      </table></td>
  </tr>
</table>
