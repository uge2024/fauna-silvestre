<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecepcionTable extends Migration
{
    public function up()
    {
        Schema::create('recepcion', function (Blueprint $table) {
            $table->id('id_recepcion');
            $table->unsignedBigInteger('id_institucion');
            $table->dateTime('fecha');
            $table->string('motivo_recepcion');
            $table->string('codigo_animal');
            $table->string('nombre');
            $table->string('clase');
            $table->string('especie');
            $table->string('fotografia');
            $table->string('edad');
            $table->string('estado');
            $table->string('sexo');
            $table->string('color');
            $table->string('descripcion_color', 300)->nullable(); // Make sure it's nullable
            $table->string('comportamiento');
            $table->string('contacto_animales');
            $table->string('sospech_enfermedad')->nullable();
            $table->string('alteraciones_heridas')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('medicacion')->nullable();
            $table->string('tiempo_cautiverio')->nullable();
            $table->string('alimentacion')->nullable();
            $table->string('estado_trasferencia')->nullable();
            
            $table->foreign('id_institucion')->references('id_institucion')->on('institucion')->onDelete('cascade');
        });
    }
    public function down()
{
    Schema::dropIfExists('recepcion');
}


}