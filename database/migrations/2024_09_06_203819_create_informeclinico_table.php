<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformeclinicoTable extends Migration
{
    public function up()
    {
        Schema::create('informeclinico', function (Blueprint $table) {
            $table->id('id_informeclinico');
            $table->unsignedBigInteger('id_recepcion')->nullable();
            $table->unsignedBigInteger('id_institucion');
            $table->unsignedBigInteger('id_nacimiento')->nullable();
            $table->string('fecha');
            $table->string('anamnesis');
            $table->string('diagnostico');
            $table->string('tratamiento');
            $table->string('programa_sanitario');
            $table->string('veterinario');
            $table->foreign('id_recepcion')->references('id_recepcion')->on('recepcion')->onDelete('set null');
            $table->foreign('id_institucion')->references('id_institucion')->on('institucion')->onDelete('cascade');
            $table->foreign('id_nacimiento')->references('id_nacimiento')->on('nacimiento')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('informeclinico');
    }
}
