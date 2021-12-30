<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Reportes\PDF;
use App\Models\TipoComprobante;

class ReportTipoComprobante extends Controller
{
    public function reporte_pdf()
    {
        $pdf = new PDF('P');
        $pdf->AliasNbPages();
        $pdf->Cabecera('Reporte Tipos de Comprobante','','','P','Reportes');

        $pdf->AddPage();
        $pdf->SetFont('Arial','B',14);
        //cetramos la tabla con el MARGIN
        $pdf->SetLeftMargin(60);
        $pdf->SetWidths(array(20,50,20));
        $pdf->SetLineHeight(6);
        $pdf->SetAligns(array('C','C','C'));
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(20,6,'Id',1,0,'C');
        $pdf->Cell(50,6,'Descripcion',1,0,'C');
        $pdf->Cell(20,6,'Estado',1,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);

        $data =TipoComprobante::select('tpc_id','tpc_desc','tpc_estado')->get();

        foreach ($data as $item)
        {
            $pdf->Row(array(
                $item->tpc_id,
                $item->tpc_desc,
                $item->tpc_estado,
            ));
        }

        $pdf->Output();
        exit;
    }
}
