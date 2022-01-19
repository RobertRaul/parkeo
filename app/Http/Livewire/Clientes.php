<?php

namespace App\Http\Livewire;

use App\Exports\ClientesExport;
use Livewire\Component;
use App\Models\Cliente;
use App\Models\TipoDocumento;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Clientes extends Component
{
    //paginado
    use WithPagination;
    //Tipo de paginacion
    protected $paginationTheme = 'bootstrap';
    //acciones
    public $Campo = 'clie_id';
    public $OrderBy = 'desc';
    public $pagination = 5;
    public $buscar = '';
    //propiedades
    public $clie_tpdi = 'Elegir', $clie_numdoc ,$clie_nombres, $clie_celular, $clie_email;
    // Id y Actualizar
    public $selected_id = null, $selected_id_edit = null;
    public $updateMode = false;
    //arrays
    public $tipodoc;

    public function render()
    {
        $this->tipodoc=TipoDocumento::where('tpdi_estado','Activo')->whereNotIn('tpdi_id',[1])->get();
        $data = Cliente::query()

        ->search($this->buscar)
        ->whereNotIn('clie_id',[1])
        ->orderBy($this->Campo,$this->OrderBy)
        ->paginate($this->pagination);

        return view('livewire.clientes.listado',[
           'data'  => $data
        ]);
    }
    protected $rules =
    [
        'clie_tpdi' =>'not_in:Elegir',
        'clie_numdoc'   =>'required|numeric|unique:clientes,clie_numdoc',
        'clie_nombres'  =>'required|string',
        'clie_celular'  =>'required|numeric',
        'clie_email' => 'required|email',
    ];
    protected $messages =
    [
        'clie_tpdi.not_in' => 'Seleccione un tipo de documento',

        'clie_numdoc.required'=>'El campo es requerido',
        'clie_numdoc.unique'=>'Ya existe un registro con ese valor',
        'clie_numdoc.numeric'=>'Solo se acepta numeros',

        'clie_nombres.required'=>'El campo es requerido',
        'clie_nombres.string'=>'Solo se acepta texto',

        'emp_nombres.required'=>'El campo es requerido',
        'emp_nombres.string'=>'Solo se acepta texto',

        'clie_celular.required'=>'El campo es requerido',
        'clie_celular.numeric'=>'Solo se aceptan numeros',

        'clie_email.required'=>'El campo es requerido',
        'clie_email.email'=>'Ingrese un correo valido',
    ];
    //validaciones en vivo
     public function updated($propertyName)
     {
         //dentro de este mnetodo se pone todas la validacione en vivo
         $this->validateOnly($propertyName, [
            'clie_tpdi' =>'not_in:Elegir',
            'clie_numdoc'   =>'required|numeric|unique:clientes,clie_numdoc,'.$this->selected_id_edit.',clie_id',
            'clie_nombres'  =>'required|string',
            'clie_celular'  =>'required|numeric',
            'clie_email' => 'required|email',
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
        $this->clie_tpdi = 'Elegir';
        $this->clie_numdoc = null;
        $this->clie_nombres = null;
        $this->clie_celular = null;
        $this->clie_email = null;

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
                'clie_tpdi' => $this->clie_tpdi,
                'clie_numdoc' => $this->clie_numdoc,
                'clie_nombres' => $this->clie_nombres,
                'clie_celular' => $this->clie_celular,
                'clie_email' => $this->clie_email
            ];
        //realizamos validacion para registrar
        if ($this->selected_id_edit <= 0) {
            $this->validate();
            Cliente::create($datos);
            $this->emit('closeModal');
            $this->emit('msgOK', 'Registro Creado');
        } else {
            $this->validate([
                'clie_tpdi' =>'not_in:Elegir',
                'clie_numdoc'   =>'required|numeric|unique:clientes,clie_numdoc,'.$this->selected_id_edit.',clie_id',
                'clie_nombres'  =>'required|string',
                'clie_celular'  =>'required|numeric',
                'clie_email' => 'required|email',
            ]);
            Cliente::find($this->selected_id_edit)->update($datos);
            $this->emit('closeModal');
            $this->emit('msgEDIT', 'Registro Modificado');
        }
        $this->resetInput();
    }
    public function edit($id)
    {
        $data = Cliente::findOrFail($id);

        $this->selected_id_edit = $id;
        $this->clie_tpdi = $data->clie_tpdi;
        $this->clie_numdoc = $data->clie_numdoc;
        $this->clie_nombres = $data->clie_nombres;
        $this->clie_celular = $data->clie_celular;
        $this->clie_email = $data->clie_email;

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
          $record = Cliente::find($id);
          $record->update([
              'clie_estado' => $value
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

      
    //Reportes
    public function report_xls()
    {
        return Excel::download(new ClientesExport,'clientes.xlsx');
    }

    public function report_pdf()
    {
        $this->emit('pdf_clientes');
    }
}
