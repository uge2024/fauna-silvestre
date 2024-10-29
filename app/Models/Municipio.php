<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;
    protected $table = 'municipio'; // Nombre de la tabla

    protected $primaryKey = 'id_municipio'; // Clave primaria

    public $timestamps = false; // Si no estás usando timestamps

    protected $fillable = [
        'departamento', 
        'nombre', 
        'codigo'
    ];
}