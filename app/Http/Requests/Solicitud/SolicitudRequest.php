<?php

namespace App\Http\Requests\Solicitud;

use Anik\Form\FormRequest;
use App\Rules\CheckAlumnoConvocatoria;
use App\Rules\CheckCantidadRequisitos;
use Illuminate\Validation\Rule;

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
                Rule::exists('convocatorias', 'id'),
            ],
            'alumno_id' => [
                'required',
                'numeric',
                Rule::exists('alumnos', 'id'),
                new CheckAlumnoConvocatoria,
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
                Rule::exists('servicios', 'id'),
            ],
            'detalle_solicitudes' => [
                'required',
                'array',
                new CheckCantidadRequisitos,
            ],
            'detalle_solicitudes.*.respuesta_formulario' => [
                'nullable',
                'string',
                'max:255',
            ],
            'detalle_solicitudes.*.url_documento' => [
                'nullable',
                'string',
                'max:255',
            ],
            'detalle_solicitudes.*.opcion_seleccion' => [
                'nullable',
                'string',
                'max:255',
            ],
            'detalle_solicitudes.*.requisito_id' => [
                'required',
                'numeric',
                Rule::exists('requisitos', 'id'),
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
