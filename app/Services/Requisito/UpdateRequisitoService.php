<?php

namespace App\Services\Requisito;

use App\Models\Requisito;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;

class UpdateRequisitoService
{
    public function update(array $data, $id): ?Model
    {
        $requisito = Requisito::where([
            ['id', '=', $id]
        ])->first();
        if (!$requisito)
            return null;
        $requisito->update($data);
        return $requisito;
    }
}
=======

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
>>>>>>> j-migrations
