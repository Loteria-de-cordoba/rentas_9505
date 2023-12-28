<?php @session_start();
include "db_conecta_adodb.inc.php";
//$db->debug = true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>IMPUESTOS GENERALES</title>

  <link href="../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
  <link type="text/css" href="menu/menu.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" media="all" href="jscalendar-1.0/calendar-brown.css" title="summer" />

    <script type='text/javascript' src='menu/quickmenu.js'></script>
    <script type="text/javascript" src="jscalendar-1.0/calendar.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
    <script language="javascript" src="funcion2.js"></script>
    
    <!-- Se agrega llamada Jquery 08/10/2013 MB -->
     <script type="text/javascript" src="../librerias/jquery/jquery-1.8.2.js"></script>

    <link href="bootstrap/scss/bootstrap.scss" rel="stylesheet">  



    <style type="text/css">
    body{
      font: solid 12px Arial,sans-serif !important;
      font-family: "Trebuchet MS", Helvetica, sans-serif;
    }

    .titulo{
      font: bold 14px Arial;
      font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
      background-color: rgb(111, 102, 145);
      color: white;
      width: 90%;border-bottom: 3px solid rgb(0, 0, 0);
      border-top: 3px solid rgb(0, 0, 0);
    }
    </style>
</head>
<body>

<?php $permiso = 0;
try { $rs = $db->Execute("SELECT granted_role from user_role_privs
						where username =?
						and granted_role LIKE ?", array("DU" . $_SESSION['usuario'], "ROL_IMPUESTOS_CONSULTA"));} catch (exception $e) {die(MensajeBase($db->ErrorMsg()));}

if ($rs->RecordCount() != 0) {
    $permiso = 1;
}
?>
<table width="100%" border="0">
  <tr>
    <td width="4%"><a href="http://www.loteriadecordoba.com.ar"><img src="image/logo_loteria.png" alt="logo_lote" width="40" height="40" border="0" /></a></td>
    <td width="90%" align="center" valign="middle" class="titulo" >IMPUESTOS GENERALES</td>
    <td width="6%"><div id="carga" align="left"> </div></td>
  </tr>
  <tr>
    <td colspan="3">
      <!-- QuickMenu Structure [Menu 0] -->
        <ul id="qm0" class="qmmc">
          <?php if ($permiso == 0) {?>
          <li><a class="qmparent" href="javascript:void(0)">Administracion</a>
              <ul>
                <li><span class="qmtitle" >Administracion</span></li>
                    <li><a href="javascript:ajax_get('contenido','mep/detalle_mep.php');" >MEP</a></li>
                    <li><a href="javascript:ajax_get('contenido','localidad/abm_localidad.php');" >Localidades</a></li>
                    <li><a href="javascript:ajax_get('contenido','bases_imponibles/abm_ddjj_bases_imponibles.php');" >DDJJ Bases Imponibles</a></li>
                    <li><a href="javascript:ajax_get('contenido','carteleria/abm_carteleria.php');" >DDJJ Carteleria</a></li>
                </ul>
            </li>
            <?php }?>
            <li><a class="qmparent" href="javascript:void(0)">Ingresos Brutos</a>
              <ul>
                  <li><span class="qmtitle" >Ingresos Brutos</span></li>
                    <?php if ($permiso == 0) {?>
                    <li><a href="javascript:ajax_get('contenido','ingresos_brutos/abm_ingresos_brutos.php');" > Administracion de Ingresos Brutos</a></li>
                    <li><a href="#" onclick="$.get('ingresos_brutos/importar_excel_rentas.php',function(data){$('#contenido').html(data);});" > Importar Datos de rentas </a></li>
                    <li><a href="javascript:ajax_get('contenido','ingresos_brutos/agencias_exceptuadas_rentas.php');" > Agencias exceptuadas Rentas </a></li>
                    
                    <li><span class="qmtitle" >Comisiones</span></li>

                    <li><a href="javascript:ajax_get('contenido','ingresos_brutos/abm_recaudacion.php');" > Administracion de Comisiones</a></li>
                    <?php }?>

                    <li><a href="javascript:ajax_get('contenido','ingresos_brutos/informe_comisiones.php');" > Informe de Comisiones</a></li>
                    <li><a href="#" onclick="window.open('ingresos_brutos/xls_listado_afip.php','Ventana','width=400,height=400,top=0,Left=0,menubar=no,scrollbars=yes,resizable=yes');" > Estado de Agencias - (EXCEL)</a></li>
   
        </ul>
            </li>
      <?php if ($permiso == 0) {?>
            <li><a class="qmparent" href="javascript:void(0)">Impuestos Municipales</a>
                <ul>
                    <li><span class="qmtitle" >Impuestos Municipales</span></li>
                    <li><a href="javascript:ajax_get('contenido','municipal/abm_excepcion_municipal.php');" > Administracion de Impuestos Municipales</a></li>
                    <li><a href="javascript:ajax_get('contenido','municipal/abm_excepcion_municipal_juego.php');" > Administracion de Impuestos Municipales por Juego</a></li>
                    <li><a href="javascript:ajax_get('contenido','municipal/abm_excepcion_mun_juego_rs.php');" > Excepcion de Impuestos Municipales por Regimen Simplificado</a></li>


           </ul>
            </li>

            <li><a class="qmparent" href="javascript:void(0)">Retenciones</a>
              <ul>
                  <li><span class="qmtitle" >Retenciones</span></li>
                  <li><a href="javascript:ajax_get('contenido','retenciones/abm_retenciones_ing_brutos.php');" > Sobre Ingresos Brutos</a></li>
                  <li><a href="javascript:ajax_get('contenido','retenciones/abm_retenciones_imp_municipal.php');" > Sobre Impuestos Municipales</a></li>
                </ul>
            </li>
      <?php }?>
            <li><a href="/app/cau" >Salir</a></li>

            <li class="qmclear">&nbsp;</li>
    </ul>

        <!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click (options: 'all' * 'all-always-open' * 'main' * 'lev2'), Right to Left, Horizontal Subs, Flush Left, Flush Top) -->
        <script type="text/javascript">qm_create(0,false,0,500,false,false,false,false,false);</script><!--[END-QM0]-->
       <!--  <script src="bootstrap/bootstrap.min.js"></script> -->
    </td>
  </tr>
  <tr>
    <td colspan="3">
      <div id="contenido" ></div>
    </td>
 </tr>
</table>

<script src='js/swal.js'></script>
<script src='js/jquery.js'></script>
<script type="text/javascript" src="../librerias/js/loadingoverlay.min.js">

	$(document).ajaxStart(function(){
	    $.LoadingOverlay("show");
	});
	$(document).ajaxStop(function(){
	    $.LoadingOverlay("hide");
	});

</script>

</body>

</html>