//Funcion seleccionar un campo
function SeleccionarCampo(campo) {
		document.getElementById(campo).select();
	}

//desactivo la tecla enter para todo el sistema (cross browser)
document.onkeypress = stopRKey; 
function stopRKey(evt) {
	var evt = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}


/*document.all = TeclaPulsada(event)
function TeclaPulsada(evento) {
  // averiguamos el código de la tecla pulsada (keyCode para IE y which para Firefox)
  tecla = (document.all) ? evento.keyCode :evento.which;
  // si la tecla no es 13 devuelve verdadero,  si es 13 devuelve false y la pulsación no se ejecuta
  if (tecla==13) {
	  return false;
  }
}
*/
//var ns4 = (document.layers)? true:false
/*var ie4 = (document.all)? true:false
document.onkeydown = TeclaPulsada
function TeclaPulsada () {
	if(ie4) {
		var teclaCodigo = event.keyCode
	} else {
		var teclaCodigo = event.which
		alert(teclaCodigo)
	}
	if (teclaCodigo==13) {
		return false;
	}	
}
/*
/*function TeclaPulsada ()
{
	var teclaCodigo = event.keyCode
	var teclaReal   = String.fromCharCode (teclaCodigo)
	alert("Código de la tecla: " + teclaCodigo + "\nTecla pulsada: " + teclaReal)
}
*/
/*function click() 
	{
		if (event.button==2) 
		{
		alert ('Este boton esta desabilitado.')
		}
	}
document.onmousedown=click*/
function redondear(cantidad, decimales) {
	var Cantidad_ = parseFloat(cantidad);
	var Decimales_ = parseFloat(decimales);
	Decimales_ = (!Decimales_ ? 2 : Decimales_);
	return Math.round(Cantidad_ * Math.pow(10, Decimales_)) / Math.pow(10, Decimales_);
} 
function anyoBisiesto(ano)
  {
    if ((ano % 4 == 0) || ((ano % 100 == 0) && (ano % 400 == 0)))
       {
   	     return true;
       }
       else
       {
         return false;
       }
   }
function validar_fecha(dia,mes,ano)
	{
		if (anyoBisiesto(ano.value))
	   	  {
          var febrero=29;
		  }
       	  else
	   	  {
          var febrero=28;
		  }
	  /*si el mes introducido es febrero y el dia es mayor que el correspondiente, al año introducido > alertamos y detenemos ejecucion*/
	  if ((mes.value==2) && ((dia.value<1) || (dia.value>febrero)))
	     {
		 alert("Dia Invalido.");
	     return false;
	     }
      if (((mes.value==1) || (mes.value==3) || (mes.value==5) || (mes.value==7) || (mes.value==8) || (mes.value==10) || (mes.value==12)) && ((dia.value<1) || (dia.value>31)))
	   	 {
		 alert("Dia Invalido.");
		 return false;
	     }
	if (((mes.value==4) || (mes.value==6) || (mes.value==9) || (mes.value==11)) && ((dia.value<1) || (dia.value>30)))
		 {
	     alert("Dia Invalido.");
		 return false;
	     }
	return true;
   	  /*si el mes introducido es de 30 dias y el dia introducido es mayor de 30 > alertamos y detenemos ejecucion*/
		 /*en caso de que todo sea correcto > enviamos los datos del formulario, para ello debeis descomentar la ultima sentencia	*/
	}
function comparar_fechas(dia1,mes1,ano1,dia2,mes2,ano2) 
	{
	var fecha_desde = new Date(ano1.value,mes1.value-1/*los meses cuentan entre cero y 11, por eso se suma 1*/,dia1.value);
   	var fecha_hasta = new Date(ano2.value,mes2.value-1/*los meses cuentan entre cero y 11, por eso se suma 1*/,dia2.value);
if (fecha_desde.getTime()>fecha_hasta.getTime())
   		{
   		alert('La fecha desde debe ser menor o igual que la fecha hasta');
   		//for (n=0;n<=fecha_hasta_dia.length-1;n++)
   		//{
   		//	if (fecha_hasta_dia.options[n].value==10)
		//	{
		//		fecha_hasta_dia.options[n].selected = true ;
		//	}
		//}
   		//fecha_hasta_mes.selectedIndex=fecha_desde_mes.selectedIndex;
   		//fecha_hasta_ano.selectedIndex=fecha_desde_ano.selectedIndex;
   		return false ;
  		}
   		else
   		{
   		return true ;
   		}
	}
function comparar_fechas_mensaje(dia1,mes1,ano1,dia2,mes2,ano2,mensaje) 
	{
	var fecha_desde = new Date(ano1.value,mes1.value-1/*los meses cuentan entre cero y 11, por eso se suma 1*/,dia1.value);
   	var fecha_hasta = new Date(ano2.value,mes2.value-1/*los meses cuentan entre cero y 11, por eso se suma 1*/,dia2.value);
if (fecha_desde.getTime()>fecha_hasta.getTime())
   		{
   		alert(mensaje);
   		//for (n=0;n<=fecha_hasta_dia.length-1;n++)
   		//{
   		//	if (fecha_hasta_dia.options[n].value==10)
		//	{
		//		fecha_hasta_dia.options[n].selected = true ;
		//	}
		//}
   		//fecha_hasta_mes.selectedIndex=fecha_desde_mes.selectedIndex;
   		//fecha_hasta_ano.selectedIndex=fecha_desde_ano.selectedIndex;
   		return false ;
  		}
   		else
   		{
   		return true ;
   		}
	}
