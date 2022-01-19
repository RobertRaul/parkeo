<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use App\Models\User;
use Illuminate\Http\Request;

class ReportUsuarios extends Controller
{
    public function reporte_pdf()
    {
        $pdf = new PDF('P');
        $pdf->AliasNbPages();
        $pdf->Cabecera('Reporte de Usuarios','','','P','Reportes');

        $pdf->AddPage();
        $pdf->SetFont('Arial','B',14);
        //cetramos la tabla con el MARGIN
        $pdf->SetLeftMargin(20);
        $pdf->SetWidths(array(10,20,30,50,40,30));
        $pdf->SetLineHeight(6);
        $pdf->SetAligns(array('C','C','C','L','C','C'));
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10,6,'Id',1,0,'C');
        $pdf->Cell(20,6,'Usuario',1,0,'C');
        $pdf->Cell(30,6,'Rol',1,0,'C');
        $pdf->Cell(50,6,'Empleado',1,0,'C');
        $pdf->Cell(40,6,'Fecha R.',1,0,'C');
        $pdf->Cell(30,6,'Estado',1,0,'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);

        $data = User::join('empleados','emp_id','=','us_empid')
        ->select('us_id','us_usuario','us_rol','emp_apellidos','emp_nombres','us_fechr','us_estado')
        ->get();
        
        foreach ($data as $item)
        {
            $pdf->Row(array(
                $item->us_id,
                $item->us_usuario,
                $item->us_rol,
                $item->emp_apellidos . ' '. $item->emp_nombres,
                $item->us_fechr,     
                $item->us_estado,          
            ));
        }
        // es el margen exacto para corregir el pie de pagina
        $pdf->SetLeftMargin(10);
        $pdf->Output();
        exit;
    }
}
