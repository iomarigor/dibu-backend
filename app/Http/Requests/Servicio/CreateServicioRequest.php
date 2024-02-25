<?php

namespace App\Http\Requests\Servicio;

use Anik\Form\FormRequest;

class CreateServicioRequest extends FormRequest
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
            'descripcion' => 'required|string',
            'capacidad_maxima' => 'required|string',
        ];
    }
    public function messages(): array
    {
        return [];
    }
}
