<?php

namespace App\Http\Requests\Auth;

use Anik\Form\FormRequest;

class AuthRequest extends FormRequest
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
            'password' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'username.required' => 'El username es requerida',
            'password.required' => 'La password es requerida',
        ];
    }
}
