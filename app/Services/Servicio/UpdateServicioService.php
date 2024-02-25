<?php

namespace App\Services\Servicio;

use App\Models\Servicio;

class UpdateServicioService
{
    public function update(Servicio $servicio, array $dataServicio): Servicio
    {
        $servicio->update([
            'descripcion' => $dataServicio['descripcion'],
            'capacidad_maxima' => $dataServicio['capacidad_maxima'],
        ]);

        return $servicio;
    }
}