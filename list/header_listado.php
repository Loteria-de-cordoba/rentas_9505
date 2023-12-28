<?php
session_start();
/// debug
//include ("../db_conecta_adodb.inc.php");
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
require('fpdf.php');

class PDF extends FPDF
{
//Cabecera de página
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
	$this->Ln(-2);
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
 ?>