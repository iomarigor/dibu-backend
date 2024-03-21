<?php

namespace App\Services\DatosAlumnoAcademico;

use App\Models\DatosAlumnoAcademico;
use Illuminate\Database\Eloquent\Model;

class ShowDatosAlumnoAcademico
{
    public function show($DNI): ?Model
    {
        $caracter = "DNI";
        $dni = substr($DNI, 0, 0) . $caracter . substr($DNI, 0);
        $datosAlumnoAcademico = DatosAlumnoAcademico::where('tdocumento', $dni)->first();;
        return $datosAlumnoAcademico;
    }
}