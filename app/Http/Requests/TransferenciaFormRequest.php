<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferenciaFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            
            'id_institucion' => 'required|exists:institucion,id_institucion',
            'id_recepcion' => 'nullable|exists:recepcion,id_recepcion|required_without:id_nacimiento',
            'id_nacimiento' => 'nullable|exists:nacimiento,id_nacimiento|required_without:id_recepcion',
            'fecha' => 'required|date',
            'transporte' => 'required|string|max:255',
            
            'motivo_transferencia' => 'required|string|max:255',
            'institucion_destino' => 'required|exists:institucion,id_institucion|different:id_institucion',
        'describir_destino' => 'required|string|max:255',
        ];
    }
}
