<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NacimientosFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
            'id_institucion' => 'required|exists:institucion,id_institucion',
              'codigo' => 'nullable|string|max:50',
            'fecha' => 'required|date',
            'clase' => 'required|string|max:50',
            'sexo' => 'required|string|max:50',
            'nombre' => 'required|string|max:50',
            'fotografia' => 'nullable|image|max:2048', // Permite imagen opcional
            'peso' => 'required|string|max:50',
            'edad' => 'required|string|max:50',
            'señas' => 'nullable|string|max:50',
            'codigo_padres' => 'nullable|string|max:50', // Permite nulo
            'estado_trasferencia' => 'sometimes|string', // if it's optional or automatically set

        ];
    }
}
