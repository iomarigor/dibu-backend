<?php

namespace App\Services\Convocatoria;

use App\Exceptions\ExceptionGenerate;
use App\Models\Convocatoria;

class UpdateConvocatoriaService
{
    public function update(array $data, $id): ?Convocatoria
    {
        $convocatoria = Convocatoria::where([
            ['id', '=', $id]
        ])->first();
        if (!$convocatoria)
            throw new ExceptionGenerate('No se encontró la convocatoria', 404);
        $convocatoria->update($data);
        return $convocatoria;
    }
}