function comparar_fechas_calendario(fecha_desde,fecha_hasta) 
	{
	var fecha1 = fecha_desde.value;
	var fecha2 = fecha_hasta.value;
	var dia1 = fecha1.substr(0,2)
	var mes1 = fecha1.substr(3,2)
	var ano1 = fecha1.substr(6,4)
	var hora1 = fecha1.substr(11,2)
	var minutos1 = fecha1.substr(14,2)
	var segundos1 = fecha1.substr(17,2)

	var dia2 = fecha2.substr(0,2)
	var mes2 = fecha2.substr(3,2)
	var ano2 = fecha2.substr(6,4)
	var hora2 = fecha2.substr(11,2)
	var minutos2 = fecha2.substr(14,2)
	var segundos2 = fecha2.substr(17,2)
//	alert(dia1+mes1+ano1+"  "+dia2+mes2+ano2)
	var fecha_desde = new Date(ano1,mes1-1/*los meses cuentan entre cero y 11, por eso se suma 1*/,dia1,hora1,minutos1,segundos1);
   	var fecha_hasta = new Date(ano2,mes2-1/*los meses cuentan entre cero y 11, por eso se suma 1*/,dia2,hora2,minutos2,segundos2);
	if (fecha_desde.getTime()>fecha_hasta.getTime())
   		{
   		alert('La fecha desde debe ser menor o igual que la fecha hasta');
  		//for (n=0;n<=fecha_hasta_dia.length-1;n++)
   		//{
   		//	if (fecha_hasta_dia.options[n].value==10)
		//	{
		//		fecha_hasta_dia.options[n].selected = true ;
		//	}
		//}
   		//fecha_hasta_mes.selectedIndex=fecha_desde_mes.selectedIndex;
   		//fecha_hasta_ano.selectedIndex=fecha_desde_ano.selectedIndex;
  		return false ;
  		}
   		else
   		{
   		return true ;
   		}
	}
function fecha_rango(dia,mes,ano,dia1,mes1,ano1,dia2,mes2,ano2) 
	{
		var fecha = new Date(ano.value,mes.value-1/*los meses cuentan entre cero y 11, por eso se suma 1*/,dia.value);
		var fecha_desde = new Date(ano1.value,mes1.value-1/*los meses cuentan entre cero y 11, por eso se suma 1*/,dia1.value);
		var fecha_hasta = new Date(ano2.value,mes2.value-1/*los meses cuentan entre cero y 11, por eso se suma 1*/,dia2.value);
		if ((fecha.getTime()<fecha_desde.getTime()) || (fecha.getTime()>fecha_hasta.getTime()))
		   {
		   alert('La fecha desde se encuentra fuera del rango de la reserva');
		   dia.focus()
		   return false ;
		   }
		   else
		   {
		   return true;
		   }
	}
function validar_hora(campo_hora)  {
	var hora = campo_hora.value;
	var horas = hora.substr(0,2);
	var minutos = hora.substr(3,2);
	//alert(minutos);
	//return false;
	if (!isNaN(horas) && !isNaN(minutos) && hora!="") {
		if ((horas>=0) && (horas<=23) && (minutos>=0) && (minutos<=59)) {
			return true;
		}
		else
		{
		alert("Hora invalida!.....");
		campo_hora.value="00:00";
		return false;
		}
	}
	else
	{
	alert("Hora invalida!...");
	campo_hora.value="00:00";
	return false;
	}
}
/////////////////////////////
//Validacion para campo vacio
/////////////////////////////
function IsEmpty(campo) {
       for (LargoCampoAValidar = 0; LargoCampoAValidar < campo.length; LargoCampoAValidar++) {   
                if (campo.charAt(LargoCampoAValidar) != " ") {  // charAt() evalua cada caracter
                        return true;   
                }   
        }   
        return false;   
}   
  
function validar_campo(aTextField) {
   if ((aTextField.value.length==0) || !IsEmpty(aTextField.value)) {
	   if (aTextField.name=="descripcion") {
		  var alerta = "Debe asignar una " + aTextField.name;
	   } else {
	   	  var alerta = "Debe asignar un " + aTextField.name;
	   }
 	  alert(alerta);
	  aTextField.focus();
      return false;
   } else { 
   	  return true; 
   }
}

function validar_campo_silencioso(aTextField) {
   if ((aTextField.value.length==0) || !IsEmpty(aTextField.value)) {
	  aTextField.focus();
      return false;
   } else { 
   	  return true; 
   }
}

//function validar_campo(campo) 
//	{
//		if ((campo.value==0) || (campo.value==""))
//			{
//			var alerta = "Debe asignar un "+campo.name;
//			alert(alerta);
//			campo.focus();
//			return false;
//			}
//			else
//			{
//			return true;
//			}
//	}	
function validar_solo_numerico(campo) 
		
	{
		//alert('algoooo');
		if (isNaN(campo.value)==true || (campo.value=="")) /*tambien se puede usar (isNaN(parseFloat(campo.value) Ej: ver agregar_movim.php*/
			{
			var alerta = campo.name+" Debe ser numerico.";
			alert(alerta);
			campo.focus();
			return false;
			}
			else
			{
			return true;
			}
	}	
