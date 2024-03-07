<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ExceptionGenerate;

class DeleteUserService
{
    public function delete($id): Model
    {
        $user = User::find($id);
        if (!$user) {
            throw new ExceptionGenerate('Usuario no encontrado', 404);
        }
        $user->delete();
        return $user;
    }
}
