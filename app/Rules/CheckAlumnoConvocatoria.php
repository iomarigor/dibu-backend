<?php

namespace App\Rules;

use App\Models\Convocatoria;
use App\Models\Solicitud;
use Illuminate\Contracts\Validation\Rule;
use DateTime;

class CheckAlumnoConvocatoria implements Rule
{
    public function passes($attribute, $value)
    {
        // Verificar que el alumno no hizo ninguna solicitud
        $fechaActual = new DateTime();
        $convocatoria = Convocatoria::whereDate('fecha_inicio', '<=', $fechaActual)
            ->whereDate('fecha_fin', '>=', $fechaActual)
            ->first();
        if (!$convocatoria) {
            return 'No existe convocatoria activa';
        }

        //eliminando la solicitud de la db para registrar la nueva
        /* $solicitud = Solicitud::where('convocatoria_id', $convocatoria->id)
            ->where('alumno_id', $value)
            ->first();
        if ($solicitud)
            $solicitud->delete(); */
        return true;
    }

    public function message()
    {
        return 'Ya has postulado anteriormente a esta convocatoria';
    }
}
