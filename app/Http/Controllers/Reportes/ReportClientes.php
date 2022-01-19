<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ReportClientes extends Controller
{
    public function reporte_pdf()
    {
        $pdf = new PDF('P');
        $pdf->AliasNbPages();
        $pdf->Cabecera('Reporte de Clientes','','','P','Reportes');

        $pdf->AddPage();
        $pdf->SetFont('Arial','B',14);
        //cetramos la tabla con el MARGIN
        $pdf->SetLeftMargin(20);
        $pdf->SetWidths(array(10,20,20,50,25,30,20));
        $pdf->SetLineHeight(6);
        $pdf->SetAligns(array('C','C','C','C','C','C','C'));
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10,6,'Id',1,0,'C');
        $pdf->Cell(20,6,'Tp. Doc',1,0,'C');
        $pdf->Cell(20,6,'Nro Doc',1,0,'C');
        $pdf->Cell(50,6,'Nombres',1,0,'C');
        $pdf->Cell(25,6,'Celular',1,0,'C');
        $pdf->Cell(30,6,'Email',1,0,'C');
        $pdf->Cell(20,6,'Estado',1,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);

        $data = Cliente::join('tipo_doc_identidad','tpdi_id','=','clie_tpdi')
        ->whereNotIn('clie_id',[1])
        ->select('clie_id','tpdi_desc','clie_numdoc','clie_nombres','clie_celular','clie_email','clie_estado')
        ->get();
        foreach ($data as $item)
        {
            $pdf->Row(array(
                $item->clie_id,
                $item->tpdi_desc,
                $item->clie_numdoc,
                $item->clie_nombres,
                $item->clie_celular,
                $item->clie_email,
                $item->clie_estado,
            ));
        }
        // es el margen exacto para corregir el pie de pagina
        $pdf->SetLeftMargin(10);
        $pdf->Output();
        exit;
    }
}
