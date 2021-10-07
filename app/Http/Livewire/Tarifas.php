<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tarifa;
use App\Models\Tipo;
use Livewire\WithPagination;
use Illuminate\Support\Str;

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
    public $tar_desc, $tar_tiempo = 'Elegir', $tar_tipoid;
    // Id y Actualizar
    public $selected_id = null, $selected_id_edit = null;
    public $updateMode = false;
    //arrays
    public $tipos;

    public function render()
    {
        $data = Tarifas::query()
            ->search($this->buscar)
            ->orderBy($this->Campo, $this->OrderBy)
            ->paginate($this->pagination);

        $this->tipos = Tipo::where('tp_estado', 'Activo')->get();

        return view('livewire.tarifas.listado', [
            'data' => $data
        ]);
    }

    protected $rules =
    [
        'tar_desc'  => 'required',

        'tip_img'   =>  'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];
}
