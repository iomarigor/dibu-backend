<?php

namespace App\Exports;

use App\Models\Servicio;
use App\Models\Solicitud;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class SolicitudesExport implements FromCollection
{
    public function collection()
    {
        $servicios = Servicio::all();
        $solicitudes = Solicitud::select(
            'solicitudes.id',
            'a.created_at as fecha_solicitud',
            'a.codigo_estudiante',
            'a.DNI',
            DB::raw('concat(a.apellido_paterno, \' \', a.apellido_materno, \', \', a.nombres) as alumno'),
            'a.sexo',
            'a.facultad',
            'a.escuela_profesional',
            'a.lugar_procedencia',
            'a.lugar_nacimiento',
            'a.edad',
            'a.correo_institucional',
            'a.celular_estudiante',
        )
            ->join('alumnos as a', 'solicitudes.alumno_id', '=', 'a.id')
            ->join('servicio_solicitado as ss', 'ss.solicitud_id', '=', 'solicitudes.id')
            ->where('ss.servicio_id', 1)
            ->get();

        return $solicitudes;
        //return ['demo' => 'Solicitud', 'demo' => 'Solicitud', 'demo' => 'Solicitud', 'demo' => 'Solicitud'];
    }
}
