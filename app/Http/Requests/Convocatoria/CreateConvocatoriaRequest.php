<?php

namespace App\Http\Requests\Convocatoria;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateConvocatoriaRequest extends Request
{
    /**
     * Override the default validation method to use Illuminate\Validation\Validator
     *
     * @return Illuminate\Contracts\Validation\Validator
     */
    protected function validator()
    {
        $validator = app('validator')->make($this->all(), [
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
        ]);

        // Optionally, you can customize the error messages here
        // $validator->setAttributeNames([
        //     'name' => 'Nombre',
        //     'email' => 'Correo electrónico',
        //     'password' => 'Contraseña',
        // ]);

        return $validator;
    }

    /**
     * Override the default failed validation method to throw an exception
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {
        return $this->validator()->validated();
    }
}