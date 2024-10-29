<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformeClinicoFormRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            
            'id_institucion' => 'required|exists:institucion,id_institucion',
            'id_recepcion' => 'nullable|exists:recepcion,id_recepcion',
            'id_nacimiento' => 'nullable|exists:nacimiento,id_nacimiento',
            'fecha' => 'required|date',
            'anamnesis' => 'required|string|max:255',
            'diagnostico' => 'required|string|max:255',
            'tratamiento' => 'required|string|max:255',
            'programa_sanitario' => 'required|string|max:255',
            'veterinario' => 'required|string|max:255',
        ];
    }

    /**
     * Determine if the request is valid.
     *
     * @return bool
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->id_recepcion && $this->id_nacimiento) {
                $validator->errors()->add('id_recepcion', 'No puedes seleccionar tanto una recepción como un nacimiento. Selecciona solo uno.');
            }
        });
    }
}
