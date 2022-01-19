<?php

namespace App\Http\Livewire;

use App\Exports\UsuariosExport;
use App\Models\Empleado;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Reportes\ReportUsuarios;

class Usuarios extends Component
{
    //paginado
    use WithPagination;
    //Tipo de paginacion
    protected $paginationTheme = 'bootstrap';
    //acciones
    public $Campo = 'us_id';
    public $OrderBy = 'desc';
    public $pagination = 5;
    public $buscar = '';

    //propiedades
    public $us_usuario, $us_password, $us_rol = 'Elegir', $us_empid = 'Elegir';
    // Id y Actualizar
    public $selected_id = null, $selected_id_edit = null;
    public $updateMode = false;
    //arrays
    public $empleados;

    public function render()
    {
        //$this->empleados=Empleado::where('emp_estado','Activo')->get();
        $this->empleados = DB::select('SELECT emp_id,concat(TRIM(emp_apellidos)," ",TRIM(emp_nombres)) as emp_nombres FROM empleados where emp_estado="Activo" order by emp_apellidos;');
        $data = User::query()
            ->search($this->buscar)
            ->orderBy($this->Campo, $this->OrderBy)
            ->paginate($this->pagination);

        return view(
            'livewire.usuarios.listado',
            [
                'data' => $data
            ]
        );
    }
    protected $rules =
    [
        'us_usuario' => 'required|unique:usuarios,us_usuario',
        'us_password' => 'required|min:6',
        'us_rol'     => 'not_in:Elegir',
        'us_empid'   => 'not_in:Elegir|unique:usuarios,us_empid'
    ];

    protected $messages =
    [
        'us_usuario.required' => 'El campo es requerido',
        'us_usuario.unique'   => 'Ya existe un Empleado con ese usuario',

        'us_password.required' => 'El campo es requerido',
        'us_password.min'     => 'La contraseña debe tener minimo 6 caracteres',

        'us_rol.not_in'       => 'Seleccione el rol del Usuario',

        'us_empid.not_in'     => 'Seleccione el Empleado del Usuario',
        'us_empid.unique'     => 'El empleado ya cuenta con un usuario',
    ];

    //validaciones en vivo
    public function updated($propertyName)
    {
        //dentro de este mnetodo se pone todas la validacione en vivo
        $this->validateOnly($propertyName, [
            'us_usuario' => 'required|unique:usuarios,us_usuario,' . $this->selected_id_edit . ',us_id',
            'us_password' => 'required|min:6',
            'us_rol'     => 'not_in:Elegir',
            'us_empid'   => 'not_in:Elegir|unique:usuarios,us_empid,' . $this->selected_id_edit . ',us_id',
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
        $this->us_usuario = null;
        $this->us_password = null;
        $this->us_rol = 'Elegir';
        $this->us_empid = 'Elegir';

        $this->selected_id = null;
        $this->selected_id_edit = null;

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
                'us_usuario'   => $this->us_usuario,
                'us_password'   => Hash::make($this->us_password),
                'us_rol'   => $this->us_rol,
                'us_empid'   => $this->us_empid,
            ];
        //realizamos validacion para registrar
        if ($this->selected_id_edit <= 0) {
            $this->validate();
            User::create($datos);
            $this->emit('closeModal');
            $this->emit('msgOK', 'Registro Creado');
        } else //realizamos la actualizacion
        {
            $this->validate([
                'us_usuario' => 'required|unique:usuarios,us_usuario,' . $this->selected_id_edit . ',us_id',
                'us_password' => 'required|min:6',
                'us_rol'     => 'not_in:Elegir',
                'us_empid'   => 'not_in:Elegir|unique:usuarios,us_empid,' . $this->selected_id_edit . ',us_id',
            ]);
            User::find($this->selected_id_edit)->update($datos);
            $this->emit('closeModal');
            $this->emit('msgEDIT', 'Registro Modificado');
        }
        $this->resetInput();
    }
    //metodo para
    public function edit($id)
    {
        $data = User::findOrFail($id);

        $this->selected_id_edit = $id;

        $this->us_usuario = $data->us_usuario;
        $this->us_password = $data->us_password;
        $this->us_rol = $data->us_rol;
        $this->us_empid = $data->us_empid;

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
        $record = User::findOrFail($id);
        $record->update([
            'us_estado' => $value
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

    //Reportes
    public function report_xls()
    {
        return Excel::download(new UsuariosExport, 'usuarios.xlsx');
    }

    public function report_pdf()
    {
        //aqui esta algo raro ya que el evento no funcona, se esta llamando directamente desde el templtes/usuarios/
        $this->emit('pdf_usuarios');        
    }
}
