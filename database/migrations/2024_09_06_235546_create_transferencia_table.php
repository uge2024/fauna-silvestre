<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencia', function (Blueprint $table) {
            $table->id('id_transferencia');
            
            // Asegúrate de usar el tipo correcto para foreign keys (unsignedBigInteger si el ID en la tabla de referencia es unsigned)
            $table->unsignedBigInteger('id_institucion');
            $table->unsignedBigInteger('id_recepcion')->nullable();
            $table->unsignedBigInteger('id_nacimiento')->nullable();
            $table->date('fecha');
            $table->string('transporte', 255);
            $table->string('motivo_transferencia', 255);
            $table->unsignedBigInteger('institucion_destino');
            $table->string('describir_destino', 255);
        
            // Definición de claves foráneas con los nombres de columnas correctos
            $table->foreign('id_institucion')->references('id_institucion')->on('institucion')->onDelete('cascade');
            $table->foreign('id_recepcion')->references('id_recepcion')->on('recepcion')->onDelete('set null');
            $table->foreign('id_nacimiento')->references('id_nacimiento')->on('nacimiento')->onDelete('set null');
            $table->foreign('institucion_destino')->references('id_institucion')->on('institucion')->onDelete('cascade');
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transferencia');
    }
}
