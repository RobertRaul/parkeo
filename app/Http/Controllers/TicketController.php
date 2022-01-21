<?php

namespace App\Http\Controllers;

use App\Models\Cajon;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

use App\Models\User;
use App\Models\Empresa;
use App\Models\Renta;
use App\Models\Tarifa;
use Carbon\Carbon;

class TicketController extends Controller
{
    //metodo para imprimir los tickets de renta;
    public function TicketRenta(Request $request)
    {
        $codigo_barras =  str_pad($request->id,8,"0",STR_PAD_LEFT); //00000001
        $nombreImpresora = "TP-300"; //imporesora a utilizar
        $connector = new WindowsPrintConnector($nombreImpresora);//nombre de la imprsora a donde se enviara la impresion

        $impresora = new Printer($connector);

        //obtenemos la informacion
        $empresa = Empresa::find(1);
        $renta = Renta::find($request->id);
        $tarifa = Tarifa::find($renta->rent_tarid);
        $cajon = Cajon::find($renta->rent_cajonid);

        //informacion del ticket
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setTextSize(2,2);
        $impresora->text(strtoupper($empresa->empr_razon)."\n");
        $impresora->setTextSize(1,1);
        $impresora->text(strtoupper($empresa->empr_direcc)."\n");
        $impresora->text(strtoupper("Ruc:" .$empresa->empr_ruc)."\n");
        $impresora->text(strtoupper($empresa->empr_telf)."\n");
        $impresora->text("Ticket de Renta\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("------------------------------------------------");
        $impresora->text("Fecha Entrada:" .Carbon::parse($renta->rent_feching)->format('d/m/Y') . "   Hora Entrada:" .Carbon::parse($renta->rent_feching)->format('h:m:s')  . "\n");
        $impresora->text("Tarifa por Hora: S/" . number_format($tarifa->tar_precio,2) . "    Tolerancia: " .$tarifa->tar_tolerancia . " minutos". "\n");
        $impresora->text("Cajon: " . $cajon->caj_desc ."\n");
        $impresora->text("Dejo llave: " .$renta->rent_llaves . "\n");
        if((!empty($renta->rent_obser)))
            $impresora->text("Desc:" . $renta->rent_obser . "\n");


        $impresora->text("------------------------------------------------");

        //footer
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->text("Conservar el Ticket hasta el pago\n");
        $impresora->selectPrintMode();
        $impresora->setBarcodeHeight(80);
        $impresora->barcode($codigo_barras,Printer::BARCODE_CODE39);//estandar de barcode a imprimir
        $impresora->feed(1);//agregamos 2 saltos de linea
        $impresora->text("Grcias por su preferencia\n");
        $impresora->text("SYSPARK");
        $impresora->feed(3);//agregamos 3 saltos de linea
        $impresora->cut();
        $impresora->close();
    }

    public function TicketSalida(Request $request)
    {

    }
}
