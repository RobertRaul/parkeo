<?php

namespace App\Http\Livewire;

use App\Models\Empresa;
use Livewire\Component;
use Livewire\WithFileUploads;

use Intervention\Image\ImageManagerStatic as Image;

class Empresas extends Component
{
    //subir iamgenes
    use WithFileUploads;

    public $empr_id, $empr_ruc, $empr_razon, $empr_email, $empr_logo, $empr_logo_ant, $empr_direcc, $empr_telef;

    public function mount()
    {
        $empresa = Empresa::select('*')->first();

        $this->empr_id = $empresa->empr_id;
        $this->empr_ruc = $empresa->empr_ruc;
        $this->empr_razon = $empresa->empr_razon;
        $this->empr_email = $empresa->empr_email;
        $this->empr_logo = $empresa->empr_logo;
        $this->empr_logo_ant = $empresa->empr_logo;
        $this->empr_direcc = $empresa->empr_direcc;
        $this->empr_telef = $empresa->empr_telef;
    }

    public function render()
    {
        return view('livewire.empresa.configuracion');
    }

    protected $rules =
    [
        'empr_ruc' => 'required',
        'empr_razon' => 'required',
        'empr_email' => 'required',
        'empr_logo' => 'required',
        'empr_direcc' => 'required',
        'empr_telef' => 'required',
    ];

    protected $messages =
    [
        'empr_ruc.required' => 'Ingrese un Ruc',
        'empr_razon.required' => 'Ingrese la Razon Social',
        'empr_email.required' => 'Ingrese el email',
        'empr_logo.required' => 'Selecciona un logo',
        'empr_direcc.required' => 'Ingrese una direccion de la empresa',
        'empr_telef.required' => 'Ingrese el telefono de la empresa',
    ];

    //validaciones en vivo
    public function updated($propertyName)
    {
        //dentro de este mnetodo se pone todas la validacione en vivo
        $this->validateOnly($propertyName, [
            'empr_ruc' => 'required',
            'empr_razon' => 'required',
            'empr_email' => 'required',
            'empr_logo' => 'required',
            'empr_direcc' => 'required',
            'empr_telef' => 'required',
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    //Elimina los mensajes de error luego de las validaciones
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function Guardar()
    {
        try {
            $datos = [
                'empr_ruc' => $this->empr_ruc,
                'empr_razon' => $this->empr_razon,
                'empr_email' => $this->empr_email,
                'empr_logo' => $this->empr_logo,
                'empr_direcc' => $this->empr_direcc,
                'empr_telef' => $this->empr_telef,
            ];

            //Verificamos que la se haya cargado una imagen
            if (!empty($this->empr_logo))
            {
                //si la imagen de ahora es diferente a que se tenia ingresa al if
                if ($this->empr_logo != $this->empr_logo_ant)
                {
                    $image = $this->empr_logo;
                    $nameImg = $this->empr_ruc . '-' . substr(uniqid(rand(), true), 8, 8) . '.' . $image->getClientOriginalExtension();
                    $move = Image::make($image)->save('images/logo/' . $nameImg);
                    if ($move)
                    {
                        $datos = array_merge($datos, ['empr_logo' => $nameImg]);
                    }
                }
            }

            Empresa::findOrFail($this->empr_id)->update($datos);;

            $this->emit('msgOK', 'Empresa Modificada');

            
        }
        catch (\Throwable $th)
        {
            //throw $th;
            $this->emit('msgERROR', 'Error:' . $th->getMessage());
        }
    }
}
