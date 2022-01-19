<?php

namespace App\Http\Livewire;

use App\Exports\SeriesExport;
use Livewire\Component;
use App\Models\Serie;
use App\Models\TipoComprobante;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class Series extends Component
{
    //paginado
    use WithPagination;
    //Tipo de paginacion
    protected $paginationTheme = 'bootstrap';
    //acciones
    public $Campo='ser_id';
    public $OrderBy='desc';
    public $pagination=5;
    public $buscar='';    

    //propiedades
    public $ser_tpcomid ='Elegir',$ser_serie,$ser_numero;     
    // Id y Actualizar
    public $selected_id=null,$selected_id_edit=null;
    public $updateMode=false;
    //arrays
    public $tipocomprobante;

    public function render()
    {
        $this->tipocomprobante=TipoComprobante::where('tpc_estado','Activo')->get();
        
        $data=Serie::query()
        ->search($this->buscar)
        ->orderBy($this->Campo,$this->OrderBy)
        ->paginate($this->pagination);

        return view('livewire.series.listado',[
            'data' =>$data
        ]);
    }

    protected $rules =
    [
        'ser_tpcomid' =>'not_in:Elegir',
        'ser_serie'   =>'required|min:4|max:4|unique:series,ser_serie',
        'ser_numero'  =>'required|numeric|min:1',
    ];

    protected $messages =
    [
        'ser_tpcomid.not_in' => 'Seleccione un comprobante',
        
        'ser_serie.required' => 'El campo Serie es requerido',
        'ser_serie.unique'   => 'Ya existe un registro con ese valor',
        'ser_serie.min'      => 'El campo solicita 4 caracteres',
        'ser_serie.max'      => 'El campo solicita 4 caracteres como maximo',

        'ser_numero.required' => 'El campo Numero  es requerido',
        'ser_numero.numeric' => 'Solo se acepta numeros',
        'ser_numero.min'     => 'El valor minimo es el numero 1',
    ];

    //validaciones en vivo
    public function updated($propertyName)
    {
        //dentro de este mnetodo se pone todas la validacione en vivo
        $this->validateOnly($propertyName,[
            'ser_tpcomid' =>'not_in:Elegir',
            
            'ser_serie' => 'required|min:4|max:4|unique:series,ser_serie,'.$this->selected_id_edit.',ser_id',                        
            
            'ser_numero' =>'required|numeric|min:1',                        
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function Header_Orderby($campo_a_ordenar)
    {
        if($this->OrderBy=='asc')        
            $this->OrderBy='desc';        
        else        
            $this->OrderBy='asc';        

        return $this->Campo=$campo_a_ordenar;
    }
    //limpiar los inputs
    public function resetInput()
    {
        $this->ser_tpcomid ='Elegir';
        $this->ser_serie=null;
        $this->ser_numero=null;

        $this->selected_id=null;
        $this->selected_id_edit=null;

        $this->buscar='';

        $this->updateMode=false;
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
        $datos=
        [
            'ser_tpcomid'   => $this->ser_tpcomid,
            'ser_serie'     => Str::upper($this->ser_serie),
            'ser_numero'    => $this->ser_numero,
        ];
        //realizamos validacion para registrar
        if($this->selected_id_edit<=0)
        {
            $this->validate();
            Serie::create($datos);   
            $this->emit('closeModal');
            $this->emit('msgOK','Registro Creado');
        }
        else //realizamos la actualizacion
        {
            $this->validate([
                'ser_tpcomid' =>'not_in:Elegir',
                'ser_serie' => 'required|min:4|max:4|unique:series,ser_serie,'.$this->selected_id_edit.',ser_id',     
                'ser_numero' =>'required|numeric|min:1',              
            ]);
            Serie::find($this->selected_id_edit)->update($datos);
            $this->emit('closeModal');
            $this->emit('msgEDIT','Registro Modificado');
        }
        $this->resetInput();
    }

    //metodo para
    public function edit($id)
    {
        $data=Serie::findOrFail($id);

        $this->selected_id_edit=$id;
        $this->ser_tpcomid=$data->ser_tpcomid;
        $this->ser_serie=$data->ser_serie;
        $this->ser_numero=$data->ser_numero;

        $this->updateMode=true;
    }

    //Pone el valor del ID a la propieda $selected_id
    public function Confirmar_Desactivar($id)
    {       
        $this->selected_id =$id;        
    }    

    //Desactiva y activa dependiente del valor enviado
    public function Desactivar_Activar($id,$value)
    {
        $record=Serie::find($id);
        $record->update([
            'ser_estado'=>$value
        ]);
        $this->emit('msgINFO','Registro '.$value );
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
          return Excel::download(new SeriesExport,'series.xlsx');
      }
  
      public function report_pdf()
      {
          $this->emit('pdf_series');
      }
}
