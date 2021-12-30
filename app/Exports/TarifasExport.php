<?php

namespace App\Exports;

use App\Models\Tarifa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TarifasExport implements FromCollection,WithHeadings,ShouldAutoSize,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tarifa::select('tar_id','tar_valor','tar_tiempo','tar_tolerancia','tar_precio','tar_estado')->get();
    }
    public function headings(): array
    {
        return ['Id','Valor','Tiempo','Tolerancia','Precio','Estado'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
