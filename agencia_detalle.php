<?php 
include ("..//cuenta_corriente/db_conecta_adodb.inc.php");
include ("..//cuenta_corriente/funcion.inc.php");
session_start(); 


	$_SESSION['script'] =  basename($_SERVER['PHP_SELF']);	
?> 
			<?php 
	//////////////////////  1º tabla //////////////////
			try{
	 		$rs = $db->Execute("select d.descripcion as des, concurso, sum(debe) as debe, sum(haber) as haber
 			from (select * from cuenta_corriente.movimiento_cabecera 
    			 where cod_movimiento_cabecera in (Select min(cod_movimiento_cabecera) 
	                                   				from cuenta_corriente.movimiento_cabecera 
	                                  				where fecha_valor = to_date(?,'dd/mm/yyyy')
									   				group by nro_liquidacion_bold)
													) a, cuenta_corriente.movimiento_detalle b, cuenta_corriente.juego c, 
													cuenta_corriente.concepto d
 			where a.cod_movimiento_cabecera = b.cod_movimiento_cabecera
			and b.nro_agen= ?
 			and b.cod_juego = c.cod_juego
			and c.cod_juego = ?
    		and b.cod_concepto = d.cod_concepto
 			and suc_ban = ?
 			and a.activo = 'S'
 			and b.activo = 'S'
 			and fecha_valor = to_date(?,'dd/mm/yyyy')
 			group by d.descripcion, concurso",array($_SESSION['fecha'],$_POST['agencia'], $_POST['juego'],$_POST['delegacion'],$_SESSION['fecha'])); 
			}
	catch(exception $e)
	{
	die($db->ErrorMsg());
	}?>
	 <?php  
	  //if ($rs->RowCount()==0) {
 		//	die ("<br>NO HAY MOVIMIENTOS "); 
 			//		}?>
	 <style type="text/css">
<!--
.Estilo1 {font-size: 12px}
.Estilo2 {font-size: 14px}
-->
     </style>
	 
	     <link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
	 <table width="80%" border="1" align="center">
		    <tr class="td2">
               <th width="35%" bgcolor="#CCCCCC" class="td2" scope="col"><span class="Estilo2">Concepto</span></th>
          	   <th width="15%" bgcolor="#CCCCCC" class="td2" scope="col"><span class="Estilo2">Concurso</span></th>
               <th width="25%" bgcolor="#CCCCCC" class="td2" scope="col"><span class="Estilo2">Debe</span></th>
               <th width="25%" bgcolor="#CCCCCC" class="td2" scope="col"><span class="Estilo2">Haber</span></th>
       </tr>  
		 	<tr>
			<?php while ($row = $rs->FetchNextObject($toupper=true))  {?>
               <th align="left" bgcolor="#FFFFFF" class="td" scope="col"><?php echo $row->DES;?></th>
               <td align="center" bgcolor="#FFFFFF" class="td" scope="col"><?php echo $row->CONCURSO;?></td>
               <td align="right" bgcolor="#FFFFFF" class="td" scope="col"><?php echo number_format($row->DEBE,2,',','.');?></td>
               <?php  $debet+= $row->DEBE;?>
			   <td align="right" bgcolor="#FFFFFF" class="td" scope="col"><?php echo number_format($row->HABER,2,',','.');?></td>
    			<?php $habert+= $row->HABER;?>       
		    </tr>
			<?php  }
			///////////////////////////////////////// fin 1º tabla ////////////////////////////////
			?>
	 </table>
	    
	       <?php /////////////// saldo anterior /////////////////////////////////
			try{
	 		$rs = $db->Execute("select sum(debe) as deb, sum(haber) as hab
 			from (select * from cuenta_corriente.movimiento_cabecera 
    			 where cod_movimiento_cabecera in (Select min(cod_movimiento_cabecera) 
	                                   				from cuenta_corriente.movimiento_cabecera 
	                                  				where fecha_valor < to_date(?,'dd/mm/yyyy')
									   				group by nro_liquidacion_bold)
													) a, cuenta_corriente.movimiento_detalle b, 
													cuenta_corriente.concepto d
 			where a.cod_movimiento_cabecera = b.cod_movimiento_cabecera
			and b.nro_agen= ?
 			and b.cod_concepto = d.cod_concepto
 			and suc_ban = ?
 			and a.activo = 'S'
 			and b.activo = 'S'
 			and fecha_valor < to_date(?,'dd/mm/yyyy')
 			group by b.nro_agen, suc_ban",array($_SESSION['fecha'],$_POST['agencia'],$_POST['delegacion'],$_SESSION['fecha'])); 
			}
	catch(exception $e)
	{
	die($db->ErrorMsg());
	}?>
         </p>
	     <table width="80%" border="1" align="center">
		    <tr>
               <th width="50%" bgcolor="#CCCCCC" class="td2" scope="col"><span class="Estilo2">Resumen de Cuenta</span></th>
               <th width="25%" bgcolor="#CCCCCC" class="td2" scope="col"><span class="Estilo2">Debe</span></th>
               <th width="25%" bgcolor="#CCCCCC" class="td2" scope="col"><span class="Estilo2">Haber</span></th>
            </tr>  
			
		 	<tr>
			
            <th width="50%" height="26" align="left" bgcolor="#FFFFFF" class="td" scope="col"><span class="Estilo1"><?php echo 'SALDO ANTERIOR';?></span></th>
               <?php while ($row = $rs->FetchNextObject($toupper=true))  {?>
			   <th width="25%" align="right" bgcolor="#FFFFFF" class="td" scope="col"><span class="Estilo1"><?php echo number_format($row->DEB,2,',','.');?></span></th>
               <th width="25%" align="right" bgcolor="#FFFFFF" class="td" scope="col"><span class="Estilo1"><?php echo number_format($row->HAB,2,',','.');?></span></th>
			   <?php }
				//////////////////////////// fin saldo anterior /////////////////////////////
				?>
		    </tr>
			
			<?php  ///////////////////// juego ////////////////////////////////////////// 
			
			
	try {					
			$rs_juego = $db -> Execute("select c.descripcion as des, sum(debe) as debe, sum(haber) as haber
 			from (select * from cuenta_corriente.movimiento_cabecera 
    			 where cod_movimiento_cabecera in (Select min(cod_movimiento_cabecera) 
	                                   				from cuenta_corriente.movimiento_cabecera 
	                                  				where fecha_valor = to_date(?,'dd/mm/yyyy')
									   				group by nro_liquidacion_bold)
													) a, cuenta_corriente.movimiento_detalle b, cuenta_corriente.juego c, 
													cuenta_corriente.concepto d
 			where a.cod_movimiento_cabecera = b.cod_movimiento_cabecera
			and b.nro_agen= ?
 			and b.cod_juego = c.cod_juego
			and b.cod_concepto = d.cod_concepto
 			and suc_ban = ?
 			and a.activo = 'S'
 			and b.activo = 'S'
 			and fecha_valor = to_date(?,'dd/mm/yyyy')
 			group by c.descripcion, c.cod_juego",array($_SESSION['fecha'],$_POST['agencia'],$_POST['delegacion'],$_SESSION['fecha'])); 
			}
	catch(exception $e)
	{
	die($db->ErrorMsg());
	}?>		
			<tr>
			<?php while ($row = $rs_juego->FetchNextObject($toupper=true)) {?>
               <th width="50%" align="left" bgcolor="#FFFFFF" class="td" scope="col"><span class="Estilo1"><?php echo $row->DES; ?></span></th>
			   <th width="25%" align="right" bgcolor="#FFFFFF" class="td" scope="col"><span class="Estilo1"><?php echo number_format($row->DEBE,2,',','.'); ?></span></th>
               <th width="25%" align="right" bgcolor="#FFFFFF" class="td" scope="col"><span class="Estilo1"><?php echo number_format($row->HABER,2,',','.');?></span></th>
	 	   </tr> 
				 <?php  }
				 	////////////////////////////fin juego ////////////////////////////////
				?>           
		 
		<?php ////////////////////////////// saldo actual ////////////////////////////////////////////////////////////	
		try{
	 		$rs = $db->Execute("select sum(debe) as deber, sum(haber) as haber
 			from (select * from cuenta_corriente.movimiento_cabecera 
    			 where cod_movimiento_cabecera in (Select min(cod_movimiento_cabecera) 
	                                   				from cuenta_corriente.movimiento_cabecera 
	                                  				where fecha_valor <= to_date(?,'dd/mm/yyyy')
									   				group by nro_liquidacion_bold)
													) a, cuenta_corriente.movimiento_detalle b, 
													cuenta_corriente.concepto d
 			where a.cod_movimiento_cabecera = b.cod_movimiento_cabecera
			and b.nro_agen= ?
 			and b.cod_concepto = d.cod_concepto
 			and suc_ban = ?
 			and a.activo = 'S'
 			and b.activo = 'S'
 			and fecha_valor <= to_date(?,'dd/mm/yyyy')
 			group by b.nro_agen, suc_ban",array($_SESSION['fecha'],$_POST['agencia'],$_POST['delegacion'],$_SESSION['fecha'])); 
			}
	catch(exception $e)
	{
	die($db->ErrorMsg());
	}?>
			<tr>
		       <th width="50%" height="28" align="left" bgcolor="#FFFFFF" class="td" scope="col"><?php echo 'SALDO ACTUAL';?></span></th>
			    <?php while ($row = $rs->FetchNextObject($toupper=true))  {?>
			   <th width="25%" align="right" bgcolor="#FFFFFF" class="td" scope="col"><?php echo number_format($row->DEBER,2,',','.');?></th>
               <th width="25%" align="right" bgcolor="#FFFFFF" class="td" scope="col"><?php echo number_format($row->HABER,2,',','.');?></th>
		   </tr>
				<?php  }
				////////////////////////////////////// fin saldo actual ////////////////////////////////
				?>       
		    
	 </table>
