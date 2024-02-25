<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class demo extends FormRequest
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
            'user_id' => [
                'required',
                'exists:user,id',
            ],
            'servicio_id' => [
                'required',
                'exists:servicio,id',
            ],
        ];
    }
}
