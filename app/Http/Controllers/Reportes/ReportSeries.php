<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Http\Request;

class ReportSeries extends Controller
{
    public function reporte_pdf()
    {
        $pdf = new PDF('P');
        $pdf->AliasNbPages();
        $pdf->Cabecera('Reporte de Series','','','P','Reportes');

        $pdf->AddPage();
        $pdf->SetFont('Arial','B',14);
        //cetramos la tabla con el MARGIN
        $pdf->SetLeftMargin(20);
        $pdf->SetWidths(array(20,40,30,50,30));
        $pdf->SetLineHeight(6);
        $pdf->SetAligns(array('C','C','C','C','C'));
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(20,6,'Id',1,0,'C');
        $pdf->Cell(40,6,'Comprobante',1,0,'C');
        $pdf->Cell(30,6,'Serie',1,0,'C');
        $pdf->Cell(50,6,'Numeracion Actual',1,0,'C');
        $pdf->Cell(30,6,'Estado',1,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);

        $data = Serie::join('tipo_comprobante','tpc_id','=','ser_tpcomid')
        ->select('ser_id','tpc_desc','ser_serie','ser_numero','ser_estado')
        ->get();
        foreach ($data as $item)
        {
            $pdf->Row(array(
                $item->ser_id,                
                $item->tpc_desc,
                $item->ser_serie,                
                $item->ser_numero,
                $item->ser_estado,                
            ));
        }
        // es el margen exacto para corregir el pie de pagina
        $pdf->SetLeftMargin(10);
        $pdf->Output();
        exit;
    }
}
