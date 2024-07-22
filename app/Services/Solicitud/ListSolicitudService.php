<?php

namespace App\Services\Solicitud;

use App\Exceptions\ExceptionGenerate;
use App\Models\Convocatoria;
use App\Models\Solicitud;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class ListSolicitudService
{
    public function list($id): Collection
    {
        $convocatoria = Convocatoria::find($id);
        if (!$convocatoria)
            throw new ExceptionGenerate('Convocatoria no encontrada', 200);


        $solicitudesTemporales = Solicitud::where('convocatoria_id', $convocatoria->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $solicitudes = new Collection();

        foreach ($solicitudesTemporales as $solicitudTemporal) {
            if (!$solicitudes->contains('alumno_id', $solicitudTemporal->alumno_id)) {
                $solicitudes->push($solicitudTemporal);
            }
        }
        return $solicitudes;
    }
}
