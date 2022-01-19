<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Renta;
use App\Models\Egreso;
use App\Models\Ingreso;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function data()
    {
        //----------------------------------------------- INGRESOS SEMANALES ----------------------------------------//
        $current_year = date('Y');
        $start = date('Y-m-d',strtotime('monday this week'));//obtenemos el dia lunea de la semana actual
        $finish = date('Y-m-d',strtotime('sunday this week'));//obtenemos el dia domingo de la semana actual

        //convertimos fecha a formato UNIX
        $d1 = strtotime($start);
        $d2 = strtotime($finish);

        $week =array();
        for ($currentData = $d1; $currentData <= $d2; $currentData+=(86400)) //1 dia equivale a 86400 segundos se suma eso en e for
        { 
            $day =date('Y-m-d',$currentData);//convertir dia en formato unix a formato INGLES
            $week[] = $day;
        }
        // listamos todos los ingresos de la semana
        $sql_1="SELECT ing.fecha,IFNULL(ing.total,0) as total FROM
        (
            SELECT '$week[0]' as fecha
            UNION
            SELECT '$week[1]' as fecha
            UNION
            SELECT '$week[2]' as fecha
            UNION
            SELECT '$week[3]' as fecha
            UNION
            SELECT '$week[4]' as fecha
            UNION
            SELECT '$week[5]' as fecha
            UNION
            SELECT '$week[6]' as fecha            
        )weeks 
        LEFT JOIN
        (
            SELECT SUM(ing_total) as total,DATE(ing_fechr) as fecha 
            FROM ingresos 
            WHERE ing_fechr BETWEEN '$start . 00:00:00' and '$finish . 23:59:59' and ing_estado='Emitido'
            GROUP BY DATE(ing_fechr)
        )ing 
        ON weeks.fecha = ing.fecha
        ORDER BY weeks.fecha";

        $weekSales = DB::select(DB::raw($sql_1));
        
        //listamos todos los gresos de la semana
        $sql_2="SELECT egr.fecha,IFNULL(egr.total,0) as total FROM
        (
            SELECT '$week[0]' as fecha
            UNION
            SELECT '$week[1]' as fecha
            UNION
            SELECT '$week[2]' as fecha
            UNION
            SELECT '$week[3]' as fecha
            UNION
            SELECT '$week[4]' as fecha
            UNION
            SELECT '$week[5]' as fecha
            UNION
            SELECT '$week[6]' as fecha            
        )weeks 
        LEFT JOIN
        (
            SELECT SUM(egr_total) as total,DATE(egr_fechr) as fecha 
            FROM egresos 
            WHERE egr_fechr BETWEEN '$start . 00:00:00' and '$finish . 23:59:59' and egr_estado='Emitido'
            GROUP BY DATE(egr_fechr)
        )egr 
        ON weeks.fecha = egr.fecha
        ORDER BY weeks.fecha";

        $weekEgress = DB::select(DB::raw($sql_2));

        $chartRentasSemanal = (new LarapexChart)
        ->areaChart()
        ->setTitle('Ingresos y Egresos Semanales')
        ->setSubtitle('Diariamente')
        ->setColors(['#FFC107', '#D32F2F'])
        ->addData('Ingresos',[$weekSales[0]->total, $weekSales[1]->total,$weekSales[2]->total,$weekSales[3]->total, $weekSales[4]->total,$weekSales[5]->total,$weekSales[6]->total])
        ->addData('Egresos', [$weekEgress[0]->total, $weekEgress[1]->total,$weekEgress[2]->total,$weekEgress[3]->total, $weekEgress[4]->total,$weekEgress[5]->total,$weekEgress[6]->total])
        ->setXAxis(['Lune','Mart','Mier','Juev','Vier','Saba','Domi']);

        //             GRAFICO EN FORMA DE DONA
        // $chartRentasSemanal = (new LarapexChart())
        //                    ->setTitle('Ingresos Semana Actual')
        //                    ->setSubtitle('Diarios')
        //                    ->setLabels(['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'])
        //                    ->setType('donut')
        //                    ->setDataset(
        //                     [
        //                        intval($weekSales[0]->total),
        //                        intval($weekSales[1]->total),
        //                        intval($weekSales[2]->total),
        //                        intval($weekSales[3]->total),
        //                        intval($weekSales[4]->total),
        //                        intval($weekSales[5]->total),
        //                        intval($weekSales[6]->total)
        //                     ]);

        //-------------------------------GRAFICO INGRESOS POR MES---------------------------//
        $sql_3 = ("SELECT months.MES as MES, IFNULL(ing.total,0) as total, months.ORDEN FROM
        (
            SELECT 'January'   AS MES, 1  AS ORDEN UNION SELECT 'February' AS MES, 2  AS ORDEN UNION
            SELECT 'March'     AS MES, 3  AS ORDEN UNION SELECT 'April'    AS MES, 4  AS ORDEN UNION
            SELECT 'May'       AS MES, 5  AS ORDEN UNION SELECT 'June'     AS MES, 6  AS ORDEN UNION
            SELECT 'July'      AS MES, 7  AS ORDEN UNION SELECT 'August'   AS MES, 8  AS ORDEN UNION
            SELECT 'September' AS MES, 9  AS ORDEN UNION SELECT 'October'  AS MES, 10 AS ORDEN UNION
            SELECT 'November'  AS MES, 11 AS ORDEN UNION SELECT 'December' AS MES, 12 AS ORDEN 

        ) months
        LEFT JOIN
        (
            SELECT MONTHNAME(ing_fechr) as MES, COUNT(*) as ingresos, SUM(ing_total) as total
            FROM ingresos WHERE YEAR(ing_fechr) = $current_year
            GROUP BY MONTHNAME(ing_fechr), MONTH(ing_fechr)
            ORDER BY MONTH(ing_fechr)
        ) ing
        ON months.MES = ing.MES
        ORDER BY months.ORDEN
        ");      
        $saleMonths = DB::select(DB::raw($sql_3));
        
        $chartIngresosmensual = (new LarapexChart)
                                ->areaChart()
                                ->setTitle('Ingresos Anuales')
                                ->setSubtitle('Por Mes')
                                ->addData('Ingresos',
                                [
                                    $saleMonths[0]->total,
                                    $saleMonths[1]->total,
                                    $saleMonths[2]->total,
                                    $saleMonths[3]->total,
                                    $saleMonths[4]->total,
                                    $saleMonths[5]->total,
                                    $saleMonths[6]->total,
                                    $saleMonths[7]->total,
                                    $saleMonths[8]->total,
                                    $saleMonths[9]->total,
                                    $saleMonths[10]->total,
                                    $saleMonths[11]->total,
                                ])
                                ->setXAxis(['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'])        
                                ->setGrid(false, '#3F51B5', 0.1);

        //---------------------------------------- GRAFICO BALANCE ANUAL ----------------------------------------//
        $listIngresos = [];        
        for ($i=0; $i <12 ; $i++) 
        { 
            $listIngresos[$i] = Ingreso::where('ing_estado','=','Emitido')->whereMonth('ing_fechr', $i+1)->whereYear('ing_fechr', $current_year)->sum('ing_total');
        }

        $listEgresos = [];
        for ($i=0; $i <12 ; $i++) 
        { 
            $listEgresos[$i] = Egreso::where('egr_estado','=','Emitido')->whereMonth('egr_fechr', $i+1)->whereYear('egr_fechr', $current_year)->sum('egr_total');
        }

        $listaBalance = [];
        for ($i=0; $i < 12; $i++) 
        { 
            $listaBalance[$i] = $listIngresos[$i] - $listEgresos[$i];
        }
//['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Set','Oct','Nov','Dic']
        $chartBalanceMensual = (new LarapexChart)
                                ->setTitle('Balance Anual')
                                ->setType('bar')
                                ->setXAxis(['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'])
                                ->setGrid(true,'#3F51B5', 0.1)
                                ->setDataset(
                                [
                                    [
                                        'name' => 'Ingresos',
                                        'data' =>$listIngresos
                                    ],
                                    [
                                        'name' => 'Egresos',
                                        'data' =>$listEgresos
                                    ],
                                    [
                                        'name' => 'Balance',
                                        'data' =>$listaBalance
                                    ]
                                ]);


        return view('home',compact('chartRentasSemanal','chartIngresosmensual','chartBalanceMensual'));
    }
}
