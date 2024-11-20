<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecepcionFormRequest extends FormRequest
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
         'id_institucion_recibida' => 'required|exists:institucion,id_institucion',
        'id_institucion' => 'required|exists:institucion,id_institucion|different:id_institucion_recibida',
        'responsable_decomiso' => 'required|string',        
        'fecha' => 'required|date',      
        'motivo_recepcion' => 'required|max:300',
       'codigo_animal' => 'nullable|string|max:50',
        'nombre' => 'required|max:50',
        'clase' => 'required|max:50',
        'especie' => 'required|max:50',
        'fotografia' => 'nullable|mimes:jpeg,bmp,png', // Agregado nullable
        'edad' => 'required|max:50',
        'estado' => 'required|max:50',
        'sexo' => 'required|max:50',
        'color' => 'required|max:50',
       'descripcion_color' => 'nullable|string|max:300',

        'comportamiento' => 'nullable|max:300', // Agregado nullable
        'sospech_enfermedad' => 'nullable|max:300', // Agregado nullable
        'alteraciones_heridas' => 'nullable|max:300', // Agregado nullable
        'observaciones' => 'nullable|max:300', // Agregado nullable
        'tiempo_cautiverio' => 'nullable|max:300', // Agregado nullable
        'contacto_animales' => 'nullable|max:300', // Agregado nullable
        'medicacion' => 'nullable|max:300', // Agregado nullable
        'alimentacion' => 'nullable|max:300', // Agregado nullable
        'estado_trasferencia' => 'sometimes|string', // if it's optional or automatically set
    ];
}

}
