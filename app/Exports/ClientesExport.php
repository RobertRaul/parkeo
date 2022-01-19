<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientesExport implements FromCollection,WithHeadings,ShouldAutoSize,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cliente::join('tipo_doc_identidad','tpdi_id','=','clie_tpdi')
        ->whereNotIn('clie_id',[1])
        ->select('clie_id','tpdi_desc','clie_numdoc','clie_nombres','clie_celular','clie_email','clie_estado')
        ->get();
    }
    public function headings(): array
    {
        return ['Id','Tp. Documento','Nro Documento','Nombres','Celular','Email','Estado'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
