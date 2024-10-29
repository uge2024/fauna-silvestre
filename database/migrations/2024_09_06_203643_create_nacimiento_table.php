

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNacimientoTable extends Migration
{
    public function up()
    {
        Schema::create('nacimiento', function (Blueprint $table) {
            $table->id('id_nacimiento'); // Clave primaria
            $table->unsignedBigInteger('id_institucion'); // Llave foránea
            $table->unsignedBigInteger('id_recepcion'); // Llave foránea
            $table->date('fecha'); // Fecha de nacimiento
            $table->string('codigo'); // Código del nacimiento
            $table->string('clase'); // Clase del animal
            $table->string('sexo'); // Sexo del animal
            $table->string('nombre'); // Nombre del animal
            $table->string('fotografia')->default(''); // Fotografía del animal
            $table->string('peso'); // Peso del animal
            $table->string('edad'); // Edad del animal
            $table->string('señas')->nullable(); // Señales distintivas
            
            $table->string('estado_trasferencia'); // Estado de transferencia
            
            // Definición de las claves foráneas
            $table->foreign('id_institucion')
                  ->references('id_institucion')
                  ->on('institucion')
                  ->onDelete('cascade');

            // Agregar la clave foránea para id_recepcion
            $table->foreign('id_recepcion')
                  ->references('id_recepcion')
                  ->on('recepcion') // Asegúrate de que el nombre de la tabla sea correcto
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nacimiento');
    }
}
