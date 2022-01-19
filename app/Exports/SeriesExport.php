<?php

namespace App\Exports;

use App\Models\Serie;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SeriesExport implements FromCollection,WithHeadings,ShouldAutoSize,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Serie::join('tipo_comprobante','tpc_id','=','ser_tpcomid')
        ->select('ser_id','tpc_desc','ser_serie','ser_numero','ser_estado')
        ->get();
    }
    public function headings(): array
    {
        return ['Id','Comprobante','Serie','Numeracion Actual','Estado'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
