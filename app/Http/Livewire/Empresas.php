<?php

namespace App\Http\Livewire;

use App\Models\Empresa;
use Livewire\Component;
use Livewire\WithFileUploads;

use Intervention\Image\ImageManagerStatic as Image;
use PhpParser\Node\Expr\FuncCall;

class Empresas extends Component
{
    //subir iamgenes
    use WithFileUploads;

    public $empr_id, $empr_ruc, $empr_razon, $empr_email, $empr_logo, $empr_logo_ant, $empr_direcc, $empr_telef,$empr_impr = 'Seleccionar';
    public $impresoras = [];

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
        $this->empr_impr = $empresa->empr_impr;
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
        'empr_logo' => 'required|file|mimes:jpg,png',
        'empr_direcc' => 'required',
        'empr_telef' => 'required',
        'empr_impr' => 'not_in:Seleccionar',
    ];

    protected $messages =
    [
        'empr_ruc.required' => 'Ingrese un Ruc',
        'empr_razon.required' => 'Ingrese la Razon Social',
        'empr_email.required' => 'Ingrese el email',
        'empr_logo.required' => 'Selecciona un logo',
        'empr_direcc.required' => 'Ingrese una direccion de la empresa',
        'empr_telef.required' => 'Ingrese el telefono de la empresa',
        'empr_impr.not_in' => 'Seleccione una impresora',
    ];

    protected $listeners =
    [
        'carga_impresora' => 'ListadoImpresoras'
    ];

    //validaciones en vivo
    public function updated($propertyName)
    {
        //dentro de este mnetodo se pone todas la validacione en vivo
        $this->validateOnly($propertyName, [
            'empr_ruc' => 'required',
            'empr_razon' => 'required',
            'empr_email' => 'required',
            'empr_logo' => 'required|file|mimes:jpg,png',
            'empr_direcc' => 'required',
            'empr_telef' => 'required',
            'empr_impr' => 'not_in:Seleccionar',
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
                'empr_impr' => $this->empr_impr,
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

                    $move_termica = Image::make($image)->resize(200,200)->save('images/logo/termica/' . $nameImg);
                    if ($move && $move_termica)
                    {
                        $datos = array_merge($datos, ['empr_logo' => $nameImg]);
                    }
                }
            }
            Empresa::findOrFail($this->empr_id)->update($datos);;

            $this->emit('msgOK', 'Datos Actualizados Correctamente');
        }
        catch (\Throwable $th)
        {
            //throw $th;
            $this->emit('msgERROR', 'Error:' . $th->getMessage());
        }
    }

     // -------------------------------------------- LISTADO DE IMPRESORAS-------------------------------------------------//
     public function ListadoImpresoras()
     {
         $ruta_powershell = 'c:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe'; #Necesitamos el powershell
         $opciones_para_ejecutar_comando = "-c";#Ejecutamos el powershell y necesitamos el "-c" para decirle que ejecutaremos un comando
         $espacio = " "; #ayudante para concatenar
         $comillas = '"'; #ayudante para concatenar
         $comando = 'get-WmiObject -class Win32_printer |ft shared, name'; #Comando de powershell para obtener lista de impresoras
         $delimitador = "True"; #Queremos solamente aquellas en donde la línea comienza con "True"
         $lista_de_impresoras = array(); #Aquí pondremos las impresoras
         exec(
             $ruta_powershell
             . $espacio
             . $opciones_para_ejecutar_comando
             . $espacio
             . $comillas
             . $comando
             . $comillas,
             $resultado,
             $codigo_salida);
         if ($codigo_salida === 0) {
             if (is_array($resultado)) {
                 #Omitir los primeros 3 datos del arreglo, pues son el encabezado
                 for($x = 3; $x < count($resultado); $x++){
                     $impresora = trim($resultado[$x]);

                     # Ignorar los espacios en blanco o líneas vacías
                     if (strlen($impresora) > 0) {
                         # Comprobar si comienzan con "True", para ello usamos el delimitador declarado arriba
                         if (strpos($impresora, $delimitador) === 0){

                             #Limpiar el nombre
                             $nombre_limpio = substr($impresora, strlen($delimitador) + 1, strlen($impresora) - strlen($delimitador) + 1);


                             #Finalmente agregarla al array
                             array_push($lista_de_impresoras, $nombre_limpio);
                         }
                     }
                 }
             }
             $this->impresoras = $lista_de_impresoras;
         } else
         {
             $this->emit('msgERROR', 'Error al ejecutar comando de Impresoras');
         }
     }
}
