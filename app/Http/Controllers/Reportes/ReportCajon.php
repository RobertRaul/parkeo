<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Cajon;
use Illuminate\Http\Request;

class ReportCajon extends Controller
{
    public function reporte_pdf()
    {
        $pdf = new PDF('P');
        $pdf->AliasNbPages();
        $pdf->Cabecera('Reporte de Cajones','','','P','Reportes');

        $pdf->AddPage();
        $pdf->SetFont('Arial','B',14);
        //cetramos la tabla con el MARGIN
        $pdf->SetLeftMargin(50);
        $pdf->SetWidths(array(20,30,40,30));
        $pdf->SetLineHeight(6);
        $pdf->SetAligns(array('C','C','C','C'));
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(20,6,'Id',1,0,'C');
        $pdf->Cell(30,6,'Tp. Vehiculo',1,0,'C');
        $pdf->Cell(40,6,'Cajones',1,0,'C');
        $pdf->Cell(30,6,'Estado',1,0,'C');        
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);

        $data = Cajon::join('tipo_vehiculo','tip_id','=','caj_tipoid')
                ->select('caj_id','tip_desc','caj_desc','caj_estado')
                ->get();
        foreach ($data as $item)
        {
            $pdf->Row(array(
                $item->caj_id,
                $item->tip_desc ,            
                $item->caj_desc ,
                $item->caj_estado,
            ));
        }
        // es el margen exacto para corregir el pie de pagina
        $pdf->SetLeftMargin(10);
        $pdf->Output();
        exit;
    }
}
