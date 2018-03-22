<?php


// error_reporting(0);

session_start();

//INCLUYO LA CONFIGURACION DE SAMRTY
require_once("libs/funciones.php");
require_once("libs/class.Conexion.BD.php");
include_once("configuracion.php");

require('libs/fpdf.php');

class PDF extends FPDF
{
    public $titulo;
    
    // Cabecera de página
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30,10,$this->titulo,1,0,'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}


// Carga de datos
$conn->conectar();


$param = array(
    array("id", $_GET["publicacion"], "int")
);

$sql = "select * from publicaciones where id = :id";

$conn->consulta($sql, $param);

$noticia = $conn->siguienteRegistro();

$pdf = new PDF();

$pdf->titulo = $noticia["nombre"];

$pdf->AliasNbPages();
$pdf->AddPage();

// Logo
$pdf->Image('imgs/logo.png',10,20,20,20);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,25,utf8_decode($noticia["descripcion"]),0,1);

        
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,utf8_decode('Imprimiendo línea número '.$i),0,1);

$pdf->Output();
