<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Renta;
use Livewire\WithPagination;

use App\Models\Tarifa;
use App\Models\Vehiculo;
use App\Models\Cajon;
use App\Models\Cliente;
use App\Models\Usuario;
use App\Models\TipoDocumento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;

class Rentas extends Component
{
    //paginado
    //  use WithPagination;
    //Tipo de paginacion
    protected $paginationTheme = 'bootstrap';
    //acciones
    public $Campo = 'rent_id';
    public $OrderBy = 'desc';
    //propiedades
    public $rent_tarifa = 'Elegir', $rent_client, $rent_cajonid, $rent_llaves = 'Elegir', $rent_obser;
    //propiedades para registrar un vehiculo
    public $veh_placa, $veh_modelo, $veh_marca, $veh_color, $veh_foto;
    //propiedades para registrar un cliente
    public $clie_tpdi = 'Elegir', $clie_numdoc, $clie_nombres, $clie_celular, $clie_email;
    // Id y Ver Estado
    public $selected_id = null, $selected_id_edit = null;
    public $viewmode = false, $accion = 0; //0 = Listado - 1 = Registro;
    //array publicas
    public $tarifas, $cajones, $clientes, $tipodoc;
    public $clie_findID;
    //booleanos para verificar si el vehiculo se VEHICULO GENERAL Y Si el cliente es CLIENTE GENERAL
    public $vehiculo_general = true, $cliente_general = true;

    public function render()
    {
        $this->tarifas = Tarifa::where('tar_estado', 'Activo')->get();
        $this->tipodoc = TipoDocumento::where('tpdi_estado', 'Activo')->whereNotIn('tpdi_id', [1])->get();

        $this->cajones = DB::table('cajones')
            ->select('*', DB::RAW("'' AS barcode"), DB::RAW("'' AS tarifa_id"))
            ->join('tipo_vehiculo', 'tip_id', '=', 'caj_tipoid')
            ->orderBy('caj_id', 'asc')
            ->get();

        $this->clientes = Cliente::where('clie_estado', 'Activo')->whereNotIn('clie_id', [1])->get();

        return view('livewire.rentas.listado');
    }
    protected $rules =
    [
        'rent_tarifa' => 'not_in:Elegir',

        'veh_placa' => 'required',
        'veh_modelo' => 'required',

        'clie_tpdi' => 'not_in:Elegir',
        'clie_numdoc'   => 'required|numeric|unique:clientes,clie_numdoc',
        'clie_nombres'  => 'required|string',
        'clie_celular'  => 'required|numeric',

        'rent_llaves' => 'not_in:Elegir',

    ];
    protected $messages =
    [
        'rent_tarifa.not_in' => 'Seleccione una Tarifa Valida',
        'veh_placa.required' => 'Ingrese la placa del vehiculo',
        'veh_modelo.required' => 'Ingrese el modelo del vehiculo',

        'clie_tpdi.not_in' => 'Seleccione un Tipo de Documento',
        'clie_numdoc.required' => 'Ingrese el Nro de Documento del Cliente',
        'clie_numdoc.numeric' => 'Solo se aceptan numeros',
        'clie_numdoc.unique' => 'Ya existe un cliente con ese documento',
        'clie_nombres.required' => 'Ingrese los nombres del Cliente',
        'clie_nombres.string' => 'Solo se acepta texto',
        'clie_celular.required' => 'Ingrese un celular valido',
        'clie_celular.numeric' => 'Solo se aceptan numeros',

        'rent_llaves.not_in' => 'Seleccione una Opcion Valida',
    ];
    //validaciones en vivo
    public function updated($propertyName)
    {
        //dentro de este mnetodo se pone todas la validacione en vivo
        $this->validateOnly($propertyName, [
            'rent_tarifa' => 'not_in:Elegir',

            'veh_placa' => 'required',
            'veh_modelo' => 'required',

            'clie_tpdi' => 'not_in:Elegir',
            'clie_numdoc'   => 'required|numeric|unique:clientes,clie_numdoc',
            'clie_nombres'  => 'required|string',
            'clie_celular'  => 'required|numeric',

            'rent_llaves' => 'not_in:Elegir',
        ]);
    }
    //limpiar los inputs
    public function resetInput()
    {
        $this->rent_tarifa = 'Elegir';

        $this->rent_client = null;
        $this->rent_cajonid = null;
        $this->rent_llaves = 'Elegir';
        $this->rent_obser = null;

        $this->veh_placa = null;
        $this->veh_modelo = null;
        $this->veh_marca = null;
        $this->veh_color = null;
        $this->veh_foto = null;

        $this->clie_tpdi = 'Elegir';
        $this->clie_numdoc = null;
        $this->clie_nombres = null;
        $this->clie_celular = null;
        $this->clie_email = null;

        $this->viewmode = false;

        $this->accion = 0;
    }

