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
                'string',
                'max:255',
            ],
            'descripcion' => [
                'required',
                'string',
                'max:255',
            ],
            'url_guia' => [
                'required',
                'string',
                'max:255',
            ],
            'estado' => [
                'required',
                'string',
            ],
            'fecha_registro' => [
                'required',
                'date',
                'date_format:Y-m-d',
            ],            
        ];
    }
    public function messages(): array
    {
        return [
            'nombre.required' => 'La fecha de inicio es requerida',
            'descripcion.required' => 'La fecha de fin es requerida',
            'url_guia.required' => 'El nombre es requerido',
            'estado.required' => 'El id de usuario es requerido',
            'fecha_registro.required' => 'El servicio es requerido',
        ];
    }
}
