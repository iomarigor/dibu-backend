<?php

namespace App\Services\User;

use App\Exceptions\ExceptionGenerate;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class ShowUserService
{
    public function show($id): Model
    {
        $user = User::findDA($id);
        if (!$user)
            throw new ExceptionGenerate('Usuario no encontrado', 404);
        return $user;
    }
}