    //cancelar y limpiar imputs
    public function cancel()
    {
        $this->resetInput();
        $this->viewmode = false;
    }

    //Elimina los mensajes de error luego de las validaciones
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    //meotod registrar y actualizar
    public function renta_visita()
    {
        DB::beginTransaction();
        try {
            $datos =
                [
                    'rent_tarid' =>  $this->rent_tarifa,
                    'rent_vehiculo'   => 1,
                    'rent_client'  =>  1,
                    'rent_cajonid' => $this->rent_cajonid,
                    'rent_llaves' => $this->rent_llaves,
                    'rent_obser' => $this->rent_obser,
                    'rent_feching' => Carbon::now(),
                    'rent_usid' => Auth::id(),
                ];


            $this->validate([
                'rent_tarifa' => 'not_in:Elegir',
                'rent_llaves' => 'not_in:Elegir',
            ]);
            Renta::create($datos);
            //desactivamos el cajon  y lo ponemos en ocupado
            $cajon = Cajon::find($this->rent_cajonid);
            $cajon->update([
                'caj_estado' => 'Ocupado'
            ]);

            $this->emit('closeModalTicketVisita');
            $this->emit('msgOK', 'Renta Registrada Correctamente');

            $this->resetInput();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    //creamos esta funcion para que cuando hagan click cambiemos el valor de las vairables a false, esto 
    //quiere decir que registraran Clientes y Vehiculos
    public function ticketrenta()
    {
        $this->accion = 1;
        $this->cliente_general = false;
        $this->vehiculo_general = false;
    }

    protected $listeners = [
        'ticketrenta' => 'ticket_renta'
    ];

    //meotod registrar y actualizar
    public function ticket_renta($cliente, $vehiculo)
    {
        DB::beginTransaction();
        try {
            $datos =
                [
                    'rent_tarid' =>  $this->rent_tarifa,
                    'rent_vehiculo'   => 1,
                    'rent_client'  =>  1,
                    'rent_cajonid' => $this->rent_cajonid,
                    'rent_llaves' => $this->rent_llaves,
                    'rent_obser' => $this->rent_obser,
                    'rent_feching' => Carbon::now(),
                    'rent_usid' => Auth::id(),
                ];

            $datos_cliente = [
                'clie_tpdi' => $this->clie_tpdi,
                'clie_numdoc' => $this->clie_numdoc,
                'clie_nombres' => $this->clie_nombres,
                'clie_celular' => $this->clie_celular,
                'clie_email' => $this->clie_email,
            ];
            $datos_vehiculo = [
                'veh_placa' => $this->veh_placa,
                'veh_modelo' => $this->veh_modelo,
                'veh_marca' => $this->veh_marca,
                'veh_color' => $this->veh_color,
                'veh_foto' => $this->veh_foto,
            ];



            //validamos si se selecciono el CLiente general
            if ($cliente)
                $datos[0]['rent_client'] = 1;
            else {
                $this->validate([
                    'clie_tpdi' => 'not_in:Elegir',
                    'clie_numdoc'   => 'required|numeric|unique:clientes,clie_numdoc',
                    'clie_nombres'  => 'required|string',
                    'clie_celular'  => 'required|numeric',
                ]);
                $clien = Cliente::create($datos_cliente);
                $idclie = $clien->clie_id;
                $datos[0]['rent_client'] = $idclie;               
            }

            //validamos si se selecciono un VEHICULO GENERAL
            if ($vehiculo)
                $datos[0]['rent_vehiculo'] = 1; //podnemos el ID del VEHICULO GENERAL EN LA DATA
            else {
                $this->validate([
                    'veh_placa' => 'required',
                    'veh_modelo' => 'required',
                ]);
                $veh = Vehiculo::create($datos_vehiculo);
                $idveh = $veh->veh_id;
                $datos[0]['rent_vehiculo'] = $idveh; //podnemos el id del vehiculo registrado
            }

            //validamos datos para la renta
            $this->validate([
                'rent_tarifa' => 'not_in:Elegir',
                'rent_llaves' => 'not_in:Elegir',
            ]);
            Renta::create($datos);

            //desactivamos el cajon  y lo ponemos en ocupado
            $cajon = Cajon::find($this->rent_cajonid);
            $cajon->update([
                'caj_estado' => 'Ocupado'
            ]);

            $this->emit('closeModalTicketVisita');
            $this->emit('msgOK', 'Renta Registrada Correctamente');

            $this->resetInput();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
