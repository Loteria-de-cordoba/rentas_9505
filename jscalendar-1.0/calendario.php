<?php 
function abrir_calendario($nombrecampo,$valor ){
	echo '
	  <input type="text" name="'.$nombrecampo.'" id="'.$nombrecampo.'" value="'.$valor.'" class="small" readonly="true" />
	  <img id="trigger'.$nombrecampo.'" onMouseOver="CambiarImagen(this); 
	  								  Calendar.setup(
													  {
														  inputField  : \''.$nombrecampo.'\',         
														  ifFormat    : \'%d/%m/%Y\',    
														  button      : \'trigger'.$nombrecampo.'\',       
														  timeFormat  : \'24\',
														  showOthers  : true,
														  showsTime   : true,
														  range		  : [1900,2099],
														  weekNumbers : true
														}  
													);"
						 onMouseOut="RegresarImagen(this);"						
						 border="0" " src="jscalendar-1.0/imagen.png" alt="Abrir Calendario"/>';	
}
function abrir_calendario_s_hora($nombrecampo,$valor ){
	echo '
	  <input type="text" name="'.$nombrecampo.'" id="'.$nombrecampo.'" value="'.$valor.'" class="small" readonly="true" />
	  <img id="trigger'.$nombrecampo.'" onMouseOver="CambiarImagen(this); 
	  								  Calendar.setup(
													  {
														  inputField  : \''.$nombrecampo.'\',         
														  ifFormat    : \'%d/%m/%Y\',    
														  button      : \'trigger'.$nombrecampo.'\',       
														  timeFormat  : \'24\',
														  showOthers  : true,
														  showsTime   : false,
														  range		  : [1900,2099],
														  weekNumbers : true
														}  
													);"
						 onMouseOut="RegresarImagen(this);"						
						 border="0" " src="jscalendar-1.0/imagen.png" alt="Abrir Calendario"/>';	
}
function abrir_calendario_submit($nombrecampo,$valor ){
	echo '
	  <input type="text" name="'.$nombrecampo.'" id="'.$nombrecampo.'" value="'.$valor.'" class="small" readonly="true" onChange="document.form_fecha.submit()"/>
	  <img id="trigger'.$nombrecampo.'" onMouseOver="CambiarImagen(this); 
	  								  Calendar.setup(
													  {
														  inputField  : \''.$nombrecampo.'\',         
														  ifFormat    : \'%d/%m/%Y\',    
														  button      : \'trigger'.$nombrecampo.'\',       
														  timeFormat  : \'24\',
														  showOthers  : true,
														  showsTime   : true,
														  range		  : [1900,2099],
														  weekNumbers : true
														}  
													);"
						 onMouseOut="RegresarImagen(this);"						
						 border="0" " src="jscalendar-1.0/imagen.png" alt="Abrir Calendario"/>';	
}
function abrir_calendario_fecha_hora($nombrecampo,$valor,$tabindex=''){
	echo '
	  <input type="text" name="'.$nombrecampo.'" id="'.$nombrecampo.'" value="'.$valor.'" class="small" readonly="true" '.$tabindex.'/>
	  <img id="trigger'.$nombrecampo.'" onMouseOver="CambiarImagen(this); 
	  								  Calendar.setup(
													  {
														  inputField  : \''.$nombrecampo.'\',         
														  ifFormat    : \'%d/%m/%Y %H:%M\',    
														  button      : \'trigger'.$nombrecampo.'\',       
														  timeFormat  : \'24\',
														  showOthers  : true,
														  showsTime   : true,
														  range		  : [1900,2099],
														  weekNumbers : true
														}  
													);"
						 onMouseOut="RegresarImagen(this);"						
						 border="0" " src="jscalendar-1.0/imagen.png" alt="Abrir Calendario"/>';	
}

function abrir_calendario_sin_estilo($nombrecampo,$valor ){
	echo '
	  <input type="text" name="'.$nombrecampo.'" id="'.$nombrecampo.'" value="'.$valor.'" readonly="true" />
	  <img id="trigger'.$nombrecampo.'" onMouseOver="CambiarImagen(this); 
	  								  Calendar.setup(
													  {
														  inputField  : \''.$nombrecampo.'\',         
														  ifFormat    : \'%d/%m/%Y\',    
														  button      : \'trigger'.$nombrecampo.'\',       
														  timeFormat  : \'24\',
														  showOthers  : true,
														  showsTime   : true,
														  range		  : [1900,2099],
														  weekNumbers : true
														}  
													);"
						 onMouseOut="RegresarImagen(this);"						
						 border="0" " src="jscalendar-1.0/imagen.png" alt="Abrir Calendario"/>';	
}
?>