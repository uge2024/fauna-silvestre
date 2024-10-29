<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'adminlucia',
            'email' => 'lucia@gmail.com',
            'password' => bcrypt('543rumanilucia'), // Usar bcrypt para encriptar la contraseña
        ]);
        // Asignar el rol al usuario
        $user->assignRole('admin'); // Cambia 'admin' por el nombre del rol que quieras asignar

    }
}
