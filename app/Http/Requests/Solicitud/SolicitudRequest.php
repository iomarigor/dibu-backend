<?php

namespace App\Http\Requests\Solicitud;

use Anik\Form\FormRequest;

class SolicitudRequest extends FormRequest
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
        ];
    }
    
    public function messages(): array
    {
        return [
            'fecha_inicio.required' => 'La fecha de inicio es requerida',
            'fecha_fin.required' => 'La fecha de fin es requerida',
            'nombre.required' => 'El nombre es requerido',
            'convocatoria_servicio.required' => 'La convocatoria de servicio es requerida',
        ];
    }
}