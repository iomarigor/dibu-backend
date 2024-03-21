<?php

namespace App\Services\Convocatoria;

use App\Models\Convocatoria;
use Illuminate\Support\Collection;
use Carbon\Carbon;


class ListConvocatoriaService
{
    public function list(): Collection
    {
        $convocatorias = Convocatoria::all();
        //dd(count($convocatorias));
        foreach ($convocatorias as $i => $convocatoria) {
            $dateNow = Carbon::now()->toDateString();
            $fechaInicio = Carbon::parse($convocatoria->fecha_inicio)->toDateString();
            $fechaFin = Carbon::parse($convocatoria->fecha_fin)->toDateString();
            if ($fechaInicio > $dateNow) {
                $convocatorias[$i]->estado = 'Por iniciar';
                //continue;
            } elseif ($fechaFin < $dateNow) {
                $convocatorias[$i]->estado = 'Finalizada';
                //continue;
            } else {
                $convocatorias[$i]->estado = 'Activa';
            }
        }

        return $convocatorias;
    }
}