function validar_solo_numerico_s_mensaje(campo) 
	{
		if (isNaN(campo.value)==true || (campo.value=="")) /*tambien se puede usar (isNaN(parseFloat(campo.value) Ej: ver agregar_movim.php*/
			{
			//var alerta = campo.name+" Debe ser numerico.";
			//alert(alerta);
			campo.focus();
			return false;
			}
			else
			{
			return true;
			}
	}	
function validar_distintos_cero(campo1,campo2) 
	{
	if ((parseFloat(campo1.value)==0) && (parseFloat(campo2.value)==0))
		{
		var alerta = campo1.name+" y "+campo2.name+" deben ser distintos de cero!...";
		alert(alerta);
		campo1.focus();
		return false;
		}
		else
		{
		return true;
		}
	}
function validar_distinto_cero(campo) 
	{
	if ((parseFloat(campo.value)==0))
		{
		var alerta = campo.name+" debe ser distinto de cero!...";
		alert(alerta);
		campo.focus();
		return false;
		}
		else
		{
		return true;
		}
	}
function validar_mayor_cero(campo) 
	{
	if ((parseFloat(campo.value)<=0))
		{
		var alerta = campo.name+" debe ser mayor a cero!...";
		alert(alerta);
		campo.focus();
		return false;
		}
		else
		{
		return true;
		}
	}
function cerrar_ventana2() 
	{
		window.close()
	}
function ir_a_pagina(objeto,restore){ //v3.0
  eval("self.location='"+objeto.options[objeto.selectedIndex].value+"'");
  if (restore) objeto.selectedIndex=0;
}
function confirmSubmit(valor)
	{
	var si=confirm("Desea realmente eliminar "+valor+" ?");
	if (si)
		return true ;
	else
		return false ;
}
function confirmSubmitSinValor(valor)
	{
	var si=confirm(valor);
	if (si)
		return true ;
	else
		return false ;
}
function VerificarEmail(campo_mail){
	if(campo_mail.value.indexOf('@',0)==-1 || campo_mail.value.indexOf(';',0)!=-1
		|| campo_mail.value.indexOf(' ',0)!=-1 || campo_mail.value.indexOf('/',0)!=-1
		|| campo_mail.value.indexOf(';',0)!=-1 || campo_mail.value.indexOf('<',0)!=-1
		|| campo_mail.value.indexOf('>',0)!=-1 || campo_mail.value.indexOf('*',0)!=-1
		|| campo_mail.value.indexOf('|',0)!=-1 || campo_mail.value.indexOf('`',0)!=-1
		|| campo_mail.value.indexOf('&',0)!=-1 || campo_mail.value.indexOf('$',0)!=-1
		|| campo_mail.value.indexOf('!',0)!=-1 || campo_mail.value.indexOf('"',0)!=-1
		|| campo_mail.value.indexOf(':',0)!=-1) {
		alert("Direccion de mail incorrecta!...");
		campo_mail.focus();
		return false;
	} else {
		return true;
	}
}
/*
*Esta libreria es una libreria AJAX creada por Javier Mellado
*y descargada del portal AJAX Hispano http://www.ajaxhispano.com
*contacto javiermellado@gmail.com
*
*Puede ser utilizada, pasada, modificada pero no olvides mantener
*el espiritu del software libre y respeta GNU-GPL
*/ 
function objetus() 
	{
	var objetus=false;
	try {
		objetus = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
					try {
						objetus = new ActiveXObject("Microsoft.XMLHTTP");
						} catch (E) {
									objetus = false;
									}
						}
		if (!objetus && typeof XMLHttpRequest!='undefined') 
			{
			objetus = new XMLHttpRequest();
			}
		return objetus;
	}
var enviar = false
function ajax_get(_target,archivo,variables) {
	document.getElementById('carga').innerHTML = '<img src="image/loading.gif" width="30" height="30" border="0" align="top" />';
	if (enviar) {
		alert("Aguerde un instante por favor. El servidor esta ocupado!...")
	} else {
		enviar = true
		//if(ajax_tooltipObj) {
			//ajax_hideTooltip();
		//}
		/*ImagenIndicador = new Image()
		ImagenIndicador.src = "indicator.gif"
		ImagenClock_off = new Image()
		ImagenClock_off.src = "clock_off.gif"
		ImagenClock_on = new Image()
		ImagenClock_on.src = "clock_on.gif"*/
		//alert(archivo+variables)
		_objetus=objetus()
		_values_send_get=variables
		var tiempo = new Date();
		//alert(tiempo.getTime());
		archivo = archivo+"?jsfecha="+tiempo.getTime();
		if (variables=="")
			{
			_URL_=archivo
			}
			else
			{
			_URL_=archivo+"&"
			}
		//alert(_URL_+_values_send_get)
		_objetus.open("GET",_URL_+_values_send_get,true);
		_objetus.onreadystatechange=function(){
		if (_objetus.readyState==0)
			{
			var mensaje_carga = "Inicializando......"	
			document.getElementById(_target).innerHTML=mensaje_carga
			} 
		else if (_objetus.readyState==1)
			{
			var mensaje_carga = "Cargando...";//no toma foco control ingreso si lo descomento
			//var mensaje_carga = "<img src='clock_on.gif' name='ImagenClock_on' /><img src='clock_off.gif' name='ImagenClock_off' /><img src='indicator.gif' name='ImagenIndicador' />Cargando..."//no toma foco control ingreso si lo descomento
			document.getElementById(_target).innerHTML=mensaje_carga
			} 
			else if (_objetus.readyState==4)
					{
					if (_objetus.status==200)
						{
						//txt=unescape(_objetus.responseText);
						//txt2=txt.replace(/\+/gi," ");
						//tambien se puede probar un replace del signo mas si fuera necesario
						//ademas en el codigo php se debe colocar esto
						//$variable = urlencode($variable);
						//document.getElementById(_target).innerHTML=txt2;
						document.getElementById(_target).innerHTML=_objetus.responseText;
						document.location.hash="posicion1"
						//document.location.hash=_target
						setFocus()//da foco si existe un formulario con name="formulario_foco" y un campo name="text_foco o bien solamente con los id"
						enviar = false
						}
						else if (_objetus.status==404)
						{
						var mensaje_carga = "Documento no encontrado ("+archivo+")"	
						document.getElementById(_target).innerHTML=mensaje_carga
						}
						else
						{
						var mensaje_carga = "Error :"+_objetus.responseText;	
						document.getElementById(_target).innerHTML=mensaje_carga
						}
						document.getElementById('carga').innerHTML = '<img src="image/loading.jpg" width="30" height="30" border="0" align="top" />';
						
					}
			}
			_objetus.send(null);
		}
	}
