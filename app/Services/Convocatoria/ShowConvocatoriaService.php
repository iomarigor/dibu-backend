<?php

namespace App\Services\Convocatoria;

use App\Models\Convocatoria;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ExceptionGenerate;

class ShowConvocatoriaService
{
    public function show($id): Model
    {
        $convocatoria = Convocatoria::find($id);
        if (!$convocatoria)
            throw new ExceptionGenerate('No se encontró la convocatoria', 404);
        return $convocatoria;
    }
}
