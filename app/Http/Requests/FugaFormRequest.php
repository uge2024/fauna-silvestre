<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FugaFormRequest extends FormRequest
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
            //
            
            'id_institucion' => 'required|exists:institucion,id_institucion',
            'id_recepcion' => 'nullable|exists:recepcion,id_recepcion',
            'id_nacimiento' => 'nullable|exists:nacimiento,id_nacimiento',
            'fecha' => 'required|date',
           'codigo_padre' => 'nullable|string|max:50',
        ];
    }
}
