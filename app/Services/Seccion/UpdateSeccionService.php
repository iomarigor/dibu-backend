<?php

namespace App\Services\Seccion;

use App\Models\Seccion;

class UpdateSeccionService
{
    public function update(Seccion $seccion, array $dataSeccion): Seccion
    {
        $seccion->update([
            'descripcion' => $dataSeccion['descripcion'],            
        ]);

        return $seccion;
    }
}