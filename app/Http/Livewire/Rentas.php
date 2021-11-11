<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Renta;

use App\Models\Tarifa;
use App\Models\Vehiculo;
use App\Models\Cajon;
use App\Models\Cliente;
use App\Models\Usuario;
use App\Models\TipoDocumento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Livewire\WithFileUploads;

class Rentas extends Component
{
    //paginado
    use WithFileUploads;
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
    public $clie_id, $clie_tpdi = 'Elegir', $clie_numdoc, $clie_nombres, $clie_celular, $clie_email;
    // Id y Ver Estado
    public $selected_id = null, $selected_id_edit = null;
    public $viewmode = false, $accion = 0; //0 = Listado - 1 = Registro;
    //array publicas
    public $tarifas, $cajones, $clientes, $tipodoc;
    public $clie_findID;
    //booleanos para verificar si el vehiculo se VEHICULO GENERAL Y Si el cliente es CLIENTE GENERAL
    public $vehiculo_general = "si", $cliente_general = "si";

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
        'veh_foto'   =>  'image|mimes:jpeg,png,jpg,gif,svg|max:4096',

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

        'veh_foto.image'      => 'Solo se aceptan imagenes'
    ];
    //validaciones en vivo
    public function updated($propertyName)
    {
        //dentro de este mnetodo se pone todas la validacione en vivo
        $this->validateOnly($propertyName, [
            'rent_tarifa' => 'not_in:Elegir',

            'veh_placa' => 'required',
            'veh_modelo' => 'required',
            'veh_foto'   =>  'image|mimes:jpeg,png,jpg,gif,svg|max:4096',

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
        $this->cliente_general = "no";
        $this->vehiculo_general = "no";
    }

    protected $listeners = [
        'ticketrenta' => 'ticket_renta',
        'cargar_data' => 'buscar_paciente'
    ];

    //meotod registrar y actualizar
    public function ticket_renta($cliente,$vehiculo)
    {
        DB::beginTransaction();
        try {
            $datos = [
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
            if ($cliente=="yes")
            {
                $datos[0]['rent_client'] = 1;               
            }
            else //en esta opcion tenemos 2 formar **1 Si el usuario busco un paciente entonces ya no registramos **2 hacemos el registro desde cero
            {                
                if ($this->clie_id > 0) 
                {  
                    $datos[0]['rent_client'] = $this->clie_id; //cargamos el ID recuperado a la renta
                } 
                else 
                {                 
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
            }  
                  
            //validamos si se selecciono un VEHICULO GENERAL
            if ($vehiculo =="yes")
                $datos[0]['rent_vehiculo'] = 1; //podnemos el ID del VEHICULO GENERAL EN LA DATA
            else {
                $this->emit('msgOK', 'Renta asdasdasd asd');
                $this->validate([
                    'veh_placa' => 'required',
                    'veh_modelo' => 'required',
                    'veh_foto'   =>  'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
                ]);
                /***************************VEHICULO******************************** */
                //Verificamos que la se haya cargado una imagen
                if (!empty($this->veh_foto))
                {
                    $image = $this->veh_foto;
                    $nameImg = 'vehiculo-' . substr(uniqid(rand(), true), 8, 8) . '.' . $image->getClientOriginalExtension();
                    $move = Image::make($image)->save('images/vehiculos/' . $nameImg);

                    if ($move) {
                        $datos_vehiculo = array_merge($datos_vehiculo, ['veh_foto' => $nameImg]);
                    }
                }
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
        } 
        catch (\Throwable $th) 
        {
            DB::rollback();
            throw $th;
        }
    }
    public function buscar_paciente($value)
    {
        if ($value != "Buscar") {
            $data = Cliente::find($value);
            $this->clie_id = $data->clie_id;
            $this->clie_tpdi = $data->clie_tpdi;
            $this->clie_numdoc = $data->clie_numdoc;
            $this->clie_nombres = $data->clie_nombres;
            $this->clie_celular = $data->clie_celular;
            $this->clie_email = $data->clie_email;
        } else {
            $this->clie_id = "";
            $this->clie_tpdi = "Elegir";
            $this->clie_numdoc = "";
            $this->clie_nombres = "";
            $this->clie_celular = "";
            $this->clie_email = "";
        }
    }
}
