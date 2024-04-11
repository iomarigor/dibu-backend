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
    public function servicioSolicitante(int $dni): Collection
    {
        $alumno = Alumno::where('DNI', $dni)->first();
        if (!$alumno)
            throw new ExceptionGenerate('No existe registros del alumno', 200);

        $solicitud = Solicitud::where('alumno_id', $alumno->id)
            ->where('convocatoria_id', $alumno->convocatoria_id)->first();
        if (!$solicitud)
            throw new ExceptionGenerate('No existe registros del alumno en la actual convocatoria solicitando servicios', 200);

        $servicioSolicitado = ServicioSolicitado::where('solicitud_id', $solicitud->id)
            ->with(['servicio' => function ($query) {
                $query->select('id', 'nombre');
            }])
            ->get();
        if (!$servicioSolicitado)
            throw new ExceptionGenerate('No existe registros del alumno en la actual convocatoria solicitando servicios', 200);

        return $servicioSolicitado;
    }
}
