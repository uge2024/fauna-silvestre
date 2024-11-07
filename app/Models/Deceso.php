<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deceso extends Model
{


    use HasFactory;
    public $timestamps = false;
    protected $table = 'deceso';
    protected $primaryKey = 'id_deceso';
    protected $fillable = [
       
        'id_institucion',
        'id_recepcion',
        'id_nacimiento',
        'fecha',
        'causas',
        'diagnostico',
        'laboratorio_archivo',
        'tratamiento',
        'medico_veterinario',
    ];
    

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'id_institucion');
    }

    public function recepcion()
    {
        return $this->belongsTo(Recepcion::class, 'id_recepcion');
    }
    public function nacimiento()
    {
        return $this->belongsTo(Nacimiento::class, 'id_nacimiento');
    }
}

