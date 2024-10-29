<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipioTable extends Migration
{
    public function up()
    {
        Schema::create('municipio', function (Blueprint $table) {
            $table->id('id_municipio');
            $table->string('departamento');
            $table->string('nombre');
            $table->string('codigo')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('municipio');
    }
}
