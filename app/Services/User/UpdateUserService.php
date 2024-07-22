<?php

namespace App\Services\User;

use App\Exceptions\ExceptionGenerate;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


class UpdateUserService
{
    public function update($id, array $data): Model
    {

        $user = User::where([
            ['username', '=', $data['username']],
            ['status_id', '!=', 1]
        ])->first();

        if ($user && ($user['id'] != $id)) {
            throw new ExceptionGenerate('Ya existe un usuario con el mismo nombre de usuario', 404);
        }
        if (array_key_exists('password', $data) && strlen($data['password']) == 0) {
            unset($data['password']);
        } else {
            // Hasheando contraseña
            if (array_key_exists('password', $data)) {
                $data["password"] = Hash::make($data['password']);
            }
        }
        unset($data['password_confirmation']);
        $data['last_user'] = auth()->id();
        // Recupera los datos actuales antes de la actualización
        $user = User::whereId($id)->first();
        if (!$user)
            throw new ExceptionGenerate('Usuario no enontrado', 404);

        $user->update($data);
        return $user;
    }
}
