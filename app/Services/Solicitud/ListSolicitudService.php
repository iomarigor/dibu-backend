<?php

namespace App\Services\Solicitud;

use App\Exceptions\ExceptionGenerate;
use App\Models\Convocatoria;
use App\Models\Solicitud;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class ListSolicitudService
{
    public function list(): Collection
    {
        $fechaActual = new DateTime();
        $convocatoria = Convocatoria::first();
        if (!$convocatoria)
            throw new ExceptionGenerate('Actualmente no existe convocatoria en curso', 200);
        return Solicitud::where('id', $convocatoria->id)->get();
    }
}
