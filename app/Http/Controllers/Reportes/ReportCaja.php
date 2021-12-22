<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Reportes\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;
use PhpParser\Node\Expr\FuncCall;

class ReportCaja extends Controller
{
    public function Reporte_Caja($idcaja)
    {
        $pdf = new PDF('L');
        $pdf->AliasNbPages();
        $pdf->Cabecera('Reporte General de Ingresos a Caja',$idcaja, auth()->user()->us_usuario,'L');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        //set width for each column (6 columns)
        $pdf->SetWidths(array(20, 50, 20, 15, 20, 20, 20, 20, 20, 20, 55));
        //set line height. This is the height of each lines, not rows.
        $pdf->SetLineHeight(6);
        //set alignment
        $pdf->SetAligns(array('C', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'L'));
        //add table heading using standard cells
        //set font to bold
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(20, 6, "Ticket", 1, 0, 'C');
        $pdf->Cell(50, 6, "Cliente", 1, 0, 'C');
        $pdf->Cell(20, 6, "Tp. Pago", 1, 0, 'C');
        $pdf->Cell(15, 6, "Ref", 1, 0, 'C');
        $pdf->Cell(20, 6, "Placa", 1, 0, 'C');
        $pdf->Cell(20, 6, "Cajon", 1, 0, 'C');
        $pdf->Cell(20, 6, "Tarifa", 1, 0, 'C');
        $pdf->Cell(20, 6, "Horas", 1, 0, 'C');
        $pdf->Cell(20, 6, "Total", 1, 0, 'C');
        $pdf->Cell(20, 6, "Estado", 1, 0, 'C');
        $pdf->Cell(55, 6, "Motivo Anulacion", 1, 0, 'C');
        //add a new line
        $pdf->Ln();
        //reset font
        $pdf->SetFont('Arial', '', 10);

        $data = DB::table('ingresos as i')
            ->join('cajas as c', 'c.caj_id', '=', 'i.ing_cajid')
            ->join('rentas as r', 'r.rent_id', '=', 'i.ing_rentid')
            ->join('series as s', 's.ser_id', '=', 'i.ing_serid')
            ->join('clientes as cl', 'cl.clie_id', '=', 'r.rent_client')
            ->join('vehiculos as v', 'v.veh_id', '=', 'r.rent_vehiculo')
            ->join('cajones as ca', 'ca.caj_id', '=', 'r.rent_cajonid')
            ->join('tarifas as t', 't.tar_id', '=', 'r.rent_tarid')
            ->select(
                'c.caj_feaper',
                'i.ing_serie',
                'i.ing_numero',
                'cl.clie_nombres',
                'i.ing_tppago',
                'v.veh_placa',
                't.tar_precio',
                'r.rent_totalhoras',
                'i.ing_nref',
                'i.ing_total',
                'i.ing_estado',
                'i.ing_motivo',
                'i.ing_fechr',
                'ca.caj_desc'
            )
            ->where('c.caj_id', '=', $idcaja)
            ->orderBy('i.ing_fechr')
            ->get();


        //loop the data
        foreach ($data as $item) {
            //write data using Row() method containing array of values.


            $pdf->Row(array(
                $item->ing_serie,
                $item->clie_nombres,
                $item->ing_tppago,
                $item->ing_nref,
                $item->veh_placa,
                $item->caj_desc,
                'S/ '. $item->tar_precio,
                $item->rent_totalhoras,
               'S/ '. $item->ing_total,
                $item->ing_estado= "Emitido"  ? "":$item->ing_estado,
                $item->ing_motivo,
            ));
        }


        $pdf->Output();
        exit;
    }
}
