<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Reportes\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportCaja extends Controller
{
    public function Reporte_Caja($idcaja)
    {
        $caja = DB::table('cajas')
            ->where('caj_id', '=', $idcaja)
            ->get();

        $fecha_apertura = Carbon::parse($caja[0]->caj_feaper)->format('d/m/Y');

        $pdf = new PDF('L');
        $pdf->AliasNbPages();
        $pdf->Cabecera('Reporte General de Ingresos a Caja del dia ' . $fecha_apertura, $idcaja, auth()->user()->us_usuario, 'L','Caja');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        //-----------------------------------------------------INICIO DE LOS INGRESOS ---------------------------------------------------------//
        //https://www.asudahlah.com/2018/11/php-fpdf-use-text-wrapping-in-table.html
        $pdf->Cell(20, 6, 'INGRESOS', 0, 1);
        $pdf->Ln(2);
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
                $item->ing_serie .'-'. $item->ing_numero ,
                $item->clie_nombres,
                $item->ing_tppago,
                $item->ing_nref,
                $item->veh_placa,
                $item->caj_desc,
                'S/ ' . $item->tar_precio,
                $item->rent_totalhoras,
                'S/ ' . $item->ing_total,
                $item->ing_estado == "Emitido"  ? "" : $item->ing_estado,
                $item->ing_motivo,
            ));
        }
        //add a new line
        $pdf->Ln();
        //-----------------------------------------------------FIN DE LOS INGRESOS ---------------------------------------------------------//

        //-----------------------------------------------------INICIO DE LOS EGRESOS ---------------------------------------------------------//
        $egresos = DB::table('egresos')
            ->where('egr_cajid', '=', $idcaja)
            ->get();

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20, 6, 'EGRESOS', 0, 1);
        $pdf->Ln(2);
        //Definimos el ancho de las columnas
        $pdf->SetWidths(array(100, 30, 30, 100));
        //Definimos el alto de las cabecereas
        $pdf->SetLineHeight(6);
        //En que ALINEAMIENTO ESTARAN
        $pdf->SetAligns(array('L', 'C', 'C', 'L'));
        //add table heading using standard cells
        //set font to bold
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(100, 6, "Motivo del Egreso", 1, 0, 'L');
        $pdf->Cell(30, 6, "Total", 1, 0, 'C');
        $pdf->Cell(30, 6, "Estado", 1, 0, 'C');
        $pdf->Cell(100, 6, "Motivo Anulacion", 1, 0, 'L');
        //add a new line
        $pdf->Ln();
        //reset font
        $pdf->SetFont('Arial', '', 10);
        foreach ($egresos as $item) {
            $pdf->Row(array(
                $item->egr_motivo,
                'S/ ' . $item->egr_total,
                $item->egr_estado == "Emitido" ? "" : $item->egr_estado,
                $item->egr_anulm,
            ));
        }
        $pdf->Ln();

        //-----------------------------------------------------FIN DE LOS EGRESOS ---------------------------------------------------------//

        //-----------------------------------------------------INICIO DETALLES ---------------------------------------------------------//}
        $monto_inicial =DB::table('cajas')->where('caj_id','=',$idcaja)->sum('caj_minic');
        $efectivo = DB::table('ingresos as i')
                    ->join('cajas as c','c.caj_id','=','i.ing_cajid')
                    ->where('i.ing_tppago','=','Efectivo')
                    ->where('i.ing_cajid','=',$idcaja)
                    ->sum('i.ing_total');

        $visa = DB::table('ingresos as i')
        ->join('cajas as c','c.caj_id','=','i.ing_cajid')
        ->where('i.ing_tppago','=','Visa')
        ->where('i.ing_cajid','=',$idcaja)
        ->sum('i.ing_total');

        $mastercard = DB::table('ingresos as i')
        ->join('cajas as c','c.caj_id','=','i.ing_cajid')
        ->where('i.ing_tppago','=','Mastercard')
        ->where('i.ing_cajid','=',$idcaja)
        ->sum('i.ing_total');

        $anulados = DB::table('ingresos as i')
        ->join('cajas as c','c.caj_id','=','i.ing_cajid')
        ->where('i.ing_estado','=','Anulado')
        ->where('i.ing_cajid','=',$idcaja)
        ->sum('i.ing_total');

        $egresos =DB::table('egresos')
                    ->where('egr_cajid','=',$idcaja)
                    ->where('egr_estado','=','Emitido')
                    ->sum('egr_total');

        $total_efectivo=($efectivo +$monto_inicial)- $egresos;
        $total_ingresos=$total_efectivo+$visa+$mastercard;
        //Inicio de la cabeceras
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(50,10,'',0,0);
        $pdf->Cell(60,5,'Efectivo',1,0,'C');
        $pdf->Cell(60,5,'Ingresos',1,0,'C');
        $pdf->Cell(60,5,'Anulados',1,1,'C');

        //detalles
        $pdf->SetFont('Arial', '', 11);
        //generamos el espacio
        $pdf->Cell(50,10,'',0,0);
        //los 3 detalles de manera HORIZONTAL  1RA FILA
        $pdf->Cell(30,5,'Monto Inicial:',1,0);
        $pdf->Cell(30,5,number_format($monto_inicial,2),1,0,'R');
        $pdf->Cell(30,5,'Efectivo:',1,0);
        $pdf->Cell(30,5,number_format($total_efectivo,2),1,0,'R');
        $pdf->Cell(30,5,'Anulados:',1,0);
        $pdf->Cell(30,5,number_format($anulados,2),1,1,'R');

        //generamos el espacio
        $pdf->Cell(50,10,'',0,0);
        //siguientes 3 detalles de manera HORIZONTAL  2DA FILA
        $pdf->Cell(30,5,'Efectivo:',1,0);
        $pdf->Cell(30,5,number_format($efectivo,2),1,0,'R');
        $pdf->Cell(30,5,'Visa:',1,0);
        $pdf->Cell(30,5,number_format($visa,2),1,0,'R');
        $pdf->Cell(60,5,'',0,1);

        //generamos el espacio
        $pdf->Cell(50,10,'',0,0);
        //siguientes 3 detalles de manera HORIZONTAL 3RA FILA
        $pdf->Cell(30,5,'Egresos:',1,0);
        $pdf->Cell(30,5,number_format($egresos,2),1,0,'R');
        $pdf->Cell(30,5,'Mastercard:',1,0);
        $pdf->Cell(30,5,number_format($mastercard,2),1,0,'R');
        $pdf->Cell(60,5,'',0,1);

           //generamos el espacio 4TA FILA
        $pdf->Cell(50,10,'',0,0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(30,5,'Total Efectivo:',1,0);
        $pdf->Cell(30,5,number_format($total_efectivo,2),1,0,'R');
        $pdf->Cell(30,5,'Total Ingresos:',1,0);
        $pdf->Cell(30,5,number_format($total_ingresos,2),1,0,'R');
        $pdf->Cell(60,5,'',0,1);

        //----------------------------------------------------- FIN DETALLES ---------------------------------------------------------//

        $pdf->Output();
        exit;
    }
}
