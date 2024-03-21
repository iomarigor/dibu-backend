<?php

namespace App\Services\Auth;

use App\Models\TokenBlacklist;

class LogoutAuthService
{

    public function logout(string $token)
    {

        // Registra el token actual en la tabla de blacklist
        TokenBlacklist::insert(['token' => $token]);
        // Invalida el token
        auth()->logout();
        return null;
    }
}
