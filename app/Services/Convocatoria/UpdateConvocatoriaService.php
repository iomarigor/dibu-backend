<?php

namespace App\Services\Convocatoria;

use App\Models\Convocatoria;

class UpdateConvocatoriaService
{
    public function update(Convocatoria $convocatoria, array $dataConvocatoria): Convocatoria
    {
        $convocatoria->update([
            'fecha_inicio' => $dataConvocatoria['fecha_inicio'],
            'fecha_fin' => $dataConvocatoria['fecha_fin'],
            'nombre' => $dataConvocatoria['nombre'],
        ]);

        return $convocatoria;
    }
}