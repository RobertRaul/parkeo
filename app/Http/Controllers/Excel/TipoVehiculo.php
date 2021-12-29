<?php

namespace App\Http\Controllers\Excel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TipoVehiculoExport;


class TipoVehiculo extends Controller
{
    public function Reporte_Excel()
    {
        return Excel::download(new TipoVehiculoExport,'Vehiculos.xlsx');
    }
}
