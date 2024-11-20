<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DecesoFormRequest extends FormRequest
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
                'causas' => 'required|string|max:50',
                'diagnostico' => 'required|string|max:50',
              'tratamiento' => 'required|string|max:50',
             'laboratorio_archivo' => 'required|file|mimes:pdf|max:51120', // 5120 KB = 5 MB
              'medico_veterinario' => 'required|string|max:50',
        ];
    }
}