function ajax_post(_target,archivo,formulario) {
	document.getElementById('carga').innerHTML = '<img src="image/loading.gif" width="30" height="30" border="0" align="top" />';
//	document.getElementById('carga').innerHTML = '<table border=\"0\" cellspacing=\"0\"><tr><td align=\"center\" class=\"div_carga\" scope=\"col\"></td></tr><tr><td><img src=\"image/loading.gif\" width=\"30\" height=\"30\"></td></tr></table>';	
	if (enviar) {
		alert("Aguerde un instante por favor. El servidor esta ocupado!...")
		return false
	} else {
		enviar = true
		//if(ajax_tooltipObj) {
			//ajax_hideTooltip();
		//}
		_values_send_post=""
		if (formulario.elements.length>1)//desde la seguna variable en adelante
			{
			//for(i=1;i<formulario.elements.length;i++)
			for(i=0;i<formulario.elements.length;i++)
				{
				if (formulario.elements[i].type=="checkbox" || formulario.elements[i].type=="radio") // si el objeto es radio o check
					{
					if (formulario.elements[i].checked==true)
						{
						//alert(formulario.elements[i].name+' '+formulario.elements[i].checked+' '+formulario.elements[i].value)
						//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+formulario.elements[i].value+"'")		
						//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+escape(formulario.elements[i].value)+"'")		
						//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+unescape(formulario.elements[i].value)+"'")		
						//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+encodeURI(formulario.elements[i].value)+"'")
						if (i==0) {
								eval("_values_send_post=_values_send_post+'"+formulario.elements[i].name+"="+encodeURIComponent(formulario.elements[i].value)+"'")//traduce los enter en las objetos textarea			
							} else {
								eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+encodeURIComponent(formulario.elements[i].value)+"'")//traduce los enter en las objetos textarea			
							}
						//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+formulario.elements[i].value+"'")		
						}
					}
					else
					{
					//alert(formulario.elements[i].name+'='+formulario.elements[i].value)
					//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+formulario.elements[i].value+"'")		
					//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+encodeURI(formulario.elements[i].value)+"'")		
					//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+escape(formulario.elements[i].value)+"'")		
					//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+unescape(formulario.elements[i].value)+"'")		
					if (i==0) {
							eval("_values_send_post=_values_send_post+'"+formulario.elements[i].name+"="+encodeURIComponent(formulario.elements[i].value)+"'")//traduce los enter en las objetos textarea			
						} else {
							eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+encodeURIComponent(formulario.elements[i].value)+"'")//traduce los enter en las objetos textarea			
					}
					//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+formulario.elements[i].value+"'")
					}
				}
			}
			//alert(_values_send_post);
		_objetus=objetus()
		_URL_=archivo
		_objetus.open("POST",_URL_,true);
		_objetus.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		_objetus.setRequestHeader('Accept-Charset', 'UTF-8');
		_objetus.send(_values_send_post);
		_objetus.onreadystatechange=function(){
		if (_objetus.readyState==1)
			{
			var mensaje_carga = "Cargando..."//no toma foco control ingreso si lo descomento
			document.getElementById(_target).innerHTML=mensaje_carga
			} 
			else if (_objetus.readyState==4)
					{
					if (_objetus.status==200)
						{
						//txt=unescape(_objetus.responseText);
						//txt2=txt.replace(/\+/gi," ");
						//tambien se puede probar un replace del signo mas si fuera necesario
						//ademas en el codigo php se debe colocar esto
						//$variable = urlencode($variable);
						//document.getElementById(_target).innerHTML=txt2;
						document.getElementById(_target).innerHTML=_objetus.responseText;
						document.getElementById('carga').innerHTML = '<img src="image/loading.jpg" width="30" height="30" border="0" align="top" />';
						//document.getElementById('carga').innerHTML = '<table border=\"0\" cellspacing=\"0\"><tr><td align=\"center\" class=\"div_carga\" scope=\"col\">	</td></tr><tr><td><img src=\"image/loading.jpg\" width=\"30\" height=\"0\" align=\"top\"></td></tr></table>';
						//ocument.location.hash=_target
						document.location.hash="posicion1"
						setFocus()//da foco si existe un formulario con name="formulario_foco" y un campo name="text_foco o bien solamente con los id"
						enviar = false
						}
						else if (_objetus.status==404)
						{
						var mensaje_carga = "Documento no encontrado ("+archivo+")"		
						document.getElementById(_target).innerHTML=mensaje_carga
						}
						else
						{
						var mensaje_carga = "Error :"+_objetus.status;	
						document.getElementById(_target).innerHTML=mensaje_carga
						}
					}
			}
	}
}
function ajax_get_tooltip(_target,archivo,variables) {
	if (enviar) {
		alert("Aguerde un instante por favor. El servidor esta ocupado!...")
	} else {
		enviar = true
		ImagenIndicador = new Image()
		ImagenIndicador.src = "indicator.gif"
		ImagenClock_off = new Image()
		ImagenClock_off.src = "clock_off.gif"
		ImagenClock_on = new Image()
		ImagenClock_on.src = "clock_on.gif"
		//alert(archivo+variables)
		_objetus=objetus()
		_values_send_get=variables
		var tiempo = new Date();
		//alert(tiempo.getTime());
		archivo = archivo+"?jsfecha="+tiempo.getTime();
		if (variables=="")
			{
			_URL_=archivo
			}
			else
			{
			_URL_=archivo+"&"
			}
		//alert(_URL_+_values_send_get)
		_objetus.open("GET",_URL_+_values_send_get,true);
		_objetus.onreadystatechange=function(){
		if (_objetus.readyState==0)
			{
			var mensaje_carga = "Inicializando......"	
			document.getElementById(_target).innerHTML=mensaje_carga
			} 
		else if (_objetus.readyState==1)
			{
			var mensaje_carga = "Cargando...";//no toma foco control ingreso si lo descomento
			//var mensaje_carga = "<img src='clock_on.gif' name='ImagenClock_on' /><img src='clock_off.gif' name='ImagenClock_off' /><img src='indicator.gif' name='ImagenIndicador' />Cargando..."//no toma foco control ingreso si lo descomento
			document.getElementById(_target).innerHTML=mensaje_carga
			} 
			else if (_objetus.readyState==4)
					{
					if (_objetus.status==200)
						{
						//txt=unescape(_objetus.responseText);
						//txt2=txt.replace(/\+/gi," ");
						//tambien se puede probar un replace del signo mas si fuera necesario
						//ademas en el codigo php se debe colocar esto
						//$variable = urlencode($variable);
						//document.getElementById(_target).innerHTML=txt2;
						document.getElementById(_target).innerHTML=_objetus.responseText;
						document.location.hash="posicion1"
						//document.location.hash=_target
						setFocus()//da foco si existe un formulario con name="formulario_foco" y un campo name="text_foco o bien solamente con los id"
						enviar = false
						}
						else if (_objetus.status==404)
						{
						var mensaje_carga = "Documento no encontrado ("+archivo+")"	
						document.getElementById(_target).innerHTML=mensaje_carga
						}
						else
						{
						var mensaje_carga = "Error :"+_objetus.responseText;	
						document.getElementById(_target).innerHTML=mensaje_carga
						}
					}
			}
			_objetus.send(null);
		}
	}
