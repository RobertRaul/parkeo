<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Empleado;
use App\Models\TipoDocumento;
use Livewire\WithPagination;

class Empleados extends Component
{
    //paginado
    use WithPagination;
    //Tipo de paginacion
    protected $paginationTheme = 'bootstrap';
    //acciones
    public $Campo='emp_id';
    public $OrderBy='desc';
    public $pagination=5;
    public $buscar='';
    //propiedades
    public $emp_tpdi ='Elegir',$emp_numdoc,$emp_apellidos,$emp_nombres,$emp_celular,$emp_email,$emp_direccion,$emp_estado;
    // Id y Actualizar
    public $selected_id=null,$selected_id_edit=null;
    public $updateMode=false;
    //arrays
    public $tipodocumento;

    public function render()
    {
        $this->tipocomprobante=TipoDocumento::where('tpdi_estado','Activo')->get();

        $data = Empleado::query()
        ->search($this->buscar)
        ->orderBy($this->Campo,$this->OrderBy)
        ->paginate($this->pagination);

        return view('livewire.empleados.listado',[
            'data'=>$data
        ]);
    }
    protected $rules =
    [
        'emp_tpdi' =>'not_in:Elegir',
        'emp_numdoc'   =>'required|unique:empleados,emp_numdoc',
        'emp_apellidos'  =>'required|alpha',
        'emp_nombres'  =>'required|alpha',
        'emp_celular'  =>'required|numeric',
        'emp_email' => 'required|email',
        'emp_direccion' => 'required',
    ];
}
