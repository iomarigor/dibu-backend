<?php

namespace App\Services\Convocatoria;

use App\Models\Convocatoria;
use App\Models\Alumno;
use App\Models\DatosAlumnoAcademico;
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

        $facultades = $this->obtenerFacultades();
        $cantidadFacultades = [];

        foreach ($facultades as $facultad) {
            $cantidadFacultades[$facultad] = Alumno::where('facultad', $facultad)
                ->where('convocatoria_id', $convocatoria->id)
                ->count();
        }

        $escuelas = $this->obtenerEscuelasProfecionales();
        $cantidadEscuelas = [];

        foreach ($escuelas as $escuela) {
            $cantidadEscuelas[$escuela] = Alumno::where('escuela_profesional', $escuela)
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
            'facultades' => $cantidadFacultades,
            'escuelas_profesionales' => $cantidadEscuelas,
            'estados_solicitud' => [
                'pendiente' => $cantidadPendientes,
                'rechazado' => $cantidadRechazados,
                'aceptado' => $cantidadAceptados,
                'aprobado' => $cantidadAprobados
            ]
        ];
        return $reporte;
    }

    private function obtenerFacultades()
    {
        $facultades = DatosAlumnoAcademico::groupBy('nomfac')
            ->pluck('nomfac')
            ->unique()
            ->values()
            ->toArray();
        unset($facultades[0]);
        return $facultades;
    }

    private function obtenerEscuelasProfecionales()
    {
        $escuelas = DatosAlumnoAcademico::groupBy('nomesp')
            ->pluck('nomesp')
            ->unique()
            ->values()
            ->toArray();
        unset($escuelas[4]);
        return $escuelas;
    }
}
