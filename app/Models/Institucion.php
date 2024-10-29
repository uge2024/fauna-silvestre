<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;
    protected $table = 'institucion'; // Nombre de la tabla

    protected $primaryKey = 'id_institucion'; // Clave primaria

    public $timestamps = false; // Si no estás usando timestamps

    protected $fillable = [
        'id_municipio', // Ensure this is included
        'codigo',
        'nombre',
        'departamento',
       
        'zona',
        'localizacion'
    ];
    
    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio');
    }
}