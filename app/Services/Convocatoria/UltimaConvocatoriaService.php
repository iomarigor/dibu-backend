<?php

namespace App\Services\Convocatoria;

use App\Exceptions\ExceptionGenerate;
use App\Models\Convocatoria;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class UltimaConvocatoriaService
{
    public function vigente(): ?Model
    {
        $fechaActual = new DateTime();
        $convocatoria = Convocatoria::where('fecha_inicio', '<=', $fechaActual)
            ->where('fecha_fin', '>=', $fechaActual)->first();
        if (!$convocatoria)
            throw new ExceptionGenerate('Actualmente no existe convocatoria en curso', 200);
        return $convocatoria;
    }
}
