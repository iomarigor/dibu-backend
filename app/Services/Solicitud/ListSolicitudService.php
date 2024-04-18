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
        $convocatoria = Convocatoria::first();
        if (!$convocatoria)
            throw new ExceptionGenerate('Actualmente no existe convocatoria en curso', 200);


        $solicitudesTemporales = Solicitud::where('convocatoria_id', $convocatoria->id)->get();
        $solicitudes = new Collection();

        foreach ($solicitudesTemporales as $solicitudTemporal) {
            if (!$solicitudes->contains('codigo_estudiante', $solicitudTemporal->codigo_estudiante)) {
                $solicitudes->push($solicitudTemporal);
            }
        }
        return $solicitudes;
    }
}
