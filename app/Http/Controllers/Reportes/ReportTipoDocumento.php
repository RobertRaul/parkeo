<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class ReportTipoDocumento extends Controller
{
 public function reporte_pdf()
 {
    $pdf = new PDF('P');
    $pdf->AliasNbPages();
    $pdf->Cabecera('Reporte Tipos de Documento','','','P','Reportes');

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

    $data =TipoDocumento::select('tpdi_id','tpdi_desc','tpdi_estado')->whereNotIn('tpdi_id',[1])->get();

    foreach ($data as $item)
    {
        $pdf->Row(array(
            $item->tpdi_id,
            $item->tpdi_desc,
            $item->tpdi_estado,
        ));
    }

    $pdf->Output();
    exit;
 }
}
