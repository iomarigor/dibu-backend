<?php

namespace App\Http\Requests\User;

use Anik\Form\FormRequest;

class UserRequest extends FormRequest
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
                'max:255'
            ],
            'full_name' => [
                'required',
                'string',
                'max:255'
            ],
            'password' => [
                'required',
                'string',
                'min:6'
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:6'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'id_level_user' => 'required',
            'last_user' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'username.required' => 'El nombre de usuario es requerido',
            'full_name.required' => 'El nombre completo es requerido',
            'password.required' => 'La contraseña es requerida',
            'password_confirmation.required' => 'La contraseña es requerida',
            'email.required' => 'El correo es requerido',
            'id_level_user.required' => 'El nivel de acceso de usuario es requerido',
        ];
    }
}
