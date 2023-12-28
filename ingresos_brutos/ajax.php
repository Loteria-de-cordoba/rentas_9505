<?php
session_start();
//include_once '../../../mensajes.php';
include ("../db_conecta_adodb.inc.php");
include ("../funcion.inc.php"); 


    $accion = $_GET['accion'];
    $periodo = $_GET['periodo'];

   //$db->debug=true;

//die(print_r($_GET));

switch ($accion) {

    case 'ConsultarPeriodo':
    

        try{$rs_verificar_perioro = $db->Execute("SELECT count(*) as cantidad from IMPUESTOS.t_dgr_reporte_mensual
            where periodo=?",array($periodo));
        } catch (exception $e){die ($db->ErrorMsg());}

        $row = $rs_verificar_perioro->FetchNextObject($toupper=true); 
        //$ok1 = $row->CANTIDAD;
        $message['filas']  = $row->CANTIDAD;

            

        die($message['filas']);

        // header('Content-type: text/json');
        // header('Content-type: application/json');
        // die(json_encode($message));

        break;

}