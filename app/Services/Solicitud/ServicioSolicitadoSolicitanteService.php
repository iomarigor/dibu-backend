<?php

namespace App\Services\Solicitud;

use App\Exceptions\ExceptionGenerate;
use App\Models\Alumno;
use App\Models\Convocatoria;
use App\Models\ServicioSolicitado;
use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Collection;

class ServicioSolicitadoSolicitanteService
{
    public function servicioSolicitante(int $dni)
    {
        $alumno = Alumno::where('DNI', $dni)->first();
        if (!$alumno)
            throw new ExceptionGenerate('No existe registros del alumno', 200);
        $convocatoriasList = Convocatoria::get();
        $convocatoriasParticipadas = new Collection();
        foreach ($convocatoriasList as $convocatoria) {
            $solicitud = Solicitud::where('alumno_id', $alumno->id)
                ->where('convocatoria_id', $convocatoria->id)
                ->orderBy('solicitudes.created_at', 'desc')
                ->first();
            if ($solicitud) {
                $servicioSolicitado = ServicioSolicitado::where('solicitud_id', $solicitud->id)
                    ->with(['servicio' => function ($query) {
                        $query->select('id', 'nombre');
                    }])
                    ->get();

                $convocatoriasParticipadas->push([
                    "id_convocatoria" => $convocatoria->id,
                    "convocatoria" => $convocatoria->nombre,
                    "fecha_inicio" => $convocatoria->fecha_inicio,
                    "fecha_fin" => $convocatoria->fecha_fin,
                    "solicitudes" => $servicioSolicitado
                ]);
            }
        }

        $alumno->convocatorias_participadas = $convocatoriasParticipadas;

        return $alumno;
    }
}
