<?php

namespace App\Http\Requests\Servicio;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Laravel\Lumen\Http\Request as LumenRequest;

class CreateServicioRequest extends LumenRequest
{
    /**
     * Validate the incoming request with the given rules.
     *
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validator()
    {
        $rules = [
            'descripcion' => 'required|string',
            'capacidad_maxima' => 'required|string',
        ];
        $validator = app('validator')->make($this->all(), $rules);

        if ($validator->fails()) {
            $this->failedValidation($validator);
        }

        return $this->validationData();
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
