<?php

namespace App\Http\Livewire;

use Livewire\Component;
//importamos permisos y roles
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use DB;
use Monolog\Handler\RollbarHandler;

class Permisos extends Component
{
    //creacion de variables publicas
    public $permisoTitle = 'Crear', $rolTitle = 'Crear', $userSelected="Seleccionar";
    //roles
    public $tab = 'roles', $rolSelected;

    public function render()
    {

        //---------------------------------------------------ROLES ----------------------------------------------------------------//
        //seleccionamos todos los roles de la base de datos, adicionalmente agregamos un campo llamado checked que incia por default en 0
        $roles = Role::select('*', DB::RAW("0 as checked"))->get();

        //verificamos que haya algun usuario seleccionado
        if ($this->userSelected != 'Seleccionar') {
            //hacemos un foreach a todos los roles
            foreach ($roles as $r) {
                //buscamos al usuario seleccionado
                $user = User::find($this->userSelected);
                //hace uso de un metodo del paquete, busca si tiene un rol  hasRole, pasamos el nombre del rol $r->name
                $tieneRol = $user->hasRole($r->name);
                //si  tiene ese rol el campo checked lo ponemos a 1
                if ($tieneRol) {
                    $r->checked = 1;
                }
            }
        }

        //---------------------------------------------------PERMISOS ----------------------------------------------------------------//
        $permisos = Permission::select('*', DB::RAW("0 as checked"))->get();

        //verificamos que haya algun permiso seleccionado
        if ($this->rolSelected != '' && $this->rolSelected != 'Seleccionar') {
            //hacemos un foreach a todos los permisos
            foreach ($permisos as $p) {
                //buscamos al usuario seleccionado
                $rol = Role::find($this->rolSelected);
                //hace uso de un metodo del paquete, busca si tiene un rol  hasRole, pasamos el nombre del rol $r->name
                $tienePermiso = $rol->hasPermissionTo($p->name);
                //si  tiene ese rol el campo checked lo ponemos a 1
                if ($tienePermiso) {
                    $p->checked = 1;
                }
            }
        }

        return view('livewire.permisos.listado', [
            'roles' => $roles,
            'permisos' => $permisos,
            'usuarios' => User::select('us_id', 'us_usuario')->get(),
        ]);
    }

    //---------------------------------------------------ROLES ----------------------------------------------------------------//
    public function resetInput()
    {
        $this->rolTitle = 'Crear';
        $this->permisoTitle = 'Crear';

        $this->userSelected = 'Seleccionar';
        $this->rolSelected = '';
    }

    public function CrearRol($rolNombre, $rolId)
    {
        if ($rolId)
            $this->UpdateRol($rolNombre, $rolId);
        else
            $this->SaveRol($rolNombre);
    }

    public function SaveRol($rolNombre)
    {
        if ($rolNombre) {
            $rol = Role::where('name', $rolNombre)->first(); // buscamos el rol con ese nombre
            if ($rol) //si lo encuentra mandamos mensaje de que ya existe
            {
                $this->emit('msgERROR', 'El Rol que intentas registrar ya existe en le sistema');
                return;
            }
            //caso contrario, registramos el rol
            Role::create([
                'name' => $rolNombre
            ]);
            $this->emit('msgOK', 'Rol registrado correctamente');
            $this->resetInput();
        }

    }

    public function UpdateRol($rolNombre, $rolId)
    {
        $rol = Role::where('name', $rolNombre)->where('id', '<>', $rolId)->first(); // buscamos el rol con ese nombre y que sea diferente al Id que queremos actualizar
        if ($rol) //si lo encuentra mandamos mensaje de que ya existe
        {
            $this->emit('msgERROR', 'El Rol que intentas registrar ya existe en le sistema');
            return;
        }

        $rol = Role::find($rolId);
        $rol->name = $rolNombre;
        $rol->save();
        $this->emit('msgOK', 'Rol actualizado correctamente');
        $this->resetInput();
    }

    public function destroyRol($rolId)
    {
        Role::find($rolId)->delete();
        $this->emit('msgOK', 'Rol eliminado correctamente');
    }

    public function AsignarRoles($rolesList)
    {
        if ($this->userSelected) {
            $user = User::find($this->userSelected);
            if ($user)
            {
                //este metodo eliminar el rol anterior y se le asigna uno nuevo
                $user->syncRoles($rolesList);
                $this->emit('msgOK', 'Roles asignados correctamente');
                $this->resetInput();
            }
        }
    }

    //Escuchadores
    protected $listeners =
    [
        //Nombre del listener  en el archivo blade=> metodo al que llama en este archivo
        "destroyRol" => "destroyRol",
        'CrearRol' => 'CrearRol',
        'AsignarRoles' => 'AsignarRoles',

        'destroyPermiso' => 'destroyPermiso',
        'CrearPermiso' => 'CrearPermiso',
        'AsignarPermisos' => 'AsignarPermisos',
    ];


    //---------------------------------------------------PERMISOS----------------------------------------------------------------//

    public function CrearPermiso($permisoNombre, $permisoId)
    {
        if ($permisoId)
            $this->UpdatePermiso($permisoNombre, $permisoId);
        else
            $this->SavePermiso($permisoNombre);
    }

    public function SavePermiso($permisoNombre)
    {
        $permiso = Permission::where('name', $permisoNombre)->first();
        if ($permiso) {
            $this->emit('msgERROR', 'El permiso que intentas registrar ya existe en el sistema');
            return;
        }
        Permission::create([
            'name' => $permisoNombre
        ]);
        $this->emit('msgOK', 'Permiso registrado correctamente');
        $this->resetInput();
    }

    public function UpdatePermiso($permisoNombre, $permisoId)
    {
        $permiso = Permission::where('name', $permisoNombre)->where('id', '<>', $permisoId) - first();
        if ($permiso) {
            $this->emit('msgERROR', 'El permiso que intentas registrar ya existe en el sistema');
            return;
        }

        $permiso = Permission::find($permisoId);
        $permiso->name = $permisoNombre;
        $permiso->save();
        $this->emit('msgOK', 'Permiso actualizado correctamente');
        $this->resetInput();
    }

    public function destroyPermiso($permisoId)
    {
        Permission::find($permisoId)->delete();
        $this->emit('msgOK', 'Permiso eliminado correctamente');
        $this->resetInput();
    }

    public function AsignarPermisos($permisosList, $rolId)
    {
        if ($rolId > 0) {
            $rol = Role::find($rolId);
            if ($rol) {
                //actualiza toda lista de permisos de este rol
                $rol->syncPermissions($permisosList);
                $this->emit('msgOK', 'Permisos asignados correctamente');
                $this->resetInput();
            }
        }
    }
}
