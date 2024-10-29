<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // Asegúrate de importar correctamente la clase
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'usuario']);

        // Asignar rol 'admin' al usuario con ID 1
        $admin = User::find(1);
        if ($admin) {
            $admin->assignRole('admin');
        }

        // Asignar rol 'usuario' al usuario con ID 2
        $user = User::find(2);
        if ($user) {
            $user->assignRole('usuario');
        }
    }
}
