<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Collection;

class ListUserService
{
    public function list(): Collection
    {
        return  User::allDA();
    }
}
