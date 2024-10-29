<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TruncateTablesSeeder extends Seeder
{
    public function run()
    {
        // Desactiva las restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Trunca las tablas
        DB::table('deceso')->truncate();
        DB::table('nacimiento')->truncate();
        DB::table('fuga')->truncate();
        DB::table('recepcion')->truncate();
        DB::table('informeclinico')->truncate();
        DB::table('transferencia')->truncate();
        DB::table('municipio')->truncate();
        DB::table('institucion')->truncate();

        // Reactiva las restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
