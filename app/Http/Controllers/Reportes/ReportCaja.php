<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Reportes\PDF;


class ReportCaja extends Controller
{
    public function Prueba()
    {
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->Tittle('Reporte General de Caja');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Hola, Mundo');
        $pdf->Output();
        exit;
    }
}
