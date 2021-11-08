<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cajon;
use App\Models\Tipo;
use Livewire\WithPagination;

class Cajones extends Component
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
    public $caj_id, $caj_tipoid = 'Elegir', $caj_desc;
    // Id y Actualizar
    public $selected_id = null, $selected_id_edit = null;
    public $updateMode = false;
    //arrays
    public $tipos;

    public function render()
    {
        $data = Cajon::query()
            ->search($this->buscar)
            ->orderBy($this->Campo, $this->OrderBy)
            ->paginate($this->pagination);

        $tpve = Tipo::Where('tip_estado','Activo')->get();

        return view(
            'livewire.cajones.listado',
            [
                'data' => $data,
                'vehiculos' => $tpve
            ]
        );
    }

    protected $rules =
    [
        'caj_desc' => 'required|unique:cajones,caj_desc',
        'caj_tipoid' => 'not_in:Elegir'
    ];
    protected $messages =
    [
        'caj_desc.required' => 'El campo es requerido',
        'caj_desc.unique'   => 'Ya existe un registro con ese valor',

        'caj_tipoid.not_in' => 'Seleccione una opcion valida'
    ];

    //validaciones en vivo
    public function updated($propertyName)
    {
        //dentro de este mnetodo se pone todas la validacione en vivo
        $this->validateOnly($propertyName, [
            'caj_desc' => 'required|unique:cajones,caj_desc,' . $this->selected_id_edit . ',caj_id',
            'caj_tipoid' => 'not_in:Elegir',
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
        $this->caj_desc = null;
        $this->caj_tipoid = 'Elegir';

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
                'caj_desc' => $this->caj_desc,
                'caj_tipoid' => $this->caj_tipoid,
            ];
        //realizamos validacion para registrar
        if ($this->selected_id_edit <= 0) 
        {
            $this->validate();
            Cajon::create($datos);
            $this->emit('closeModal');
            $this->emit('msgOK', 'Registro Creado');
        } else {
            $this->validate([
                'caj_desc' => 'required|unique:cajones,caj_desc,' . $this->selected_id_edit . ',caj_id',
            ]);
            Cajon::find($this->selected_id_edit)->update($datos);
            $this->emit('closeModal');
            $this->emit('msgEDIT', 'Registro Modificado');
        }
        $this->resetInput();
    }
    public function edit($id)
    {
        $data = Cajon::findOrFail($id);
        $this->selected_id_edit = $id;

        $this->caj_desc = $data->caj_desc;
        $this->caj_tipoid =$data->caj_tipoid;

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
        $record = Cajon::find($id);
        $record->update([
            'caj_estado' => $value
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
