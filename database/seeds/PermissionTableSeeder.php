<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Lista de permisos -> Tabla permissions
        Permission::create(['name' =>'series_acceso']);
        Permission::create(['name' =>'series_crear']);
        Permission::create(['name' =>'series_acciones']);
        Permission::create(['name' =>'series_reportes']);

        //lista de roles -> Tabla roles
        $admin = Role::create(['name' => 'Admin']);
        $empleado = Role::create(['name' => 'Empleado']);

        $admin->givePermissionTo([
            'series_acceso',
            'series_crear',
            'series_acciones',
            'series_reportes',
        ]);
        
        $user = User::find(1);
        $user->assignRole('Admin');
    }
}
