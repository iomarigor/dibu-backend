<?php

namespace App\Http\Requests\Convocatoria;

use Anik\Form\FormRequest;

class ConvocatoriaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'fecha_inicio' => [
                'required',
                'date',
                'date_format:Y-m-d'
            ],
            'fecha_fin' => [
                'required',
                'date',
                'date_format:Y-m-d'
            ],
            'nombre' => [
                'required',
                'string',
                'max:255'
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'fecha_inicio.required' => 'La fecha de inicio es requerida',
            'fecha_fin.required' => 'La fecha de fin es requerida',
            'nombre.required' => 'El nombre es requerido',
        ];
    }
}