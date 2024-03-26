<?php

namespace App\Rules;

use App\Models\Convocatoria;
use App\Models\Seccion;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Requisito;
use DateTime;

class CheckCantidadRequisitos implements Rule
{
    public function passes($attribute, $value)
    {
        // Verificar la cantidad de requisitos con los requisitos enviados por la solicitud
        $fechaActual = new DateTime();
        $convocatoria = Convocatoria::whereDate('fecha_inicio', '<=', $fechaActual)
            ->whereDate('fecha_fin', '>=', $fechaActual)
            ->first();
        if(!$convocatoria){
            return 'No existe convocatoria activa';
        }
        $cantidad = Seccion::where('convocatoria_id', '=', $convocatoria->id)
            ->withCount('requisitos')
            ->get()
            ->sum('requisitos_count');
        
        return count($value) == $cantidad;
    }

    public function message()
    {
        return 'Necesitas llenar todos los requisitos de la solicitud';
    }
}