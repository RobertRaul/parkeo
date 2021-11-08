<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tarifa;
use App\Models\Tipo;
use Livewire\WithPagination;

class Tarifas extends Component
{
    //paginado
    use WithPagination;
    //Tipo de paginacion
    protected $paginationTheme = 'bootstrap';
    //acciones
    public $Campo = 'tar_id';
    public $OrderBy = 'desc';
    public $pagination = 5;
    public $buscar = '';
    //propiedades
    public $tar_desc, $tar_tiempo = 'Elegir', $tar_precio;
    // Id y Actualizar
    public $selected_id = null, $selected_id_edit = null;
    public $updateMode = false;
    //arrays
    public $tipos;

    public function render()
    {
        $data = Tarifa::query()
            ->search($this->buscar)
            ->orderBy($this->Campo, $this->OrderBy)
            ->paginate($this->pagination);
     
        return view('livewire.tarifas.listado', [
            'data' => $data
        ]);
    }

    protected $rules =
    [
        'tar_desc'  => 'required|unique:tarifas,tar_desc',
        'tar_tiempo' => 'not_in:Elegir',
        'tar_precio' => 'required|numeric|between:0,999999.99',
    ];

    protected $messages =
    [
        'tar_desc.required' => 'El campo es requerido',
        'tip_desc.unique'   => 'Ya existe un registro con ese valor',

        'tar_tiempo.not_in' => 'Seleccione un Tiempo',

        'tar_precio.required' => 'El campo es requerido',
        'tar_precio.numeric' => 'Solo se acepta numeros',
    ];

    //validaciones en vivo
    public function updated($propertyName)
    {
        //dentro de este mnetodo se pone todas la validacione en vivo
        $this->validateOnly($propertyName, [
            'tar_desc'  => 'required|unique:tarifas,tar_desc,' . $this->selected_id_edit . ',tar_id',
            'tar_tiempo' => 'not_in:Elegir',
            'tar_precio' => 'required|numeric|between:0,999999.99',
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
        $this->tar_desc = null;
        $this->tar_tiempo = 'Elegir';
        $this->tar_precio = null;

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
                'tar_desc' => $this->tar_desc,
                'tar_tiempo' => $this->tar_tiempo,
                'tar_precio' => $this->tar_precio,
            ];
        //realizamos validacion para registrar
        if ($this->selected_id_edit <= 0) {
            $this->validate();
            Tarifa::create($datos);
            $this->emit('closeModal');
            $this->emit('msgOK', 'Registro Creado');
        } else {
            $this->validate([
                'tar_desc'  => 'required|unique:tarifas,tar_desc,' . $this->selected_id_edit . ',tar_id',
                'tar_tiempo' => 'not_in:Elegir',
                'tar_precio' => 'required|numeric|between:0,999999.99',
            ]);
            Tarifa::find($this->selected_id_edit)->update($datos);
            $this->emit('closeModal');
            $this->emit('msgEDIT', 'Registro Modificado');
        }
        $this->resetInput();
    }

    public function edit($id)
    {
        $data = Tarifa::findOrFail($id);
        $this->selected_id_edit = $id;
        $this->tar_desc = $data->tar_desc;
        $this->tar_tiempo = $data->tar_tiempo;
        $this->tar_precio = $data->tar_precio;

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
        $record = Tarifa::find($id);
        $record->update([
            'tar_estado' => $value
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
