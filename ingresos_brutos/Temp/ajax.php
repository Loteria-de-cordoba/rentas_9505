<?php
session_start();
include_once '../../../db.php';
include_once '../../../mensajes.php';
if (isset( $_GET['accion'])) {
    $accion = $_GET['accion'];
} else {

    $accion = $_POST['accion'];
}
$idalmacen = $_GET['idalmacen'];
$cajero = str_replace(',',' ', $_GET['cajero_apertura']);
//var_dump($_GET);

switch ($accion) {
    case 'crear_pedido':

        ?>  
        <br>
        
        <form method="post" onsubmit="consulta(<?php echo $_GET['idalmacen']; ?>,document.getElementById('idpm').value,'<?php echo $_GET['cajero_apertura']; ?>'); return false;">
            <div class="col-md-12"> 
                <div class="col-md-3"></div>
                    <div class="col-md-6">        
                        <label class="ml2">Pago Manual</label>
                        <input type="text" id="idpm" class="input-sm tderecha ml2" placeholder="Ingrese el id del Pago Manual">
                        <input type="submit" value="Enviar" class="panel-success ml2">            
                    </div>
                <div class="col-md-3"></div>
            </div>
        </form>
        <script>
    document.getElementById('idpm').addEventListener('keypress', function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });
</script>

        <br><br>

        <div class="col-md-12"> 
            <?php
            $total = 0;
            $total2 = 0;
            try {
                    // $sql = "SELECT idpm,importe from pagos_manuales pm where idalmacen = ? and idfechaoperacion =? order by 1";
                    // $result= $dbpm->Execute($sql, array($_GET['idalmacen'], $_SESSION['s_fecha_id']));

                    $sql = "SELECT pm.idpm,importe,concat(pm.uid,'(',pm.juego,')') as maquina ,
                    pme.usuario AS autoriza, date_format(pm.created_at,'%d/%m/%Y %H:%i:%s') as fecha_hora,
                    CONCAT(pm.apellido,', ',pm.nombre,' (',pm.dni,')') as cliente  
                    from pagos_manuales pm, pagos_manuales_estados pme  
                    where idalmacen = ? and idfechaoperacion =? and pm.idpm =pme.idpm 
                    and pm.estado_actual = pme.estado
                    order by 1";
                    $result= $dbpm->Execute($sql, array($_GET['idalmacen'], $_SESSION['s_fecha_id']));


            } catch (exception $e) {
                error_mysql();
            }
                
            ?>

            <div class="panel panel-success">
                <div class="panel-heading">
                    Pagos Manuales Validados
                </div>
                <div class="panel-body">
                    <div class="col-md-12"> 
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                        <table class="table table-condensed table-striped small" ><tr>
                                <td>&nbsp;</td>
                                <td class="tcentro"><h5>ID</h5></td>
                                <td class="tcentro"><h5>Maquina</h5></td>
                                <td class="tcentro"><h5>Autoriza</h6></td>
                                <td class="tcentro"><h5>Fecha</h6></td> 
                                <td class="tcentro"><h5>Importe</h6></td>
                                <td class="tcentro"><h5>Acciones</h6></td>    
                                <td>&nbsp;</td>
                            </tr>
                            <?php
                            while ($row = siguiente($result)) {
                                $total+= 1;
                                $total2+=$row->IMPORTE;
                                ?>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td class="tderecha"><?php echo $row->IDPM; ?></td>
                                    <td class="tizquierda"><?php echo $row->MAQUINA; ?></td>
                                    <td class="tizquierda"><?php echo $row->AUTORIZA; ?></td>
                                    <td class="tizquierda"><?php echo $row->FECHA_HORA; ?></td>
                                    <td class="tderecha"><?php echo number_format($row->IMPORTE, 2, ',', '.'); ?></td>
                                    <td class="tcentro">
                                        <a class="btn btn-danger" title="Cancela el Pago Maunal VALIDADO!!!" href="#"><i class="fa fa-trash-o fa-lg" onclick="CancelarPm(<?php echo $idalmacen; ?>,<?php echo $row->IDPM; ?>);" ></i></a>
                                    </td>


                                    <td>&nbsp;</td>                                    
                                </tr> 
                            <?php } ?>
                            <tr>
                                <td colspan="5"><h5>Total </h5></td>
                                <!-- <td class="tderecha"><h5><?php echo number_format($total, 0, ',', '.'); ?></h5></td> -->
                                <td class="tderecha"><h5><?php echo number_format($total2, 2, ',', '.'); ?></h5></td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        </div>
                        <div class="col-md-1"></div>                     

                    </div>  
                </div>  
            </div>
        </div>
        
        <?php
        break;

        case 'consultar':

            /* Obtengo datos del Pago Manual a Confirmar */
            
            $sql = "SELECT pm.idpm,importe,concat(pm.uid,' (',pm.juego,')') as maquina ,
            pme.usuario AS autoriza, date_format(pm.created_at,'%d/%m/%Y %H:%i:%s') as fecha_hora,pm.estado_actual,
            CONCAT(pm.apellido,', ',pm.nombre,' (',pm.dni,')') as cliente,pm.importe_letras
            from pagos_manuales pm, pagos_manuales_estados pme  
            where  pm.idpm =? and pm.idpm =pme.idpm and pm.estado_actual = pme.estado" ;
            $result = $dbpm->Execute($sql, array($_POST['idpm'],'pendiente de pago'));

            $row = siguiente($result);

            $datos['idpm2']     = number_format($row->IDPM, 0, ',', '.');
            $datos['idpm']     = $row->IDPM;
            $datos['maquina']  = $row->MAQUINA;
            $datos['importe2']  =  '$ '.strval(number_format($row->IMPORTE, 2, ',', '.'));
            $datos['importe']  =  ($row->IMPORTE);
            $datos['importe_letras']  = $row->IMPORTE_LETRAS;
            $datos['cliente']  = $row->CLIENTE;
            $datos['autoriza'] = $row->AUTORIZA;
            $datos['fecha']    = $row->FECHA_HORA;
            $datos['estado_actual']    = $row->ESTADO_ACTUAL;


            $message['datos']    = $datos;

            header('Content-type: text/json');
            header('Content-type: application/json');
            die(json_encode($message));
        break;

    case 'Confirmar_Pm':
    // die('entro......');


        try {
            $sql = "SELECT pm.idpm,importe,pm.importe_letras,pm.uid,
                    pme.usuario AS autoriza,pme.idusuario ,pm.estado_actual, date_format(pm.created_at,'%d/%m/%Y %H:%i:%s') as fecha_hora,
                    CONCAT(pm.apellido,', ',pm.nombre,' (',pm.dni,')') as cliente,pm.dni  
                    from pagos_manuales pm, pagos_manuales_estados pme  
                    where pm.idpm = ? and pme.estado=? and pm.idpm =pme.idpm ";
            $result = $dbpm->Execute($sql, array($_GET['idpm'],'pendiente de pago'));
            // $result = $dbpm->Execute($sql, array($_GET['idpm'],'autorizado'));
        } catch (exception $e) {
            error_mysql();
        }
        
        $row = siguiente($result);

        //die('Estado...'.$row->ESTADO_ACTUAL);
        // die('Registros... '.$result->RowCount());

        if ($result->RowCount() == 0) {
            die("Esta Pago Manual no existe y/o no esta PENDIENTE DE PAGO...!!!");
        }elseif($row->ESTADO_ACTUAL=='pagado'){
        //$db->debug = true;            
            die(' Esta Pago Manual no existe y/o no esta PENDIENTE DE PAGO...!!!');
        }else{
            $idalmacen=$_GET['idalmacen'];

            try {
            $sql = "update pagos_manuales pm  set estado_actual =?,idfechaoperacion =?,idalmacen =?, cajero=?
                    where idpm = ? and estado_actual = ?";
            $result = $dbpm->Execute($sql, array('pagado', $_SESSION['s_fecha_id'], $_GET['idalmacen'],$_GET['cajero_apertura'],$row->IDPM,'pendiente de pago'));
            // $result = $dbpm->Execute($sql, array('pagado', $_SESSION['s_fecha_id'], $_GET['idalmacen'],$_GET['cajero_apertura'],$_GET['idpm'],'autorizado'));

           // die($result);
            } catch (exception $e) {
            print($e);
        }
            
            if ($dbpm->Affected_Rows() == 0){
                       die('El Pago Manual ya fue Validado o no esta PENDIENTE DE PAGO !!!');
            }else{
                    /*Inserto datos en Pagos Manuales estado */
                    //$dbpm->debug = true; 
                    $sql = "insert into pagos_manuales_estados (idpme,idpm,estado,idusuario) 
                    values(?,?,?,?)";
                    
                    try{

                     //$result = $dbpm->Execute($sql, array(null,$row->IDPM,'pagado',$row->AUTORIZA,$row->IDUSUARIO));
                     $result = $dbpm->Execute($sql, array(null,$row->IDPM,'pagado','9999'));

                    //die();
                    } catch (exception $e) {
                        print($e);
                    }


                     /*update de cajero en datos en Pagos Manuales estado */
                    //$dbpm->debug = true; 
                    $sql = "update pagos_manuales_estados set usuario = ? where idpme=last_insert_id()";
                    
                    try{

                     //$result = $dbpm->Execute($sql, array(null,$row->IDPM,'pagado',$row->AUTORIZA,$row->IDUSUARIO));
                     $result = $dbpm->Execute($sql, array($cajero));

                    //die();
                    } catch (exception $e) {
                        print($e);
                    }
            }
            
            
        
        //die();
        //FinalizarTransaccion($db);

        die('Se VALIDO el PAGO MANUAL correctamente !!!');       
    }
        break;

    case 'guardar_pm':
        //ComenzarTransaccion($db);
        //$db->debug = true;
        //----------------------------------
        //CREDIT
        //----------------------------------
        try {
            $sql = "update pagos_manuales pm  set estado_actual =?,idfechaoperacion =?,idalmacen =?, cajero=?
                    where idpm = ? and estado_actual = ?";
            $result = $dbpm->Execute($sql, array('pagado', $_SESSION['s_fecha_id'], $_GET['idalmacen'],$_GET['cajero_apertura'],$_GET['idpm'],'pendiente de pago'));
            // $result = $dbpm->Execute($sql, array('pagado', $_SESSION['s_fecha_id'], $_GET['idalmacen'],$_GET['cajero_apertura'],$_GET['idpm'],'autorizado'));

           // die($result);
            
            if ($dbpm->Affected_Rows() == 0){
                       die('El Pago Manual ya fue Validado o no esta PENDIENTE DE PAGO !!!');
            }else{
                    /*Inserto datos en Pagos Manuales estado */
                    $sql = "insert into pagos_manuales_estados (idpme,idpm,estado,fecha,usuario,idusuario) 
                    values(?,?,?,(select SYSDATE()),?,'9997')";
                    try{

                     //$result = $dbpm->Execute($sql, array(null,$_GET['idpm'],'pagado',$_GET['autoriza'],$_GET['idusuario']));
                     $result = $dbpm->Execute($sql, array(null,$_GET['idpm'],'pagado',$cajero));
                    } catch (exception $e) {
                        error_mysql();
                    }
            }
            
        } catch (exception $e) {
            error_mysql();
        }
        //die();
        //FinalizarTransaccion($db);

        die('Se VALIDO el PAGO MANUAL correctamente !!!');
        break;

    case 'cancelar_pm':
        //ComenzarTransaccion($db);
        //$db->debug = true;
        //----------------------------------
        //CREDIT
        //----------------------------------
        try {
            $sql = "update pagos_manuales pm  set estado_actual =?,idfechaoperacion ='',idalmacen ='',cajero=''
                    where idpm = ?";
            $result = $dbpm->Execute($sql, array('pendiente de pago', $_GET['idpm']));
             // $result = $dbpm->Execute($sql, array('autorizado', $_GET['idpm']));


            $sql = "delete from pagos_manuales_estados  where idpm = ? and estado = ?";
            $result = $dbpm->Execute($sql, array($_GET['idpm'],'pagado'));

            die(' El Pago Manual CANCELA con exito !!!');
            
            
        } catch (exception $e) {
            error_mysql();
        }
        //die();
        //FinalizarTransaccion($db);

        //die(ok_json('Se CANCELO el PAGO MANUAL correctamente !!!', ''));
        break;

}