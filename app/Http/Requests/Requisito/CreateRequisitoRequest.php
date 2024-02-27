<?php

namespace App\Http\Requests\Requisito;

use Anik\Form\FormRequest;

class CreateRequisitoRequest extends FormRequest
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
            'fecha_inicio.required' => 'La fecha de inicio es requerida',
            'fecha_fin.required' => 'La fecha de fin es requerida',
            'nombre.required' => 'El nombre es requerido',
            'user_id.required' => 'El id de usuario es requerido',
            'servicio_id.required' => 'El servicio es requerido',
        ];
    }
}
