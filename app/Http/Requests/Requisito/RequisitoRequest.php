<?php

namespace App\Http\Requests\Requisito;

use Anik\Form\FormRequest;

class RequisitoRequest extends FormRequest
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
            'nombre' => [
                'required',
            ],
            'descripcion' => [
                'required',
            ],
            'url_guia' => [
                'required',
            ],
            'estado' => [
                'required'
            ],
            'fecha_registro' => [
                'required',
                'date_format:Y-m-d'
            ],
            'tipo_requisito_id' => [
                'required',
            ],
            'convocatoria_id' => [
                'required',
            ],
            'seccion_id' => [
                'required',
            ],

        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es de inicio es requerida',
            'descripcion.required' => 'La descripcion es requerida',
            'url_guia.required' => 'La url guia es requerida',
            'estado.required' => 'El estado es requerido',
            'fecha_registro.required' => 'El fecha registro es requerido',
            'tipo_requisito_id.required' => 'El tipo de requisito requerido',
            'convocatoria_id.required' => 'El convocatoria es requerido',
            'seccion_id.required' => 'El seccion es requerido',
        ];
    }
}
