<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuga extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'fuga';
    protected $primaryKey = 'id_fuga';
    protected $fillable = [
      
        'id_institucion',
        'id_recepcion',
        'id_nacimiento',
        'fecha',
       
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
        return $this->belongsTo(nacimiento::class, 'id_nacimiento');
    }
}


