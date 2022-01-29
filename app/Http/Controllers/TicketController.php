<?php

namespace App\Http\Controllers;

use App\Models\Cajon;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

use App\Models\User;
use App\Models\Empresa;
use App\Models\Ingreso;
use App\Models\Renta;
use App\Models\Tarifa;
use App\Models\Vehiculo;
use Carbon\Carbon;

class TicketController extends Controller
{
    //metodo para imprimir los tickets de renta;
    public function TicketRenta(Request $request)
    {
          //obtenemos la informacion
        $empresa = Empresa::find(1);
        $renta = Renta::find($request->id);
        $tarifa = Tarifa::find($renta->rent_tarid);
        $cajon = Cajon::find($renta->rent_cajonid);
        $vehiculo =Vehiculo::find($renta->rent_vehiculo);

        $codigo_barras =  str_pad($request->id, 8, "0", STR_PAD_LEFT); //00000001
        $nombreImpresora = $empresa->empr_impr; //impresora a utilizar
        $connector = new WindowsPrintConnector($nombreImpresora); //nombre de la imprsora a donde se enviara la impresion
        $impresora = new Printer($connector);


        //informacion del ticket
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setTextSize(3, 3);
        $impresora->text("TICKET INGRESO\n");
        $impresora->setTextSize(2, 2);
        $impresora->text(strtoupper($empresa->empr_razon) . "\n");
        $impresora->setTextSize(1, 1);
        $impresora->text(strtoupper($empresa->empr_direcc) . "\n");
        $impresora->text(strtoupper("Ruc:" . $empresa->empr_ruc));
        $impresora->text(strtoupper($empresa->empr_telf) . "\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("------------------------------------------------");
        $impresora->text("Fecha Ingreso:" . Carbon::parse($renta->rent_feching)->format('d/m/Y') . "   Hora Ingreso:" . Carbon::parse($renta->rent_feching)->format('h:m:s')  . "\n");
        $impresora->text("Tarifa por Hora: S/" . number_format($tarifa->tar_precio, 2) . "    Tolerancia: " . $tarifa->tar_tolerancia . " minutos" . "\n");
        $impresora->text("Cajon: " . $cajon->caj_desc . "\n");
        $impresora->text("Placa: " . $vehiculo->veh_placa . "\n");
        $impresora->text("Dejo llave: " . $renta->rent_llaves . "\n");
        if ((!empty($renta->rent_obser)))
            $impresora->text("Descripcion:" . $renta->rent_obser . "\n");

        $impresora->text("------------------------------------------------");
        //footer
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->text("Conservar el Ticket hasta el pago\n");
        $impresora->selectPrintMode();
        $impresora->setBarcodeHeight(80);
        $impresora->barcode($codigo_barras, Printer::BARCODE_CODE39); //estandar de barcode a imprimir
        $impresora->feed(1); //agregamos 2 saltos de linea
        $impresora->text("Grcias por su preferencia\n");
        $impresora->text("SYSPARK");
        $impresora->feed(3); //agregamos 3 saltos de linea
        $impresora->cut();
        $impresora->close();
    }

    public function TicketSalida(Request $request)
    {


        //obtenemos la informacion
        $empresa = Empresa::find(1);
        $ingreso = Ingreso::find($request->id);
        $renta = Renta::find($ingreso->ing_rentid);
        $cliente = Cliente::find($renta->rent_client);

        $nombreImpresora = $empresa->empr_impr; //impresora a utilizar
        $connector = new WindowsPrintConnector($nombreImpresora); //nombre de la imprsora a donde se enviara la impresion
        $impresora = new Printer($connector);

        //cargamos el logo
        if ($empresa->empr_logo == null)
            $logoruta = 'images/logo/termica/sin_logo.jpg'; // necesitamos la imagen "no logo" en formato pequeño en la carpta "TERMICA"
        else
            $logoruta = 'images/logo/termica/' . $empresa->empr_logo;

        $logo = EscposImage::load($logoruta);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->bitImage($logo);
        $impresora->feed(1); //agregamos 3 saltos de linea
        $impresora->setTextSize(3, 3);
        $impresora->text("TICKET SALIDA\n");
        $impresora->setTextSize(2, 2);
        $impresora->text(strtoupper($empresa->empr_razon) . "\n");
        $impresora->setTextSize(1, 1);
        $impresora->text(strtoupper($empresa->empr_direcc) . "\n");
        $impresora->text(strtoupper("Ruc: " . $empresa->empr_ruc));
        $impresora->text(strtoupper($empresa->empr_telf) . "\n");
        $impresora->text($ingreso->ing_serie ."-" . $ingreso->ing_numero . "\n");
        $impresora->text("------------------------------------------------");
        $impresora->text("Fecha: " . Carbon::now()->format('d/m/Y h:m:s') . "\n");
        $impresora->text("Nombres: " . $cliente->clie_nombres . "\n") ;
        $impresora->text("N° Doc: " .     $cliente->clie_numdoc . "\n");
        $impresora->text("Fecha Ingreso: " . \Carbon\Carbon::parse($renta->rent_feching)->format('H:i:s d/m/Y') . "\n");
        $impresora->text("Fecha Salida:  "  . \Carbon\Carbon::parse($renta->rent_fechsal)->format('H:i:s d/m/Y'). "\n");
        $impresora->text("Horas: " . $renta->rent_totalhoras. "\n");
        $impresora->setTextSize(2, 2);
        $impresora->text("Total: " . "S/ ". $ingreso->ing_total. "\n");
        $impresora->setTextSize(1, 1);
        $impresora->text("------------------------------------------------");
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        //codigo QR FUNCIONANDO
        //$impresora->qrCode("hola mundio 56a4sd45654a6sd546asd56|||",Printer::QR_ECLEVEL_M,5,Printer::QR_MODEL_1);
        //footer
/*
        $impresora->selectPrintMode();
        $impresora->setBarcodeHeight(80);
        $impresora->barcode("hola mundio 56a4sd45654a6sd546asd56|||", Printer::BARCODE_CODE39); //estandar de barcode a imprimir
        $impresora->feed(1); //agregamos 2 saltos de linea
*/
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->text("Grcias por su preferencia\n");
        $impresora->text("SYSPARK");
        $impresora->feed(3); //agregamos 3 saltos de linea
        $impresora->cut();
        $impresora->close();
    }
}
