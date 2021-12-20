<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Auth;
class PDF extends Fpdf
{
    private $titul;

    public function Tittle($titulo)
    {
        $this->titul =$titulo;
    }
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image(asset('images/parkeo/parking.png'), 10, 5, 20);        
        $this->SetFont('Arial', 'B', 15);
                
     
        $this->Cell(80);
        $this->Cell(30,6,$this->titul,0,0,'C');       
        $this->SetFont('Arial', '', 12); 
        $this->Cell(85,6, 'Fecha:' . '20/12/2021',0,0,'R');
        $this->Ln();
        $this->Cell(80);
        $this->Cell(30,6,'Codigo: ' . '15 -' .'Usuario:'. Auth::id() ,0,0,'C');        
        $this->Cell(85,6,'Hora:' . '15:33:12',0,0,'R');
    
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
