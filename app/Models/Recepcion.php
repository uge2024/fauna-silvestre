<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recepcion extends Model
{
    use HasFactory;

    protected $table = 'recepcion';  // Nombre de la tabla en singular si así está definida en la base de datos
    protected $primaryKey = 'id_recepcion';  // Llave primaria de la tabla

    // Deshabilitar las marcas de tiempo
    public $timestamps = false;

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        
       'id_institucion',
        'id_institucion_recibida',
        'responsable_decomiso',
        'fecha',
        'motivo_recepcion',
        'codigo_animal',
        'nombre',
        'clase',
        'especie',
        'fotografia',
        'edad',
        'estado',
        'sexo',
        'color',
        'descripcion_color', 
        'comportamiento',
        'sospech_enfermedad',
        'alteraciones_heridas', 
        'observaciones',
        'tiempo_cautiverio',
        'contacto_animales',
        'medicacion',
        'alimentacion',
        'estado_trasferencia',
    ];

   
    // Relación con la tabla instituciones
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'id_institucion');
    }
    public function institucionRecibida()
{
    return $this->belongsTo(Institucion::class, 'id_institucion_recibida');
}

}
