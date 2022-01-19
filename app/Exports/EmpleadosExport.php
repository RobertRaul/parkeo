<?php

namespace App\Exports;

use App\Models\Empleado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmpleadosExport implements FromCollection,WithHeadings,ShouldAutoSize,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Empleado::join('tipo_doc_identidad','tpdi_id','=','emp_tpdi')
                        ->select('emp_id','tpdi_desc','emp_numdoc','emp_apellidos','emp_nombres','emp_celular','emp_email','emp_direccion','emp_estado')
                        ->get();
    }
    public function headings(): array
    {
        return ['Id','Tp. Documento','Nro Documento','Apellidos','Nombres','Celular','Email','Direccion','Estado'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
