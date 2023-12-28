<?php session_start();
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php");

// $db->debug=true;
// print_r($_SESSION);
// print_r($_POST);
?>

<link href="../../politica/estilo/estilo.css" rel="stylesheet" type="text/css" />

<br/>
<div id="titulo_ventana" align="center" > IMPORTAR DATOS RENTAS PARA CALCULO DE EXCEPCION DE INGRESOS BRUTOS </div>
<br/>

<form action="#" method="post" enctype="multipart/form-data" name="formulario" id="formulario">

	<table border="0" width="70%" cellpadding="2" cellspacing="0" align="center"  >
		<th colspan="4" align="center" class="titulosgrandes"></th>
			<tr class="td5">
				<td colspan="4"><br/> </td></tr>
			<tr class="td5">
				<td colspan="2" align="center"> INGRESAR PERIODO  </td>         
				<td colspan="2">
					<input name="periodo" type="text" class="td9" id="periodo" size="6" maxlength="6" onchange="javascript:validar_solo_numerico(this);"/> (se recomienda: MMAAAA - donde MM son dos digitos para mes y AAAA son 4 digitos para año.) 
					<input  onclick="enviarForm();" name="btnbuscar" type="button" value="Buscar Archivo" alt="Guardar" align="middle" width="20" height="20"/> 
				</td> 
			</tr>
			<tr class="td5"><td colspan="4"><br/> </td></tr>
		<th colspan="4" align="center" class="titulosgrandes"></th>
	</table>     
</form>
<script>      

function enviarForm() {
	
	v_periodo= document.getElementById('periodo').value;

	variables = { 
		accion: "ConsultarPeriodo", 
		periodo: v_periodo
	};

	$.get("ingresos_brutos/ajax.php", variables )
		
	.done( function( data ) {

		if (data > 0 ){
				confirmarPeriodo(document.getElementById('periodo').value);
		} else {
			variables = { 
				 
				periodo: v_periodo
			};
			
			$.get("ingresos_brutos/procesar_rentas.php", variables,
				function (data) {
                    try {
                        // $('#formulario_transferencia').html(data);
                        $('#contenido').html(data);
                        
                       
                    } catch (e) { alert(data); }
                }
			)
		} //if

		  });


	}

	function confirmarPeriodo(ok1){
        v_periodo= document.getElementById('periodo').value;

	variables = { 
		 
		periodo: v_periodo
	};
		        
           Swal.fire({
			  title: 'Ya Existe Cargado el Periodo '+ ok1,
			  // showDenyButton: true,
			  showCancelButton: true,
			  confirmButtonText: 'Aceptar',
			  denyButtonText: 'Cancelar',
			}).then((result) => {
			  /* Read more about isConfirmed, isDenied below */
			  if (result.isConfirmed) {
			   // Swal.fire('Se Guardo correctamente...', '', 'success')
				$.get("ingresos_brutos/procesar_rentas.php", variables,
				function (data) {
                    try {
                        // $('#formulario_transferencia').html(data);
                        $('#contenido').html(data);
                        
                       
                    } catch (e) {
                        alert(data);
                    }
                }
				
				
				
				)
				

			  } 
			//else {
			//     Swal.fire('Se Cancela el Proceso...', '', 'info')
			//   }
			});

      

    }
</script>