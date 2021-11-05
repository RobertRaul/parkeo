<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Caja;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Cajas extends Component
{
    //paginado
    use WithPagination;
    //Tipo de paginacion
    protected $paginationTheme = 'bootstrap';
    //acciones
    public $Campo = 'caj_id';
    public $OrderBy = 'desc';
    public $pagination = 5;
    public $buscar = '';
    //propiedades
    public $caj_id, $caj_minic, $caj_feaper, $caj_fecierr, $caj_usid;
    // Id y Actualizar
    public $selected_id = null, $selected_id_edit = null;
    public $updateMode = false;

    public function render()
    {
        $data = Caja::query()
            ->search($this->buscar)
            ->where('caj_usid', '=', Auth::id())
            ->orderBy($this->Campo, $this->OrderBy)
            ->paginate($this->pagination);

        return view(
            'livewire.cajas.listado',
            [
                'data' => $data
            ]
        );
    }

    protected $rules =
    [
        'caj_minic' => 'required|numeric|min:0',
    ];
    protected $messagess =
    [
        'caj_minic.required' => 'El campo es requerido',
        'caj_minic.numeric' => 'Solo se aceptan numeros',
        'caj_minic.min'     => 'El valor minimo es 0',
    ];

    //Escuchadores
    protected $listeners =
    [
        //Nombre del listener  en el archivo blade=> metodo al que llama en este archivo
        "CerrarCaja" => "Cerrar_Caja",
    ];

    //validaciones en vivo
    public function updated($propertyName)
    {
        //dentro de este mnetodo se pone todas la validacione en vivo
        $this->validateOnly($propertyName, [
            'caj_minic' => 'required|numeric|min:0',
        ]);
    }
    public function updatingSearch()
    {
        $this->resetPage();
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
        $this->caj_minic = null;

        $this->selected_id = null;
        $this->selected_id = null;

        $this->buscar = '';

        $this->updateMode = false;
    }

    //cancelar y limpiar imputs
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }

    //meotod registrar y actualizar
    public function store_update()
    {
        $datos =
            [
                'caj_minic'   => $this->caj_minic,
                'caj_feaper' =>  $this->caj_feaper,
                'caj_usid'  =>   Auth::id(),
            ];
        //realizamos validacion para registrar
        if ($this->selected_id_edit <= 0) {
            $this->validate();
            Caja::create($datos);
            $this->emit('closeModal');
            $this->emit('msgOK', 'Caja Aperturada');
        } else //realizamos la actualizacion
        {
            $this->validate();
            Caja::find($this->selected_id_edit)->update($datos);
            $this->emit('closeModal');
            $this->emit('msgEDIT', 'Caja Modificada');
        }
        $this->resetInput();
    }

    public function edit($id)
    {
        $data = Caja::findOrFail($id);
        $this->selected_id_edit = $id;
        $this->caj_minic = $data->caj_minic;

        $this->updateMode = true;
    }

    //Pone el valor del ID a la propieda $selected_id
    public function Confirmar_Desactivar($id)
    {
        $this->selected_id = $id;
    }

    //Desactiva y activa dependiente del valor enviado
    public function Cerrar_Caja($id)
    {
        $record = Caja::find($id);
        $record->update([
            'caj_estado' => 'Cerrado'
        ]);
        $this->emit('msgINFO', 'Caja Cerrada Correctamente');
        $this->resetInput();
    }

    //Elimina los mensajes de error luego de las validaciones
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
