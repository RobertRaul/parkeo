<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Reportes\PDF;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;

class ReportCaja extends PDF
{

    public function tabla($idcaja)
    {
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

        // Anchuras de las columnas los ANCHOS
        $w = array(15, 18, 40, 20, 20, 20, 20, 20, 20, 25, 25, 30);
        // Cabeceras
        $cabecera = array('Serie', 'Numero', 'Cliente', 'Tp. Pago', 'Nro Ref', 'Placa', 'Cajon', 'Tarifa', 'Horas', 'Total', 'Estado', 'Motivo');
        for ($i = 0; $i < count($cabecera); $i++)
            $this->Cell($w[$i], 7, $cabecera[$i], 1, 0, 'C');
        $this->Ln();
        // Datos
        $resultado = json_decode($data);
        foreach ($resultado as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR');
            $this->Cell($w[1], 6, $row[1], 'LR');
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'R');
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'R');
            $this->Ln();
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

$pdf = new ReportCaja('L');
$pdf->AliasNbPages();
$pdf->Cabecera('Reporte General de Caja', '322', 'ROBERT PS');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 11);
$pdf->tabla(9);
$pdf->Output();
exit;
