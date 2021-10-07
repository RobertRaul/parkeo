<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tipo;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Intervention\Image\ImageManagerStatic as Image;

class Tipos extends Component
{
    //paginado
    use WithPagination;
    //subir iamgenes
    use WithFileUploads;
    //Tipo de paginacion
    protected $paginationTheme = 'bootstrap';
    //acciones
    public $Campo = 'tip_id';
    public $OrderBy = 'desc';
    public $pagination = 5;
    public $buscar = '';
    //propiedades
    public $tip_desc, $tip_img, $img_antigua;
    // Id y Actualizar
    public $selected_id = null, $selected_id_edit = null;
    public $updateMode = false;

    public function render()
    {
        $data = Tipo::query()
            ->search($this->buscar)
            ->orderBy($this->Campo, $this->OrderBy)
            ->paginate($this->pagination);

        return view('livewire.tipos.listado', [
            'data' => $data
        ]);
    }

    protected $rules =
    [
        'tip_desc'  => 'required|unique:tipos,tip_desc',

        'tip_img'   =>  'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];

    protected $messages =
    [
        'tip_desc.required'  => 'El campo es requerido',
        'tip_desc.unique'    => 'Ya existe un registro con ese valor',

        'tip_img.image'      => 'Solo se aceptan imagenes'
    ];
    //validaciones en vivo
    public function updated($propertyName)
    {
        //dentro de este mnetodo se pone todas la validacione en vivo
        $this->validateOnly($propertyName, [
            'tip_desc'  => 'required|unique:tipos,tip_desc,' . $this->selected_id_edit . ',tip_id',

            'tip_img'   =>  'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
        $this->tip_desc = null;
        $this->tip_img = null;
        $this->tip_estado = null;

        $this->selected_id = null;
        $this->selected_id_edit = null;

        $this->img_antigua = null;

        $this->buscar = '';

        $this->updateMode = false;
    }
    //cancelar y limpiar imputs
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }

    //metodo registrar y actualizar
    public function store_update()
    {
        $datos =
            [
                'tip_desc'   => $this->tip_desc,
            ];

        /*  ------------------------   PARA SUBIR UNA IMAGEN EN LA CARPETA PUBLIC CREAT Images\Tipos   ---------------------------- */

        //Verificamos que la se haya cargado una imagen
        if (!empty($this->tip_img)) {
            //si la imagen de ahora es diferente a que se tenia ingresa al if
            if ($this->tip_img != $this->img_antigua) {
                $image = $this->tip_img;
                $nameImg = $this->tip_desc . '-' . substr(uniqid(rand(), true), 8, 8) . '.' . $image->getClientOriginalExtension();
                $move = Image::make($image)->save('images/tipos/' . $nameImg);
                $move_tumb = Image::make($image)->resize(150, 100)->save('images/tipos_tumb/' . $nameImg);

                if ($move && $move_tumb) {
                    $datos = array_merge($datos, ['tip_img' => $nameImg]);
                }
            }
        }

        //realizamos validacion para registrar
        if ($this->selected_id_edit <= 0)
        {
            $this->validate();
            Tipo::create($datos);
            $this->emit('closeModal');
            $this->emit('msgOK', 'Registro Creado');
        }
        else //realizamos la actualizacion
        {
            $this->validate([
                'tip_desc'  => 'required|unique:tipos,tip_desc,' . $this->selected_id_edit . ',tip_id',

                'tip_img'   =>  'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            Tipo::find($this->selected_id_edit)->update($datos);
            $this->emit('closeModal');
            $this->emit('msgEDIT', 'Registro Modificado');
        }
        $this->resetInput();
    }
    //metodo para
    public function edit($id)
    {
        $data = Tipo::findOrFail($id);

        $this->selected_id_edit = $id;
        $this->tip_desc = $data->tip_desc;
        $this->tip_img = $data->tip_img;

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
        $record = Tipo::find($id);
        $record->update([
            'tip_estado' => $value
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
