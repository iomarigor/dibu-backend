<?php

namespace App\Services\Convocatoria;

use App\Models\Convocatoria;
use App\Models\Alumno;
use App\Models\ServicioSolicitado;

class ReporteConvocatoriaService
{
    public function reporte($id)
    {
        $convocatoria = Convocatoria::findOrFail($id);

        $cantidadHombres = Alumno::where('sexo', 'M')
            ->where('convocatoria_id', $convocatoria->id)
            ->count();

        $cantidadMujeres = Alumno::where('sexo', 'F')
            ->where('convocatoria_id', $convocatoria->id)
            ->count();

        $facultades = $this->obtenerFacultades($convocatoria->id);
        $cantidadFacultades = [];

        foreach($facultades as $facultad){
            $cantidadFacultades[$facultad] = Alumno::where('facultad', $facultad)
                ->where('convocatoria_id', $convocatoria->id)
                ->count();
        }

        $cantidadPendientes = ServicioSolicitado::whereHas('solicitud', function ($query) use ($convocatoria) {
                $query->where('convocatoria_id', $convocatoria->id)
                    ->where('estado', 'pendiente'); // Pendiente
            })
            ->count();

        $cantidadRechazados = ServicioSolicitado::whereHas('solicitud', function ($query) use ($convocatoria) {
                $query->where('convocatoria_id', $convocatoria->id)
                    ->where('estado', 'rechazado'); // Rechazado
            })
            ->count();

        $cantidadAceptados = ServicioSolicitado::whereHas('solicitud', function ($query) use ($convocatoria) {
                $query->where('convocatoria_id', $convocatoria->id)
                    ->where('estado', 'aceptado'); // Aceptado
            })
            ->count();
            
        $cantidadAprobados = ServicioSolicitado::whereHas('solicitud', function ($query) use ($convocatoria) {
                $query->where('convocatoria_id', $convocatoria->id)
                    ->where('estado', 'aprobado'); // Aprobado
            })
            ->count();
        
        $reporte = [
                'sexo' => [
                    'num_hombres' => $cantidadHombres,
                    'num_mujeres' => $cantidadMujeres
                ],
                'facultades' => [
                    $cantidadFacultades
                ],
                'estados_solicitud' => [
                    'pendiente' => $cantidadPendientes,
                    'rechazado' => $cantidadRechazados,
                    'aceptado' => $cantidadAceptados,
                    'aprobado' => $cantidadAprobados
                ]
            ];
        return $reporte;
    }

    private function obtenerFacultades($id)
    {
        $facultades = Alumno::where('convocatoria_id', $id)
            ->groupBy('facultad')
            ->pluck('facultad')
            ->unique()
            ->values()
            ->toArray();
        return $facultades;
    }
}