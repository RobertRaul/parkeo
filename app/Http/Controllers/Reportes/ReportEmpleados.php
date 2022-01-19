<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\Request;

class ReportEmpleados extends Controller
{
    public function reporte_pdf()
    {
        $pdf = new PDF('P');
        $pdf->AliasNbPages();
        $pdf->Cabecera('Reporte de Empleados','','','P','Reportes');

        $pdf->AddPage();
        $pdf->SetFont('Arial','B',14);
        //cetramos la tabla con el MARGIN
        //$pdf->SetLeftMargin(20);
        $pdf->SetWidths(array(10,20,20,30,20,20,20,30,20));
        $pdf->SetLineHeight(6);
        $pdf->SetAligns(array('C','C','C','C','C','C','C','C'));
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10,6,'Id',1,0,'C');
        $pdf->Cell(20,6,'Tp. Doc',1,0,'C');
        $pdf->Cell(20,6,'Nro Doc',1,0,'C');
        $pdf->Cell(30,6,'Apellidos',1,0,'C');
        $pdf->Cell(20,6,'Nombres',1,0,'C');
        $pdf->Cell(20,6,'Celular',1,0,'C');
        $pdf->Cell(20,6,'Email',1,0,'C');
        $pdf->Cell(30,6,'Direccion',1,0,'C');
        $pdf->Cell(20,6,'Estado',1,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);

        $data = Empleado::join('tipo_doc_identidad','tpdi_id','=','emp_tpdi')
                ->select('emp_id','tpdi_desc','emp_numdoc','emp_apellidos','emp_nombres','emp_celular','emp_email','emp_direccion','emp_estado')
                ->get();
        foreach ($data as $item)
        {
            $pdf->Row(array(
                $item->emp_id,
                $item->tpdi_desc,
                $item->emp_numdoc,
                $item->emp_apellidos,
                $item->emp_nombres,
                $item->emp_celular,
                $item->emp_email,
                $item->emp_direccion,
                $item->emp_estado,
         
            ));
        }
        // es el margen exacto para corregir el pie de pagina
        $pdf->SetLeftMargin(10);
        $pdf->Output();
        exit;
    }
}