function ajax_post_tooltip(_target,archivo,formulario) {
	if (enviar) {
		alert("Aguerde un instante por favor. El servidor esta ocupado!...")
		return false
	} else {
		enviar = true
		_values_send_post=""
		if (formulario.elements.length>1)//desde la seguna variable en adelante
			{
			//for(i=1;i<formulario.elements.length;i++)
			for(i=0;i<formulario.elements.length;i++)
				{
				if (formulario.elements[i].type=="checkbox" || formulario.elements[i].type=="radio") // si el objeto es radio o check
					{
					if (formulario.elements[i].checked==true)
						{
						//alert(formulario.elements[i].name+' '+formulario.elements[i].checked+' '+formulario.elements[i].value)
						//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+formulario.elements[i].value+"'")		
						//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+escape(formulario.elements[i].value)+"'")		
						//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+unescape(formulario.elements[i].value)+"'")		
						//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+encodeURI(formulario.elements[i].value)+"'")
						if (i==0) {
								eval("_values_send_post=_values_send_post+'"+formulario.elements[i].name+"="+encodeURIComponent(formulario.elements[i].value)+"'")//traduce los enter en las objetos textarea			
							} else {
								eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+encodeURIComponent(formulario.elements[i].value)+"'")//traduce los enter en las objetos textarea			
							}
						//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+formulario.elements[i].value+"'")		
						}
					}
					else
					{
					//alert(formulario.elements[i].name+'='+formulario.elements[i].value)
					//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+formulario.elements[i].value+"'")		
					//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+encodeURI(formulario.elements[i].value)+"'")		
					//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+escape(formulario.elements[i].value)+"'")		
					//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+unescape(formulario.elements[i].value)+"'")		
					if (i==0) {
							eval("_values_send_post=_values_send_post+'"+formulario.elements[i].name+"="+encodeURIComponent(formulario.elements[i].value)+"'")//traduce los enter en las objetos textarea			
						} else {
							eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+encodeURIComponent(formulario.elements[i].value)+"'")//traduce los enter en las objetos textarea			
					}
					//eval("_values_send_post=_values_send_post+'&"+formulario.elements[i].name+"="+formulario.elements[i].value+"'")
					}
				}
			}
			//alert(_values_send_post);
		_objetus=objetus()
		_URL_=archivo
		_objetus.open("POST",_URL_,true);
		_objetus.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		_objetus.setRequestHeader('Accept-Charset', 'UTF-8');
		_objetus.send(_values_send_post);
		_objetus.onreadystatechange=function(){
		if (_objetus.readyState==1)
			{
			var mensaje_carga = "Cargando..."//no toma foco control ingreso si lo descomento
			document.getElementById(_target).innerHTML=mensaje_carga
			} 
			else if (_objetus.readyState==4)
					{
					if (_objetus.status==200)
						{
						//txt=unescape(_objetus.responseText);
						//txt2=txt.replace(/\+/gi," ");
						//tambien se puede probar un replace del signo mas si fuera necesario
						//ademas en el codigo php se debe colocar esto
						//$variable = urlencode($variable);
						//document.getElementById(_target).innerHTML=txt2;
						document.getElementById(_target).innerHTML=_objetus.responseText;
						//ocument.location.hash=_target
						document.location.hash="posicion1"
						setFocus()//da foco si existe un formulario con name="formulario_foco" y un campo name="text_foco o bien solamente con los id"
						enviar = false
						}
						else if (_objetus.status==404)
						{
						var mensaje_carga = "Documento no encontrado ("+archivo+")"		
						document.getElementById(_target).innerHTML=mensaje_carga
						}
						else
						{
						var mensaje_carga = "Error :"+_objetus.status;	
						document.getElementById(_target).innerHTML=mensaje_carga
						}
					}
			}
	}
}
function setFocus() 
{
  var f = null;
  if (document.getElementById("formulario_foco")) 
  		{ 
   		f = document.getElementById("formulario_foco");
				if (f.text_foco)
					{
	      			f.text_foco.focus();
					}
					else
					{
					alert('No existe elemento text con name = text_foco')
					}
		}
}
var ventanaLista=false
function abrir_ventana_cabecera(pagina_destino,variables_get,nombre_formulario_destino,campo_codigo_destino,campo_descripcion_destino){
	if (typeof ventanaLista.document == "object") {
		ventanaLista.close()
	}
	ventanaLista = window.open(pagina_destino+"?nombre_formulario_destino="+nombre_formulario_destino+"&campo_codigo_destino="+campo_codigo_destino+"&campo_descripcion_destino="+campo_descripcion_destino+"&"+variables_get,"Consulta", "height=500, width=700, left=0, top=0, toolbar=no, menubar=no, titlebar=no, resizable=no, scrollbars=yes");
}
function devuelve_valores(codigo,descripcion,nombre_formulario_destino,campo_codigo_destino,campo_descripcion_destino,campo_codigo_blanquear,campo_descripcion_blanquear,boton){
	//Se encarga de escribir en el formulario adecuado los valores seleccionados
	//también debe cerrar la ventana del calendario
	//eval("opener.document." + nombre_formulario_destino + ".Submit"+campo_descripcion_destino + ".disabled='true'")
	//alert("opener.document." + nombre_formulario_destino + "." + campo_codigo_destino + ".value='" + codigo + "'")
	eval ("opener.document." + nombre_formulario_destino + "." + campo_codigo_destino + ".value='" + codigo + "'")
	eval ("opener.document." + nombre_formulario_destino + "." + campo_descripcion_destino + ".value='" + descripcion + "'")
	//eval ("opener.document." + nombre_formulario_destino + ".submit()")
	window.close()
}
function validar_mail(div,pagina_destino,formulario,direccion,nombre,asunto,mensaje)
	{
	if 	(!validar_campo(direccion) || !validar_campo(nombre) || !validar_campo(asunto) || !validar_campo(mensaje)) 
		{
		return false
		}
		else
		{
		ajax_post(div,pagina_destino,formulario)
		}
	}
