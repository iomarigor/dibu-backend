<?php

namespace App\Services\Solicitud;

use App\Models\Convocatoria;
use App\Models\DetalleSolicitud;
use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Model;

class ShowSolicitudService
{
    public function show($id)/* : ?Model */
    {
        $solicitud = Solicitud::find($id);
        $convocatoria = Convocatoria::find($solicitud->convocatoria_id);
        $convocatoria->secciones[0]->requisitos;
        $convocatoria->secciones[1]->requisitos;
        $convocatoria->secciones[2]->requisitos;
        $solicitud->detalle_solicitudes = $convocatoria->secciones;

        $solicitud_detalle = DetalleSolicitud::where('solicitud_id', $solicitud->id)->get();
        for ($i = 0; $i < count($solicitud->detalle_solicitudes); $i++) {
            for ($j = 0; $j < count($solicitud->detalle_solicitudes[$i]->requisitos); $j++) {
                for ($k = 0; $k < count($solicitud_detalle); $k++) {
                    if ($solicitud->detalle_solicitudes[$i]->requisitos[$j]->id == $solicitud_detalle[$k]->requisito_id) {
                        $solicitud->detalle_solicitudes[$i]->requisitos[$j]->respuesta = $solicitud_detalle[$k];
                        continue;
                    }
                }
            }
        }
        return $solicitud;
    }
}
