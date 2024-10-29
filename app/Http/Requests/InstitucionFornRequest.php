<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstitucionFornRequest extends FormRequest
{
    public function rules()
    {
        return [
           'id_municipio' => 'required|exists:municipio,id_municipio',
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            
            'zona' => 'nullable|string|max:255',
            'localizacion' => 'required|string', // Make sure this is validated correctly
        ];
    }

   
}