//Para tooltip javascript
var theObj = ""; 
function toolTip(text,me) {
	theObj=me;
	theObj.onmousemove=updatePos;
	document.getElementById('toolTipBox').innerHTML=text;
	document.getElementById('toolTipBox').style.display="block";
	window.onscroll=updatePos;
}
function updatePos() {
	var ev = arguments[0]?arguments[0]:event;
	var x  = ev.clientX;
	var y  = ev.clientY;
	diffX = 24;
	diffY = 0;
	document.getElementById('toolTipBox').style.top = y-2 + diffY + document.body.scrollTop + 'px';
	document.getElementById('toolTipBox').style.left = x-2 + diffX + document.body.scrollLeft + 'px';
	theObj.onmouseout=hideMe;
}
function hideMe() {
	document.getElementById('toolTipBox').style.display = "none";
}	
//Devualeve posicion en pantalla
var PosicionX=0
var PosicionY=0
function CapturarPosicionEnPantalla(objeto) {
	theObj=objeto;
	theObj.onmousemove=VerificarPosicion;
	//alert(PosicionX+' - '+PosicionY)
}
function VerificarPosicion() {
	var ev = arguments[0]?arguments[0]:event;
	PosicionX = ev.clientX
	PosicionY = ev.clientY
}

function IsEmpty(campo) {
       for (LargoCampoAValidar = 0; LargoCampoAValidar < campo.length; LargoCampoAValidar++) {   
                if (campo.charAt(LargoCampoAValidar) != " ") {  // charAt() evalua cada caracter
                        return true;   
                }   
        }   
        return false;   
}   

