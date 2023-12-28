<script>
    $(document).ready(function () {

        cargarIndex();
        $('#monto').focus();

    });


    function cargarIndex() {
        $.get('almacen_moneda/operacion/pagos_manuales/ajax.php?accion=crear_pedido&idalmacen=<?php echo $_GET['idalmacen']; ?>&cajero_apertura=<?php echo $_GET['cajero_apertura']; ?>',
                function (data) {
                    try {
                        // $('#formulario_transferencia').html(data);
                        $('#formulario_operacion').html(data);
                        
                        //conceptosDisponibles(<?php echo $_GET['idalmacen']; ?>);
                    } catch (e) {
                        alert(data);
                    }
                }
        );
    }

    function guardarpm(idalmacen,idpm,autoriza,idusuario,cajero_apertura) {
        var variables = {'idalmacen': idalmacen,
            'idpm': idpm,
            'autoriza': autoriza,
            'idusuario': idusuario,
            'cajero_apertura': cajero_apertura
        };
                   
            $.get('almacen_moneda/operacion/pagos_manuales/ajax.php?accion=guardar_pm', variables,
                    function (data) {
                        try {

                        bootbox.alert(data, function () {
                           cargarIndex();
                        });


                            
                        } catch (e) {
                            alert(data);
                        }
                    }
            );
    }




    function consulta(idalmacen,idpmm,cajero_apertura){

      if (idpmm == "") {

            Swal.fire({
                     icon: 'error',
                     title: 'Ocurrio un Error...',
                     text: 'El Campo Pago Manual No puede estar VACIO!!!',
                     footer: '<a href=""></a>'
                 })

            return false;
       } 

       var noError = false;

       var almacen = idalmacen;
       var cap = cajero_apertura;

        var variables = {'idpm': idpmm,
        'accion' :  'consultar'};

        $.post('almacen_moneda/operacion/pagos_manuales/ajax.php',variables,
                        function (data) {

                        if(data.datos.estado_actual =='pagado') {        
                            //bootbox.alert('El Pago Manual ya fue validado!!!');

                         Swal.fire({
                             icon: 'error',
                             title: 'Ocurrio un Error...',
                             text: 'El Pago Manual ya fue validado!!!',
                             footer: '<a href=""></a>'
                         })

                            return false;        
                        }

                        if(data.datos.estado_actual =='anulado') {        
                            //bootbox.alert('El Pago Manual ya fue validado!!!');

                         Swal.fire({
                             icon: 'error',
                             title: 'Ocurrio un Error...',
                             text: 'El Pago Manual esta ANULADO!!!',
                             footer: '<a href=""></a>'
                         })

                            return false;        
                        }
                                    Importe = (data.datos.importe);
                                    Importe2 = (data.datos.importe2);
                                    Maquina  = (data.datos.maquina);
                                    IdPmm    = parseInt(data.datos.idpm);
                                    IdPmm2    = (data.datos.idpm2);
                                    Autoriza    = data.datos.autoriza;
                                    Cliente    = data.datos.cliente;
                                    ImpLetras  = data.datos.importe_letras;
                                    Swal.fire({
                                          title: 'Pago Manual',
                                          width: 600,
                                          html: `<table width='100%' class='table table-striped'><tr><th class='tcentro'>Descripcion</th><th class='tcentro'>Datos</th></tr> <tr><th class="tizquierda">Id PM</th><td class="tderecha">${IdPmm2}</td></tr><tr>
                                <th class="tizquierda">Maquina</th>
                                <td class="tizquierda">${Maquina}</td>
                            </tr><tr>
                                <th class="tizquierda">Cliente</th>
                                <td class="tizquierda">${Cliente}</td>
                            </tr><tr>
                                <th class="tizquierda">Autorizaco Por</th>
                                <td class="tizquierda">${Autoriza}</td>
                            </tr><tr>
                                <th class="tizquierda"><h4>Importe</h4></th>
                                <td class="tderecha"><h4>${Importe2}</h4></td>
                            </tr><tr></tr><tr>
                                <td class="tizquierda" colspan="2"><h5>${ImpLetras}</h5></td>
                            </tr>  </table>`  ,
                                          icon: 'question',
                                          showCancelButton: true,
                                          confirmButtonColor: '#3085d6',
                                          cancelButtonColor: '#d33',
                                          confirmButtonText: ' Aceptar '
                                        }).then((result) => {
                                          if (result.isConfirmed) {
                                            //console.log('entro aca');
                                            Confirmar_Pm(almacen,IdPmm,cajero_apertura); 
                                            noError = true;                                           
                                          }else{
                                            noError = false;
                                          }
                                        })                                    
                                                                            
                                                });

        

                             return noError;

    
    }



    function Confirmar_Pm(idalmacen,idpm,cajero_apertura) {

                var variables = {'idalmacen': idalmacen,
                    'idpm': idpm,
                    'cajero_apertura': cajero_apertura
                };        



             
                   $.get('almacen_moneda/operacion/pagos_manuales/ajax.php?accion=Confirmar_Pm', variables,
                        function (data) {
                         try {
                                //bootbox.alert(data, function () { });

                                 Swal.fire({
                                 icon: 'success',
                                 title: 'Mensaje...',
                                 text: 'Se VALIDO el PAGO MANUAL correctamente !!!',
                                 footer: '<a href=""></a>'
                                })

                                consultarPm(<?php echo $_GET['idalmacen']; ?> ,'<?php echo $_GET['cajero_apertura']; ?>');                                
                            } catch (e) {
                                alert(data);
                            }                    
                        }
                    );
                
     }


    function CancelarPm(idalmacen,idpm) {
        var variables = {'idalmacen': idalmacen,
            'idpm': idpm
        };
        $.get('almacen_moneda/operacion/pagos_manuales/ajax.php?accion=cancelar_pm', variables,
                    function (data) {
                        try {
                            consultarPm(<?php echo $_GET['idalmacen']; ?> ,'<?php echo $_GET['cajero_apertura']; ?>');

                            Swal.fire({
                             icon: 'success',
                             title: 'Mensaje...',
                             text: 'El Pago Manual CANCELA con exito !!!',
                             footer: '<a href=""></a>'
                            })
                            
                        //      bootbox.alert(data, function () {
                            
                        // });
                        } catch (e) {
                            alert(data);
                        }
                    }
            );
    }



</script>

<!-- <div id="formulario_transferencia"></div> -->
<div id="formulario_operacion"></div>