<?php

namespace App\Http\Requests\Solicitud;

use Anik\Form\FormRequest;

class UploadDocumentRequest extends FormRequest
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
            'id_convocatoria' => [
                'required',
                'numeric',
            ],
            'dni_alumno' => [
                'required',
                'numeric',
                'dni_length',
            ],
            'name_file' => [
                'required',
                'string',
                'max:255',
            ],
            'file' => [
                'required',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'id_convocatoria.required' => 'El id de la convocatoria es requerido',
            'dni_alumno.required' => 'El dni del alumno es requerido',
            'name_file.required' => 'El nombre del documento es requerido',
            'file.required' => 'El archivo en base64 es requerido',
        ];
    }
}
