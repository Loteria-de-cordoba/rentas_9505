<?php 
session_start(); 
include ("db_conecta_adodb.inc.php");
include ("funcion.inc.php");
include("jscalendar-1.0/calendario.php");
?>
<script language="javascript" src="funcion2.js"></script>

<?php	
$array_fecha = FechaServer();
$fecha = str_pad($array_fecha["mday"],2,'0',STR_PAD_LEFT).'/'.str_pad($array_fecha["mon"],2,'0',STR_PAD_LEFT).'/'.$array_fecha["year"];
try {
	 $rs_mep = $db->Execute("select id_mep, concepto, quincena, mes, anio, to_char(fechamep,'DD/MM/YYYY') as fecha, monto, recargo
	 from impuestos.mep9505 where id_mep = ?",array($_GET['id_mep']) );
	 }
	 catch  (exception $e) 
	 { 
	 die($db->ErrorMsg());
	 }
$row_mep = $rs_mep->FetchNextObject($toupper=true);
try {
	 $rs = $db->Execute("select concepto as codigo, descripcion from impuestos.cuenta_deposito");
	 }
	 catch  (exception $e) 
	 { 
	 die($db->ErrorMsg());
	 }
?>   
<link href="../../app/cuenta_corriente/estilo/estilo.css" rel="stylesheet" type="text/css" />
<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
<br />
<form action="" method="post" enctype="multipart/form-data" name="formulario" id="formulario" onSubmit="validar_detalle_mep('contenido','procesar_modificar_detalle_mep.php',this,this.monto,this.recargo,this.id_mep); return false;">
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
            <input name="id_mep" type="text" class="small_derecha" id="id_mep" value="<?php echo $row_mep->ID_MEP ?>" size="11" maxlength="11" readonly="true"/>
          </label></td>
          <td><?php armar_combo($rs,'concepto',$row_mep->CONCEPTO);?></td>
		  <td><label>
		    <select name="quincena" class="small" id="quincena">
		      <option value="1" <?php if ($row_mep->QUINCENA==1) {echo "selected";} ?>>1&ordf; Quincena</option>
		      <option value="2" <?php if ($row_mep->QUINCENA==2) {echo "selected";} ?>>2&ordf; Quincena</option>
	              </select>
		  </label></td>
		  <td><label></label>	      <select name="mes" class="small" id="mes">
            <option value="1" <?php if ($row_mep->MES==1) {echo "selected";} ?>>Enero</option>
            <option value="2" <?php if ($row_mep->MES==2) {echo "selected";} ?>>Febrero</option>
            <option value="3" <?php if ($row_mep->MES==3) {echo "selected";} ?>>Marzo</option>
            <option value="4" <?php if ($row_mep->MES==4) {echo "selected";} ?>>Abril</option>
            <option value="5" <?php if ($row_mep->MES==5) {echo "selected";} ?>>Mayo</option>
            <option value="6" <?php if ($row_mep->MES==6) {echo "selected";} ?>>Junio</option>
            <option value="7" <?php if ($row_mep->MES==7) {echo "selected";} ?>>Julio</option>
            <option value="8" <?php if ($row_mep->MES==8) {echo "selected";} ?>>Agosto</option>
            <option value="9" <?php if ($row_mep->MES==9) {echo "selected";} ?>>Septiembre</option>
            <option value="10" <?php if ($row_mep->MES==10) {echo "selected";} ?>>Octubre</option>
            <option value="11" <?php if ($row_mep->MES==11) {echo "selected";} ?>>Noviembre</option>
            <option value="12" <?php if ($row_mep->MES==12) {echo "selected";} ?>>Diciembre</option>
          </select></td>
		  <td><label>
		    <select name="anio" class="small" id="anio">
		      <option value="2008" <?php if ($row_mep->ANIO==2008) {echo "selected";} ?>>2008</option>
		      <option value="2009" <?php if ($row_mep->ANIO==2009) {echo "selected";} ?>>2009</option>
		      <option value="2010" <?php if ($row_mep->ANIO==2010) {echo "selected";} ?>>2010</option>
		      <option value="2011" <?php if ($row_mep->ANIO==2011) {echo "selected";} ?>>2011</option>
		      <option value="2012" <?php if ($row_mep->ANIO==2012) {echo "selected";} ?>>2012</option>
		      <option value="2013" <?php if ($row_mep->ANIO==2013) {echo "selected";} ?>>2013</option>
		      <option value="2014" <?php if ($row_mep->ANIO==2014) {echo "selected";} ?>>2014</option>
		      <option value="2015" <?php if ($row_mep->ANIO==2015) {echo "selected";} ?>>2015</option>
		      <option value="2016" <?php if ($row_mep->ANIO==2016) {echo "selected";} ?>>2016</option>
		      <option value="2017" <?php if ($row_mep->ANIO==2017) {echo "selected";} ?>>2017</option>
		      <option value="2018" <?php if ($row_mep->ANIO==2018) {echo "selected";} ?>>2018</option>
		      <option value="2019" <?php if ($row_mep->ANIO==2019) {echo "selected";} ?>>2019</option>
		      <option value="2020" <?php if ($row_mep->ANIO==2020) {echo "selected";} ?>>2020</option>
	          </select>
		  </label></td>
		  <td><?php  abrir_calendario('fecha','formulario', $row_mep->FECHA); ?></td>
          <td><label>
          <input name="monto" type="text" class="small_derecha" id="monto" value="<?php echo $row_mep->MONTO ?>" size="10" maxlength="10" />
          </label></td>
          <td><label>
            <input name="recargo" type="text" class="small_derecha" id="recargo" value="<?php echo $row_mep->RECARGO ?>" size="10" maxlength="10" />
          </label></td>
        </tr>
        <tr align="center" class="td">
          <td colspan="8" class="td2"><input name="button" type="submit" class="small" id="button" value="Guardar" /></td>
        </tr> 
  </table>
</form>
<a href="#" onClick="ajax_get('contenido','detalle_mep.php','');">Regresar</a>