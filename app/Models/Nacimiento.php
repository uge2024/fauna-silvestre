<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nacimiento extends Model
{
    use HasFactory;

    protected $table = 'nacimiento';
    protected $primaryKey = 'id_nacimiento';
    public $timestamps = false;

    protected $fillable = [
        'id_recepcion',
        'id_institucion',
        'fecha',
        'codigo',
        'clase',
        'sexo',
        'nombre',
        'fotografia',
        'peso',
        'edad',
        'señas',
      
        'estado_trasferencia',
    ];

    

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'id_institucion');
    }
    public function recepcion()
    {
        return $this->belongsTo(Recepcion::class, 'id_recepcion'); // Ajusta el nombre de clase según sea necesario
    }
    
}
