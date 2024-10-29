<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecesoTable extends Migration
{
    public function up()
    {
        Schema::create('deceso', function (Blueprint $table) {
            $table->id('id_deceso');
            $table->unsignedBigInteger('id_recepcion')->nullable();
            $table->unsignedBigInteger('id_institucion');
            $table->unsignedBigInteger('id_nacimiento')->nullable();
            $table->date('fecha');
            $table->string('causas');
            $table->string('diagnostico');
            $table->string('tratamiento')->nullable();
            $table->string('laboratorio_archivo')->nullable();
            $table->string('medico_veterinario');
            $table->foreign('id_recepcion')->references('id_recepcion')->on('recepcion')->onDelete('set null');
            $table->foreign('id_institucion')->references('id_institucion')->on('institucion')->onDelete('cascade');
            $table->foreign('id_nacimiento')->references('id_nacimiento')->on('nacimiento')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('deceso');
    }
}

