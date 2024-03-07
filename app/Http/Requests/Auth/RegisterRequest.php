<?php

namespace App\Http\Requests\Auth;

use Anik\Form\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => [
                'required',
                'string',
                'max:255',
            ],
            'full_name' => [
                'required',
                'string',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'max:255',
            ],
            'password_confirmation' => [
                'required',
                'string',
                'max:255',
            ], 'email' => [
                'required',
                'string',
                'max:255',
            ], 'id_level_user' => [
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'username.required' => 'El usuario es requerido',
            'full_name.required' => 'El nombre es requerida',
            'password.required' => 'La contraseña es requerida',
            'password_confirmation.required' => 'La confirmacion de la contraseña es requerida',
            'email.required' => 'El email es requerida',
            'id_level_user.required' => 'El nivel del usuario a registrar es requerido',
        ];
    }
}
