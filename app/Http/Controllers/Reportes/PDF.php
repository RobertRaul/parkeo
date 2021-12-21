<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PDF extends Fpdf
{
    private $titul,$caj_id,$user_id;

    public function Cabecera($titulo,$caj_id,$user_id)
    {
        $this->titul =$titulo;
        $this->caj_id =$caj_id;
        $this->user_id =$user_id;
    }
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image(asset('images/parkeo/parking.png'), 10, 5, 20);
        $this->SetFont('Arial', 'B', 15);


        $this->Cell(80);
        $this->Cell(30,6,$this->titul,0,0,'C');
        $this->SetFont('Arial', '', 11);
        $this->Cell(85,6, 'Fecha:' . Carbon::now()->format('d/m/Y'),0,0,'R');
        $this->Ln();
        $this->Cell(80);
        $this->Cell(30,6,'Codigo: ' . '15 -' .'Usuario:'. Auth::id() ,0,0,'C');
        $this->Cell(85,6,'Hora:' . Carbon::now()->format('H:i:s'),0,0,'R');
        // >format('H:i:s d/m/Y')
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
