<?php

namespace App\Http\Requests\Solicitud;

use Anik\Form\FormRequest;

class SolicitudServicioRequest extends FormRequest
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
            'solicitud_id' => [
                'required',
                'numeric',
            ],
            'servicios.*.detalle_rechazo' => [
                'nullable',
                'string',
                'max:255',
            ],
            'servicios.*.servicio_id' => [
                'required',
                'numeric',
            ],
            'servicios.*.estado' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            '*.servicio_id.required' => 'El id de la solicitud de servicio es requeriso',
            '*.estado.required' => 'El estado es requerido',
        ];
    }
}
