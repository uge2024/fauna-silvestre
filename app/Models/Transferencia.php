<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    use HasFactory;

    protected $table = 'transferencia';
    protected $primaryKey = 'id_transferencia';
    public $timestamps = false;

    protected $fillable = [
        
        'id_institucion',// institucion_actual
        'id_recepcion',
        'id_nacimiento',
        'fecha',
        'transporte',
        'motivo_transferencia',
        
        'institucion_destino',//institucion_destino
        'describir_destino',
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
    public function institucionDestino()
{
    return $this->belongsTo(Institucion::class, 'institucion_destino', 'id_institucion');
}

}
