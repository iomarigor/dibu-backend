<?php

namespace App\Http\Requests\Convocatoria;

use Anik\Form\FormRequest;
use App\Rules\CheckConvocatoriaDates;

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
                'date_format:Y-m-d',
                new CheckConvocatoriaDates,
            ],
            'fecha_fin' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:fecha_inicio',
            ],
            'nombre' => [
                'required',
                'string',
                'max:255',
            ],
            'convocatoria_servicio' => [
                'required',
                'array'
            ],
            'convocatoria_servicio.*.servicio_id' => [
                'required',
                'numeric',
            ],
            'convocatoria_servicio.*.cantidad' => [
                'required',
                'numeric',
                'min:0',
            ],
            'secciones' => [
                'required',
                'array'
            ],
            'secciones.*.descripcion' => [
                'required',
                'string',
                'max:255',
            ],
            'secciones.*.requisitos' => [
                'required',
                'array'
            ],
            'secciones.*.requisitos.*.nombre' => [
                'required',
                'string',
                'max:255',
            ],
            'secciones.*.requisitos.*.descripcion' => [
                'nullable',
                'string',
                'max:255',
            ],
            'secciones.*.requisitos.*.url_guia' => [
                'nullable',
                'string',
                'max:255',
            ],
            'secciones.*.requisitos.*.url_plantilla' => [
                'nullable',
                'string',
                'max:255',
            ],
            'secciones.*.requisitos.*.opciones' => [
                'nullable',
                'string',
                'max:255',
            ],
            'secciones.*.requisitos.*.tipo_requisito_id' => [
                'required',
                'numeric',
            ],
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