function validar_campo(TextField){
		if(TextField.value.lenght==0 || !IsEmpty(TextField.value)){
			alert("Debe asignar un "+ TextField.name);
			TextField.focus;
			return false;
		} else {
			return true;
		}
}

function validar_cliente(div,destino,formulario,campo,direccion){
	if(!validar_campo(campo)||!validar_campo(direccion)){
			 return false;
			} else {
			 ajax_post(div,destino,formulario);
			}
	}
function validar_detalle_mep(div,destino,formulario,monto,recargo,id_mep){
	if(!validar_solo_numerico(id_mep) || !validar_distinto_cero(id_mep) || !validar_solo_numerico(monto) || !validar_distinto_cero(monto) || !validar_solo_numerico(recargo)) {
			 return false;
			} else {
			 ajax_post(div,destino,formulario);
			}
	}
function reFresh() {
	location.reload(true)
}
function RefrescarDetalleMep(){
	/* Establece el tiempo 1 minuto = 60000 milliseconds. */
	window.setInterval("reFresh()",1000);
}

function validar_alta_excepcion_mun(div,pagina_destino,formulario){
		if(formulario.id_provincia.value == 0)
		{	
			
			alert('Debe seleccionar la Provincia');
			formulario.id_provincia.focus();
			
			return false;
		}
		if (formulario.porcentaje.value==''){
		
			alert('Debe ingresar un Porcentaje');
			formulario.porcentaje.focus();
			return false;
		}
		if (formulario.periodo.value==''){
		
			alert('Debe ingresar un Periodo');
			formulario.periodo.focus();
			return false;
		}
	
		if (confirm ('Esta seguro que desea dar de alta este Impuesto Municipal')) {
		ajax_post(div,pagina_destino,formulario);	
			}
		
		 else{
			
				return false;
			}
	}
function validar_alta_excepcion_mun_juego(div,pagina_destino,formulario){
		if(formulario.id_juego.value == 999)
		{	
			
			alert('Debe seleccionar el Juego');
			formulario.id_juego.focus();
			
			return false;
		}
		if(formulario.id_provincia.value == 0)
		{	
			
			alert('Debe seleccionar la Provincia');
			formulario.id_provincia.focus();
			
			return false;
		}
		if (formulario.porcentaje.value==''){
		
			alert('Debe ingresar un Porcentaje');
			formulario.porcentaje.focus();
			return false;
		}
	
		if (confirm ('Esta seguro que desea dar de alta este Impuesto Municipal por Juego')) {
		ajax_post(div,pagina_destino,formulario);	
			}
		
		 else{
			
				return false;
			}
	}
