<?php

namespace App\Exports;

use App\Models\Cajon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CajonesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Cajon::join('tipo_vehiculo','tip_id','=','caj_tipoid')
            ->select('caj_id','tip_desc','caj_desc','caj_estado')
            ->get();
    }
    public function headings(): array
    {
        return ['Id', 'Tp. Vehiculo', 'Cajones', 'Estado'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
