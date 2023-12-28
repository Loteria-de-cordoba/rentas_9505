<?php 
session_start();
//print_r($_GET);
include ("../db_conecta_adodb.inc.php");
include("../funcion.inc.php");

//print_r($_GET);
// $periodo = $_POST['periodo'];
  $periodo = $_GET['periodo'];?>

<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../librerias/jquery/jquery-1.8.2.js"></script>


<!-- action="procesar_rentas_final.php?periodo=<?php echo $periodo;?>"
 --><form method="post"  action="procesar_rentas_final.php?periodo=<?php echo $periodo;?>" enctype="multipart/form-data" name="formulario" id="formulario" >  
	
    <table width="100%" align="center" border ="0">
        <th colspan="4" align="center" class="titulosgrandes"></th>
        <tr class="td5"> <td colspan="4"><br/> </td></tr>
        <tr class="td5">
            <td colspan="4">
                <input size="100" class="textbox" name="adjunto" type="file" id="adjunto"/></td>    
		</tr>
        <tr class="td5"> <td colspan="4"><br/> </td></tr>
        <tr>
            <td class="td5" colspan="4">
                <input name="enviar" type="submit" id="enviar" value="Enviar" class="submit">
            </td>
        </tr>
        <th colspan="4" align="center" class="titulosgrandes"></th>
    </table>

</form>

<script>
$(function() {
  $('.submit').click(function(){
         $(this).prop("disabled",true).val("Espere...").closest('form').submit();
  });
});
</script>



<!-- <script type="text/javascript">

function procesarUpload(p_periodo) {
   
    variables = { 
        periodo: p_periodo
    };

    $.get("procesar_rentas_final.php", variables)

        .done( function( data ) {
      
            try {
                // $('#formulario_transferencia').html(data);
                $('#contenido').html(data);
               
            } catch (e) { alert(data); }
                
        }
    );  
}

</script> -->