<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TipoDocumento;
use Livewire\WithPagination;

class TipoDocumentos extends Component
{
     //paginado
     use WithPagination;
     //Tipo de paginacion
     protected $paginationTheme = 'bootstrap';
     //acciones
     public $Campo='tpdi_id';
     public $OrderBy='asc';
     public $pagination=5;
     public $buscar='';

     //propiedades
     public $selected_id;

    public function render()
    {
        $data=TipoDocumento::query()
        ->search($this->buscar)
        ->whereNotIn('tpdi_id',[1])
        ->orderBy($this->Campo,$this-> OrderBy)
        ->paginate($this->pagination);
        return view('livewire.tipodocumento.listado',
        [
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
         $record=TipoDocumento::find($id);
         $record->update([
             'tpdi_estado'=>$value
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
