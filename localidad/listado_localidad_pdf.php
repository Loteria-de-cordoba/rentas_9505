<?php session_start(); 
include ("../db_conecta_adodb.inc.php");
error_reporting(E_ERROR);
ini_set("display_errors",1);
//die($id_provincia);
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
//die('soquete');

//require("header.php"); 	
require('../list/fpdf.php');	
//print_r($_SESSION);


$id_provincia= (isset($_GET['id_provincia'])) ? $_GET['id_provincia'] : '';



try{	
	$rs_prov= $db->Execute("select  descripcion 
                			from impuestos.t_provincias
							where id_provincia = $id_provincia");
	}
	catch(exception $e){die($db->ErrorMsg());
	}
	
$row = $rs_prov->FetchNextObject($toupper=true);

$provincia = $row->DESCRIPCION;

$titulo='LISTADO DE LOCALIDADES';
$titulo2= 'PROVINCIA DE: '.$provincia;




 

class PDF extends FPDF
{
function Header()
 {

 global $titulo,$titulo2;
  	$this->Image('../image/LOGOhorizontal.jpg',15,6,30,10);
    $this->Image('../image/banderacordoba.jpg',180,6,20,10);
	
     //Times bold 15
    $this->SetFont('Times','B',13);
	$this->Ln(-1);
	$y_line=$this->GetY();
    //Movernos a la derecha
    $this->Cell(80);
    //Título
	$y_line=$this->GetY();
	$this->Cell(30,$y_line,'LOTERIA DE CORDOBA S.E.',0,0,'C');
  
    $this->SetFont('Times','I',8);
	$y_line=$this->GetY();
	$this->Ln(5);
	$this->Cell(80);
	$this->Cell(30,$y_line,'27 de Abril 185 - Cordoba - Republica Argentina',0,1,'C');
 
 	
  
	$y_line=$this->GetY();
	$this->Line(10,$y_line,201,$y_line);

	 //Salto de línea
	$this->Ln(-3);
 	//Arial bold 15
    $this->SetFont('Arial','BI',11);
	$y_line=$this->GetY();
   	$this->Cell(190,$y_line,$titulo,0,1,'C');
   	if ($titulo2<>''){
	$this->Ln(-5);
	$y_line=$this->GetY();
	$this->SetFont('Arial','BI',10);
	$this->MultiCell(190,4,$titulo2,0,'C');
	 $this->Ln();
	}
  }

  
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
	$y_line=$this->GetY();
	$this->Line(10,$y_line,200,$y_line);
//	$this->Ln(5);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,7,'Usuario: '.$_SESSION['nombre_usuario'].'  '. date('d/m/Y h:i:s A'),0,0,'L');
    $this->Cell(0,7,utf8_decode('Página: ').$this->PageNo()."/{nb}",0,0,'R');

}
 }

//$db->debug=true;

try { $rs = $db->Execute($_SESSION['sql']);
	 }
	catch(exception $e)
	{
	die("Error");
	}
	
$pdf=new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
//$pdf->setY(60);
$corte =0;
$salto_pagina=275;
$pri='NO';




if ($salto_pagina > 270) {
		$salto_pagina=0;
		if ($pri=='NO'){

				$pdf->SetFont('Arial','B',9);
				//$pdf->Ln(+2);
				$pdf->Cell(45,5,'',0,0,'L'); 
				$pdf->SetFillColor(176,176,176);
				$pdf->SetFont('Arial','B',8);
				//$pdf->Cell(50,8,'CODIGO',1,0,'C',1); 
				$pdf->Cell(100,8,'LOCALIDAD',1,1,'C',1);	 	 
} else {
			$pri='NO';
			}
} 
while ($row = $rs->FetchNextObject($toupper=true)) {

						$pdf->SetFont('Arial','',8);
						$pdf->Cell(45,5,'',0,0,'L'); 
						//$pdf->Cell(50,6,$row->CODIGO ,0,0,'L');
						$pdf->Cell(100,6,$row->DESCRIPCION,0,1,'L');
						//$pdf->Cell(30,6,number_format($row->PORCENTAJE,2,',','.').' %',0,1,'R'); 
						$y_line=$pdf->GetY();
						$salto_pagina=number_format($y_line,0,'.',',');
			$y_line=$pdf->GetY();
			$salto_pagina=number_format($y_line,0,'.',',');
	
			if ($salto_pagina > 270) 
				{
				$salto_pagina=0;
				if ($pri=='NO')
					{
					$pdf->SetFont('Arial','B',9);
					//$pdf->Ln(+2);
					$pdf->Cell(45,5,'',0,0,'L'); 
					$pdf->SetFillColor(176,176,176);
					$pdf->SetFont('Arial','B',8);
					//$pdf->Cell(50,8,'CODIGO',1,0,'C',1); 
					$pdf->Cell(100,8,'LOCALIDAD',1,1,'C',1);	 	
	} else {
				$pri='NO';
			}
		}	
}
$pdf->Output();							
?> 