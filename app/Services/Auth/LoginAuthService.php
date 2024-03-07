<?php

namespace App\Services\Auth;

use App\Exceptions\ExceptionGenerate;

class LoginAuthService
{

    public function login(array $data, string $ip_client)
    {
        $data['status_id'] = 3;
        if (!$token = auth()->attempt($data)) {
            // return response()->json(['msg' => 'Credenciales inválidas', 'detalle' => null], 401);
            throw new ExceptionGenerate('Credenciales inválidas', 401);
        }

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Actualizar la columna ip_address en el registro del usuario
        $user->update(['ip_address' => $ip_client]);

        $user['expirer_in'] = auth()->factory()->getTTL();
        $user['token'] = 'Bearer ' . $token;
        if ($user['status_id'] == 3) {
            return $user;
        } else {
            throw new ExceptionGenerate('Credenciales inválidas', 401);
        }
    }
}
