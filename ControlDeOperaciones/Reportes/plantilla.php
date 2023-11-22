<?php error_reporting(0);
/************************************************************
* Plantilla para encabezado y pie de página                 *
*                                                           *
* Fecha:    2021-02-09                                      *
* Autor:  Antonio                                           *
*                                                           *
************************************************************/
include "pdf_mc_table.php";
date_default_timezone_set('America/Mexico_City');
class PDF extends PDF_MC_Table
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image("images/logo.png", 15, 8, 16);
        // Arial bold 15
        $this->SetFont("Arial", "B", 12);
        // Título
        $this->Cell(25);
        $this->Cell(140, 5, utf8_decode("Reporte de tickets"), 0, 0, "C");
        //Fecha
        $this->SetFont("Arial", "", 10);
        $this->Cell(7, 5, "Fecha: ". date("d/m/Y g:i a"), 0, 1, "C");
        // Salto de línea
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
