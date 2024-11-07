<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformeClinico extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'informeclinico';
    protected $primaryKey = 'id_informeclinico';
    protected $fillable = [
        
        'id_institucion',
        'id_recepcion',
        'id_nacimiento',
        'fecha',
        'anamnesis',
        'diagnostico',
        'tratamiento',
        'programa_sanitario',
        'veterinario',
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

