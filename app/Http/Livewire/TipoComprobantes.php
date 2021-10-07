<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TipoComprobante;
use Livewire\WithPagination;

class TipoComprobantes extends Component
{
    //paginado
    use WithPagination;
    //Tipo de paginacion
    protected $paginationTheme = 'bootstrap';
    //acciones
    public $Campo='tpc_desc';
    public $OrderBy='asc';
    public $pagination=5;
    public $buscar='';    

    //propiedades
    public $selected_id;

    //al inicio del componente
    public function render()
    {
        $data=TipoComprobante::query()
        ->search($this->buscar)
        ->orderby($this->Campo,$this->OrderBy)
        ->paginate($this->pagination);

        return view('livewire.tipocomprobante.listado',[
            'data'=>$data
        ]);
    }

    // Ordenar header de la tabla
    public function Header_Orderby($campo_a_ordenar)
    {
        if($this->OrderBy=='asc')        
            $this->OrderBy='desc';        
        else        
            $this->OrderBy='asc';        

        return $this->Campo=$campo_a_ordenar;
    }

    //Pone el valor del ID a la propieda $selected_id
    public function Confirmar_Desactivar($id)
    {       
            $this->selected_id =$id;        
    }

    //Desactiva y activa dependiente del valor enviado
    public function Desactivar_Activar($id,$value)
    {
        $record=TipoComprobante::find($id);
        $record->update([
            'tpc_estado'=>$value
        ]);
        $this->emit('msgINFO','Registro '.$value );
        $this->resetInput();
      
    }
     //metoodo para limpiar las variables
     private function resetInput()
     {
         $this->selected_id=null;    
         $this->buscar='';                    
     }
}
