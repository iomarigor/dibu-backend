<?php

namespace App\Services\Servicio;

use App\Models\Servicio;
use Illuminate\Database\Eloquent\Model;

class CreateServicioService
{
    public function create(array $data): Model
    {
        return Servicio::create([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
        ]);
    }
}