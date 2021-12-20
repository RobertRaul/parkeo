<?php

namespace App\Http\Livewire;

use App\Models\Egreso;
use App\Models\Caja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Egresos extends Component
{
    //paginado
    use WithPagination;
    //Tipo de paginacion
    protected $paginationTheme = 'bootstrap';
    //acciones
    //acciones
    public $Campo = 'egr_id';
    public $OrderBy = 'desc';
    public $pagination = 5;
    public $buscar = '';

    //propiedades
    public $egr_motivo, $egr_total ;
    //Caja
    public $caja_aperturada;

    public function render()
    {
        $caj = Caja::where('caj_st', 'Open')
            ->where('caj_usid', Auth::id())
            ->whereDate('caj_feaper', DB::raw('CURDATE()'))
            ->get();

        $cantidad = count($caj);

        if ($cantidad > 0)
            $this->caja_aperturada = $caj[0]->caj_id;
        else
            $this->caja_aperturada = -1;

        $data = Egreso::query()
            ->search($this->buscar)
            ->where('egr_cajid', '=', $this->caja_aperturada)
            ->orderBy($this->Campo, $this->OrderBy)
            ->paginate($this->pagination);


        return view('livewire.egresos.validar', [
            'data' => $data
        ]);
    }

    protected $listeners =
    [
        'egreso_mensaje' => 'egreso_mensaje',
        'Anularegreso' => 'Anular_egreso'
    ];

    protected $rules =
    [
        'egr_motivo'  => 'required',
        'egr_total' => 'required|numeric',
    ];

    protected $messages =
    [
        'egr_motivo.required' => 'Ingres el motivo del egreso',

        'egr_total.required' => 'Ingrese el total de egreso',
        'egr_total.numeric' => 'Solo se acepta numeros',
    ];

    //validaciones en vivo
    public function updated($propertyName)
    {
        //dentro de este mnetodo se pone todas la validacione en vivo
        $this->validateOnly($propertyName, [
            'egr_motivo'  => 'required',
            'egr_total' => 'required|numeric',
        ]);
    }

    public function egreso_mensaje()
    {
        $this->emit('msgERROR', 'Debe Realiza una apertura de caja para el dia de hoy');
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
        $this->egr_motivo = null;
        $this->egr_total = null;
    }

    //cancelar y limpiar imputs
    public function cancel()
    {
        $this->resetInput();
    }

    public function registrar()
    {
        $datos =
            [
                'egr_motivo' => $this->egr_motivo,
                'egr_total' => $this->egr_total,
                'egr_cajid' => $this->caja_aperturada,
            ];
        //realizamos validacion para registrar
        $this->validate();
        Egreso::create($datos);
        $this->emit('closeModal');
        $this->emit('msgOK', 'Egreso registrado');

        $this->resetInput();
    }

    //Elimina los mensajes de error luego de las validaciones
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
    public function Anular_egreso($idegreso, $motivo)
    {
        $egreso = Egreso::find($idegreso);
        $egreso->update([
            'egr_estado' => 'Anulado',
            'egr_anulm' => $motivo
        ]);
        $this->emit('msgINFO', 'Egreso Anulado');
        $this->resetInput();
    }
}
