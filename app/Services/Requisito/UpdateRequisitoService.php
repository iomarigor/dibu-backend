<?php

namespace App\Services\Requisito;

use App\Models\Requisito;

class UpdateRequisitoService
{
    public function update(Requisito $requisito, array $dataRequisito): Requisito
    {
        $requisito->update([
            'descripcion' => $dataRequisito['descripcion'],
            'capacidad_maxima' => $dataRequisito['capacidad_maxima'],
        ]);

        return $requisito;
    }
}