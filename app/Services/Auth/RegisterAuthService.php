<?php

namespace App\Services\Auth;

use App\Exceptions\ExceptionGenerate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterAuthService
{

    public function register(array $data)
    {
        $user = User::where([
            ['username', '=', $data['username']],
            ['status_id', '!=', 1],
            ['email', '=', $data['email']]
        ])->first();
        if ($user) {
            throw new ExceptionGenerate('Ya existe un usuario con el mismo nombre de usuario o correo electronico', 400);
        }
        unset($data['password_confirmation']);
        //Hasheando contraseña
        $data["password"] = Hash::make($data['password']);

        $user = User::create($data);

        return $user;
    }
}
