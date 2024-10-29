<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitucionTable extends Migration
{
    public function up()
    {
        Schema::create('institucion', function (Blueprint $table) {
            $table->id('id_institucion');
            $table->string('codigo');
            $table->string('nombre');
            $table->string('departamento');
            $table->unsignedBigInteger('id_municipio');
            $table->string('localizacion');
            $table->string('zona')->nullable();
            $table->foreign('id_municipio')->references('id_municipio')->on('municipio')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('institucion');
    }
}
