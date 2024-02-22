<?php

namespace App\Http\Requests\User;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends Request
{
    /**
     * Override the default validation method to use Illuminate\Validation\Validator
     *
     * @return Illuminate\Contracts\Validation\Validator
     */
    public function validator()
    {
        $validator = app('validator')->make($this->all(), [
            'username' => [
                'required',
                'string',
                'max:255'
            ],
            'full_name' => [
                'required',
                'string',
                'max:255'
            ],
            'password' => [
                'required',
                'confirmedstring',
                'min:6'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'id_level_user' => 'required',
            'last_user' => 'required',
        ]);

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
