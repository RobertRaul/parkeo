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
    public $emp_tpdi ='Elegir',$emp_numdoc,$emp_apellidos,$emp_nombres,$emp_celular,$emp_email,$emp_direccion;
    // Id y Actualizar
    public $selected_id=null,$selected_id_edit=null;
    public $updateMode=false;
    //arrays
    public $tipodocumento;

    public function render()
    {
        $this->tipodocumento=TipoDocumento::where('tpdi_estado','Activo')->get();

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
        'emp_numdoc'   =>'required|numeric|unique:empleados,emp_numdoc',
        'emp_apellidos'  =>'required|string',
        'emp_nombres'  =>'required|string',
        'emp_celular'  =>'required|numeric',
        'emp_email' => 'required|email',
        'emp_direccion' => 'required',
    ];
    protected $messages =
    [
        'emp_tpdi.not_in' => 'Seleccione un tipo de documento',

        'emp_numdoc.required'=>'El campo es requerido',
        'emp_numdoc.unique'=>'Ya existe un registro con ese valor',
        'emp_numdoc.numeric'=>'Solo se acepta numeros',

        'emp_apellidos.required'=>'El campo es requerido',
        'emp_apellidos.string'=>'Solo se acepta texto',

        'emp_nombres.required'=>'El campo es requerido',
        'emp_nombres.string'=>'Solo se acepta texto',

        'emp_celular.required'=>'El campo es requerido',
        'emp_celular.numeric'=>'Solo se aceptan numeros',

        'emp_email.required'=>'El campo es requerido',
        'emp_email.email'=>'Ingrese un correo valido',

        'emp_direccion.required'=>'El campo es requerido',
    ];
    //validaciones en vivo
    public function updated($propertyName)
    {
        //dentro de este mnetodo se pone todas la validacione en vivo
        $this->validateOnly($propertyName, [
            'emp_tpdi' =>'not_in:Elegir',
            'emp_numdoc'   =>'required|numeric|unique:empleados,emp_numdoc,'. $this->selected_id_edit.',emp_id' ,
            'emp_apellidos'  =>'required|string',
            'emp_nombres'  =>'required|string',
            'emp_celular'  =>'required|numeric',
            'emp_email' => 'required|email',
            'emp_direccion' => 'required',
        ]);
    }
    public function updatingSearch(): void
    {
        $this->resetPage(1);
    }
    public function Header_Orderby($campo_a_ordenar)
    {
        if ($this->OrderBy == 'asc')
            $this->OrderBy = 'desc';
        else
            $this->OrderBy = 'asc';

        return $this->Campo = $campo_a_ordenar;
    }
    //limpiar los inputs
    public function resetInput()
    {
        $this->emp_tpdi = 'Elegir';
        $this->emp_numdoc = null;
        $this->emp_apellidos = null;
        $this->emp_nombres = null;
        $this->emp_celular = null;
        $this->emp_email = null;
        $this->emp_direccion = null;

        $this->selected_id = null;
        $this->selected_id_edit = null;

        $this->buscar = '';

        $this->updateMode = false;
    }
    //cancelar y limpiar imputs
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
    public function store_update()
    {
        $datos =
            [
                'emp_tpdi' => $this->emp_tpdi,
                'emp_numdoc' => $this->emp_numdoc,
                'emp_apellidos' => $this->emp_apellidos,
                'emp_nombres' => $this->emp_nombres,
                'emp_celular' => $this->emp_celular,
                'emp_email' => $this->emp_email,
                'emp_direccion' => $this->emp_direccion,
            ];
        //realizamos validacion para registrar
        if ($this->selected_id_edit <= 0) {
            $this->validate();
            Empleado::create($datos);
            $this->emit('closeModal');
            $this->emit('msgOK', 'Registro Creado');
        } else {
            $this->validate([
                'emp_tpdi' =>'not_in:Elegir',
                'emp_numdoc'   =>'required|numeric|unique:empleados,emp_numdoc,'. $this->selected_id_edit.',emp_id' ,
                'emp_apellidos'  =>'required|string',
                'emp_nombres'  =>'required|string',
                'emp_celular'  =>'required|numeric',
                'emp_email' => 'required|email',
                'emp_direccion' => 'required',
            ]);
            Empleado::find($this->selected_id_edit)->update($datos);
            $this->emit('closeModal');
            $this->emit('msgEDIT', 'Registro Modificado');
        }
        $this->resetInput();
    }
    public function edit($id)
    {
        $data = Empleado::findOrFail($id);

        $this->selected_id_edit = $id;
        $this->emp_tpdi = $data->emp_tpdi;
        $this->emp_numdoc = $data->emp_numdoc;
        $this->emp_apellidos = $data->emp_apellidos;
        $this->emp_nombres = $data->emp_nombres;
        $this->emp_celular = $data->emp_celular;
        $this->emp_email = $data->emp_email;
        $this->emp_direccion = $data->emp_direccion;
        $this->tar_tipoid = $data->tar_tipoid;
 
        $this->updateMode = true;
    }

    //Pone el valor del ID a la propieda $selected_id
    public function Confirmar_Desactivar($id)
    {
        $this->selected_id = $id;
    }
    //Desactiva y activa dependiente del valor enviado
    public function Desactivar_Activar($id, $value)
    {
        $record = Empleado::find($id);
        $record->update([
            'emp_estado' => $value
        ]);
        $this->emit('msgINFO', 'Registro ' . $value);
        $this->resetInput();
    }
    //Elimina los mensajes de error luego de las validaciones
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
