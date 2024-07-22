<?php

namespace App\Services\Servicio;

use App\Models\Servicio;

class UpdateServicioService
{
    public function update(Servicio $servicio, array $dataServicio): Servicio
    {
        $servicio->update([
            'nombre' => $dataServicio['nombre'],
            'descripcion' => $dataServicio['descripcion'],
        ]);

        return $servicio;
    }
}