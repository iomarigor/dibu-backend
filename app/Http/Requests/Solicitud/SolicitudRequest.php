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
            'convocatoria_id' => [
                'required',
                'numeric',
            ],
            'alumno_id' => [
                'required',
                'numeric',
            ],
            'servicios_solicitados' => [
                'required',
                'array'
            ],
            'servicios_solicitados.*.estado' => [
                'required',
                'string',
                'max:255',
            ],
            'servicios_solicitados.*.servicio_id' => [
                'required',
                'numeric',
            ],
            'detalle_solicitudes' => [
                'required',
                'array'
            ],
            'detalle_solicitudes.*.respuesta_formulario' => [
                'required',
                'string',
                'max:255',
            ],
            'detalle_solicitudes.*.url_documento' => [
                'required',
                'string',
                'max:255',
            ],
            'detalle_solicitudes.*.requisito_id' => [
                'required',
                'numeric',
            ],
        ];
    }
    
    public function messages(): array
    {
        return [
            'servicios_solicitados.*.servicio_id.required' => 'El servicio a solicitar es requerida',
        ];
    }
}