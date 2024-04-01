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

        $cantidadSistemas = Alumno::where('facultad', 'INGENIERIA EN INFORMATICA Y SISTEMAS')
            ->where('convocatoria_id', $convocatoria->id)
            ->count();

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
                'facultad' => [
                    'sistemas' => $cantidadSistemas
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
}