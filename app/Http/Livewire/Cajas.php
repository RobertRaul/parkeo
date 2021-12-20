<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Caja;
use App\Models\Ingreso;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public $caj_id, $caj_minic, $caj_codigo;
    // Id y Actualizar
    public $selected_id = null, $selected_id_edit = null;
    public $updateMode = false;
    public $now="si";

    //detalles de la caja
    public $detalles_caja, $caja_codigo;
    public function render()
    {
       // $caj =DB::select(DB::raw("SELECT caj_id FROM cajas WHERE caj_st='Open' and caj_usid=:user and DATE(caj_feaper)=CURRENT_DATE()"),['user' => Auth::id()]);
        $caj = Caja::
            where('caj_st', 'Open')
            ->where('caj_usid', Auth::id())
            // ->whereDate('caj_feaper', DB::raw('CURDATE()'))
            ->get();

        $cantidad = count($caj);
        if ($cantidad > 0)
            $this->caj_codigo = $caj[0]->caj_id;
        else
            $this->caj_codigo = -1;

        $cajas = Caja::query()
            ->search($this->buscar)
            ->where('caj_usid', '=', Auth::id())
            ->orderBy($this->Campo, $this->OrderBy)
            ->paginate($this->pagination);



        $detalles = DB::table('ingresos')
        ->join('rentas','ingresos.ing_id','=','rentas.rent_id')
        ->join('tarifas','tarifas.tar_id','=','rentas.rent_tarid')
        ->join('vehiculos','vehiculos.veh_id','=','rentas.rent_vehiculo')
        ->join('clientes','clientes.clie_id','=','rentas.rent_client')
        ->join('cajones','cajones.caj_id','=','rentas.rent_cajonid')
        ->select('ing_id','clientes.clie_nombres','vehiculos.veh_placa','tarifas.tar_precio','rentas.rent_totalhoras','cajones.caj_desc','ingresos.ing_serie',
        'ingresos.ing_numero','ingresos.ing_fechr','ingresos.ing_tppago','ingresos.ing_nref','ingresos.ing_total','ingresos.ing_estado')
        ->where('ingresos.ing_cajid','=',$this->caja_codigo)
        ->orderBy('ingresos.ing_fechr')
        ->get();

        return view(
            'livewire.cajas.listado',
            [
                'cajas' => $cajas,
                'detalles' => $detalles
            ]
        );
    }

    protected $rules =
    [
        'caj_minic' => 'required|numeric|min:0',
    ];
    protected $messages =
    [
        'caj_minic.required' => 'Ingrese un monto inicial',
        'caj_minic.numeric' => 'Solo se aceptan numeros',
        'caj_minic.min'     => 'El valor minimo es 0',
    ];

    //Escuchadores
    protected $listeners =
    [
        //Nombre del listener  en el archivo blade=> metodo al que llama en este archivo
        "CerrarCaja" => "Cerrar_Caja",
        "AnularTicket" => "Anular_Ticket",

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
                'caj_feaper' =>  Carbon::now(),
                'caj_usid'  =>   Auth::id(),
            ];
            /*
        //realizamos validacion para registrar
        if ($this->selected_id_edit <= 0) {
            $this->validate();
            Caja::create($datos);
            $this->emit('closeModal');
            $this->emit('msgOK', 'Caja Aperturada');
        } else //realizamos la actualizacion -> SIN  EJECUCION TEMPORALMENTE
        {
            $this->validate();
            Caja::find($this->selected_id_edit)->update($datos);
            $this->emit('closeModal');
            $this->emit('msgEDIT', 'Caja Modificada');
        }
        */


        //realizamos validacion para registrar
        $this->validate();
        Caja::create($datos);
        $this->emit('closeModal');
        $this->emit('msgOK', 'Caja Aperturada');
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
    public function Cerrar_Caja()
    {
        $record = Caja::find($this->caj_codigo);
        $record->update([
            'caj_st' => 'Close',
            'caj_fecierr' => Carbon::now()
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

    public function Anular_Ticket($id_ingreso,$motivo)
    {
        $ingreso = Ingreso::find($id_ingreso);
        $ingreso->update([
            'ing_estado' => 'Anulado',
            'ing_motivo' => $motivo,
        ]);
        $this->emit('msgINFO', 'Comprobante Anulado');
       // $this->resetInput();
    }

    public function generar_reporte()
    {
        $this->emit('caja_pdf');
    }


}
