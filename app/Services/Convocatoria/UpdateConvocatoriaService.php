<?php

namespace App\Services\Convocatoria;

use App\Models\Convocatoria;

class UpdateConvocatoriaService
{
    public function update(array $data, $id): ?Convocatoria
    {
        $convocatoria = Convocatoria::where([
            ['id', '=', $id]
        ])->first();
        if (!$convocatoria)
            return null;
        $convocatoria->update($data);
        return $convocatoria;
    }
}