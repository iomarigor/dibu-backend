<?php

namespace App\Services\Solicitud;

use App\Exceptions\ExceptionGenerate;
use App\Models\Alumno;
use App\Models\Convocatoria;
use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CargaSolicitudAlumnoService
{
    public function cargaSolicitudAlumno(int $dni)
    {
        //dd($dni);
        $alumno = Alumno::where('DNI', $dni)->first();
        if (!$alumno)
            throw new ExceptionGenerate('No existe registros del alumno', 200);

        $convocatoria = Convocatoria::find($alumno->convocatoria_id);
        if (!$convocatoria)
            throw new ExceptionGenerate('No existe registros del alumno en la actual convocatoria', 200);

        dd($convocatoria->secciones[0]);
    }
}
