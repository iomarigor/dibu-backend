<?php

namespace App\Services\Auth;

use App\Exceptions\ExceptionGenerate;
use Illuminate\Support\Facades\Auth;

class ValidateTokenService
{

    public function validateToken()
    {
        $user = Auth::user(); // Obtiene el usuario autenticado con el token actual

        if (!$user) {
            throw new ExceptionGenerate('Token no válido', 401);
        }

        return $user;
    }
}
