<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Tarifa;
use Illuminate\Http\Request;

class ReportTarifa extends Controller
{
    public function reporte_pdf()
    {
        $pdf = new PDF('P');
        $pdf->AliasNbPages();
        $pdf->Cabecera('Reporte de Tarifas','','','P','Reportes');

        $pdf->AddPage();
        $pdf->SetFont('Arial','B',14);
        //cetramos la tabla con el MARGIN
        $pdf->SetLeftMargin(20);
        $pdf->SetWidths(array(20,30,40,50,30));
        $pdf->SetLineHeight(6);
        $pdf->SetAligns(array('C','C','C','C','C'));
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(20,6,'Id',1,0,'C');
        $pdf->Cell(30,6,'Tiempo',1,0,'C');
        $pdf->Cell(40,6,'Costo por Hora',1,0,'C');
        $pdf->Cell(50,6,'Tolerancia en Minutos',1,0,'C');
        $pdf->Cell(30,6,'Estado',1,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);

        $data = Tarifa::select('tar_id','tar_valor','tar_tiempo','tar_tolerancia','tar_precio','tar_estado')->get();

        foreach ($data as $item)
        {
            $pdf->Row(array(
                $item->tar_id,
                $item->tar_valor .' '.$item->tar_tiempo,
                'S/ '.$item->tar_precio,
                $item->tar_tolerancia . ' Minutos',
                $item->tar_estado,
            ));
        }

        $pdf->Output();
        exit;
    }
}
