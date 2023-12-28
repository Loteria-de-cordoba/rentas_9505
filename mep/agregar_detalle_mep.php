<?php session_start(); 
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");
include("../jscalendar-1.0/calendario.php");
?>
<script language="javascript" src="funcion2.js"></script>

<?php	
$array_fecha = FechaServer();
$fecha = str_pad($array_fecha["mday"],2,'0',STR_PAD_LEFT).'/'.str_pad($array_fecha["mon"],2,'0',STR_PAD_LEFT).'/'.$array_fecha["year"];
try {
	 $rs = $db->Execute("select concepto as codigo, descripcion 
	 					from impuestos.cuenta_deposito");
	 }
	 catch  (exception $e) {  die($db->ErrorMsg()); }
?>   

<link href="../estilo/estilo.css" rel="stylesheet" type="text/css" />
<br />
<form action="" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="validar_detalle_mep('contenido','procesar_alta_detalle_mep.php',this,this.monto,this.recargo,this.id_mep); return false;">
	  <table width="100%" border="0">
        <tr class="td2">
          <th colspan="8" scope="col">Detalle MEP</th>
        </tr>
        <tr align="center" class="td2">
          <td scope="col">MEP</td>
          <td scope="col">Concepto</td>
          <td scope="col">Quincena</td>
		  <td scope="col">Mes</td>
          <td scope="col"><?php echo utf8_encode("Año") ?></td>
          <td scope="col">Fecha Deposito</td>
          <td scope="col">Monto</td>
          <td scope="col">Recargo</td>
        </tr>
        <tr align="center" class="td">
          <td><label>
            <input name="id_mep" type="text" class="small_derecha" id="id_mep" size="11" maxlength="11" />
          </label></td>
          <td><?php armar_combo($rs,'concepto','');?></td>
		  <td><label>
		    <select name="quincena" class="small" id="quincena">
		      <option value="1">1&ordf; Quincena</option>
		      <option value="2">2&ordf; Quincena</option>
	              </select>
		  </label></td>
		  <td><label></label>	      <select name="mes" class="small" id="mes">
            <option value="1" selected="selected">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
          </select></td>
		  <td><label>
		    <select name="anio" class="small" id="anio">
		      <option value="2008">2008</option>
		      <option value="2009">2009</option>
		      <option value="2010">2010</option>
		      <option value="2011">2011</option>
		      <option value="2012">2012</option>
		      <option value="2013">2013</option>
		      <option value="2014">2014</option>
		      <option value="2015">2015</option>
		      <option value="2016">2016</option>
		      <option value="2017">2017</option>
		      <option value="2018">2018</option>
		      <option value="2019">2019</option>
		      <option value="2020">2020</option>
          <option value="2021">2021</option>
          <option value="2022">2022</option>
          <option value="2023">2023</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
          <option value="2026">2026</option>
          <option value="2027">2027</option>
          <option value="2028">2028</option>
	          </select>
		  </label></td>
		  <td><?php  abrir_calendario('fecha','formulario', $fecha); ?></td>
          <td><label>
          <input name="monto" type="text" class="small_derecha" id="monto" value="0" size="10" maxlength="10" />
          </label></td>
          <td><label>
            <input name="recargo" type="text" class="small_derecha" id="recargo" value="0" size="10" maxlength="10" />
          </label></td>
        </tr>
        <tr align="center" class="td">
          <td colspan="8" class="td2"><input name="button" type="submit" class="small" id="button" value="Guardar" /></td>
        </tr> 
  </table>
</form>
<a href="#" onClick="ajax_get('contenido','mep/detalle_mep.php','');">Regresar</a>