function validar_alta_periodo_ing_brutos(div,pagina_destino,formulario){
		
		if(formulario.id_provincia.value == 999)
		{	
			
			alert('Debe seleccionar la Provincia');
			formulario.id_provincia.focus();
			
			return false;
		}
		if (validar_solo_numerico(formulario.desde)==false)
		{	
			
			alert('Debe ingresar el Tope Desde');
			formulario.desde.focus();
			
			return false;
		}
		if (validar_solo_numerico(formulario.hasta)==false)
		{	
			
			alert('Debe ingresar el Tope Hasta');
			formulario.hasta.focus();
			
			return false;
		}
		
		if (validar_solo_numerico(formulario.porcentaje)==false)
		{
		
			alert('Debe ingresar un Porcentaje');
			formulario.porcentaje.focus();
			return false;
		}
		if (validar_solo_numerico(formulario.periodo)==false)
		{	
			
			alert('Debe ingresar el Periodo');
			formulario.periodo.focus();
			
			return false;
		}
		if (formulario.accion.value=='modificar') {
			if (confirm ('Esta seguro que desea modificar este Periodo')) {
				ajax_post(div,pagina_destino,formulario);	
			} else {	
				return false;
			}
		}
			
		if (formulario.accion.value=='alta') {
			if (confirm ('Esta seguro que desea dar de alta este Periodo')) {
				ajax_post(div,pagina_destino,formulario);	
			} else {	
				return false;
			}
		}	
	}

	function validar_alta_retencion_ing_brutos(div,pagina_destino,formulario){
		
		if(formulario.cod_concepto.value == 999)
		{	
			
			alert('Debe seleccionar el Concepto');
			formulario.cod_concepto.focus();
			
			return false;
		}

		if(formulario.id_provincia.value == 999)
		{	
			
			alert('Debe seleccionar la Provincia');
			formulario.id_provincia.focus();
			
			return false;
		}
		if (validar_solo_numerico_s_mensaje(formulario.desde)==false)
		{	
			
			alert('Debe ingresar el Tope Desde');
			formulario.desde.focus();
			
			return false;
		}
		if (validar_solo_numerico_s_mensaje(formulario.hasta)==false)
		{	
			
			alert('Debe ingresar el Tope Hasta');
			formulario.hasta.focus();
			
			return false;
		}
		if (parseInt(formulario.desde) >= parseInt(formulario.hasta))
		{
			alert('El Tope Desde debe ser menor al Tope Hasta');
			formulario.hasta.focus();
			return false;
		}
		
		if (validar_solo_numerico_s_mensaje(formulario.porcentaje)==false)
		{
		
			alert('Debe ingresar un Porcentaje');
			formulario.porcentaje.focus();
			return false;
		}
		if (validar_solo_numerico_s_mensaje(formulario.periodo)==false)
		{	
			
			alert('Debe ingresar el Periodo');
			formulario.periodo.focus();
			
			return false;
		}
		if (formulario.accion.value=='modificar') {
			if (confirm ('Esta seguro que desea modificar esta Retencion?')) {
				ajax_post(div,pagina_destino,formulario);	
			} else {	
				return false;
			}
		}
			
		if (formulario.accion.value=='alta') {
			if (confirm ('Esta seguro que desea dar de alta esta Retencion?')) {
				ajax_post(div,pagina_destino,formulario);	
			} else {	
				return false;
			}
		}	
	}

	function validar_alta_retencion_imp_municipal(div,pagina_destino,formulario){
		
		if(formulario.cod_concepto.value == 999)
		{	
			
			alert('Debe seleccionar el Concepto');
			formulario.cod_concepto.focus();
			
			return false;
		}

		if(formulario.id_provincia.value == 0)
		{	
			
			alert('Debe seleccionar la Provincia');
			formulario.id_provincia.focus();
			
			return false;
		}
		/*if(formulario.descripcion.value == 999)
		{	
			
			alert('Debe seleccionar la Localidad');
			formulario.descripcion.focus();
			
			return false;
		}*/
		if (validar_solo_numerico_s_mensaje(formulario.desde)==false)
		{	
			
			alert('Debe ingresar el Tope Desde');
			formulario.desde.focus();
			
			return false;
		}
		if (validar_solo_numerico_s_mensaje(formulario.hasta)==false)
		{	
			
			alert('Debe ingresar el Tope Hasta');
			formulario.hasta.focus();
			
			return false;
		}
		if (parseInt(formulario.desde) >= parseInt(formulario.hasta))
		{
			alert('El Tope Desde debe ser menor al Tope Hasta');
			formulario.hasta.focus();
			return false;
		}
		
		if (validar_solo_numerico_s_mensaje(formulario.porcentaje)==false)
		{
		
			alert('Debe ingresar un Porcentaje');
			formulario.porcentaje.focus();
			return false;
		}
		if (validar_solo_numerico_s_mensaje(formulario.periodo)==false)
		{	
			
			alert('Debe ingresar el Periodo');
			formulario.periodo.focus();
			
			return false;
		}
		if (formulario.accion.value=='modificar') {
			if (confirm ('Esta seguro que desea modificar esta Retencion?')) {
				ajax_post(div,pagina_destino,formulario);	
			} else {	
				return false;
			}
		}
			
		if (formulario.accion.value=='alta') {
			if (confirm ('Esta seguro que desea dar de alta esta Retencion?')) {
				ajax_post(div,pagina_destino,formulario);	
			} else {	
				return false;
			}
		}	
	}

	function validar_alta_ddjj_bases_imponibles(div,pagina_destino,formulario){
		
		//console.log(formulario.periodo.value);
		if(formulario.periodo.value == 0 || formulario.periodo.value == 999 || formulario.periodo.value == -1)
		{	
			
			alert('Debe seleccionar el Periodo');
			formulario.periodo.focus();
			return false;
		}

		console.log(formulario.id_sucursal.value);
		if(formulario.id_sucursal.value == 0 || formulario.id_sucursal.value == 999 || formulario.id_sucursal.value == -1)
		{	
			
			alert('Debe seleccionar la Sucursal');
			formulario.id_sucursal.focus();
			
			return false;
		}

		if(formulario.id_agencia.value == 0 || formulario.id_agencia.value == 999 || formulario.id_agencia.value == -1)
		{	
			
			alert('Debe seleccionar la Agencia');
			formulario.id_agencia.focus();
			
			return false;
		}

		if (validar_solo_numerico_s_mensaje(formulario.sum_bases_imponibles)==false)
		{	
			
			alert('Debe ingresar la Sumatoria de Bases Imponibles');
			formulario.sum_bases_imponibles.focus();
			
			return false;
		}
		if (formulario.accion.value=='modificar') {
			if (confirm ('Esta seguro que desea modificar esta DDJJ?')) {
				ajax_post(div,pagina_destino,formulario);	
			} else {	
				return false;
			}
		}
			
		if (formulario.accion.value=='alta') {
			if (confirm ('Esta seguro que desea dar de alta esta DDJJ?')) {
				ajax_post(div,pagina_destino,formulario);	
			} else {	
				return false;
			}
		}	
	}

	function validar_alta_carteleria(div,pagina_destino,formulario){
		
		if(formulario.id_sucursal.value == 0 || formulario.id_sucursal.value == 999 || formulario.id_sucursal.value == -1)
		{	
			
			alert('Debe seleccionar la Sucursal');
			formulario.id_sucursal.focus();
			
			return false;
		}

		if(formulario.id_agencia.value == 0 || formulario.id_agencia.value == 999 || formulario.id_agencia.value == -1)
		{	
			
			alert('Debe seleccionar la Agencia');
			formulario.id_agencia.focus();
			
			return false;
		}
			
		if (formulario.accion.value=='alta') {
			if (confirm ('Esta seguro que desea dar de alta esta DDJJ?')) {
				ajax_post(div,pagina_destino,formulario);	
			} else {	
				return false;
			}
		}	
	}