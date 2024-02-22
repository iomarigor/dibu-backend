<?php

namespace App\Services\Servicio;

use App\Models\Servicio;
use Illuminate\Database\Eloquent\Model;

class CreateServicioService
{
    public function create(array $data): Model
    {
        return Servicio::create([
            'descripcion' => $data['descripcion'],
            'capacidad_maxima' => $data['capacidad_maxima'],
        ]);
    }
}