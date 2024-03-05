<?php

namespace App\Services\Seccion;

use App\Models\Seccion;
use Illuminate\Database\Eloquent\Model;

class CreateSeccionService
{
    public function create(array $data): Model
    {
        return Seccion::create($data);
    }
}
