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
    public function cargaSolicitudAlumno(int $dni): Convocatoria
    {
        //dd($dni);
        $alumno = Alumno::where('DNI', $dni)->first();
        if (!$alumno)
            throw new ExceptionGenerate('No existe registros del alumno', 200);

        $convocatoria = Convocatoria::find($alumno->convocatoria_id);
        if (!$convocatoria)
            throw new ExceptionGenerate('No existe registros del alumno en la actual convocatoria', 200);

        //dd(json_encode($convocatoria->secciones));
        //Cargando datos obtenidos del alumno en la solicitud
        //Nombre
        for ($i = 0; $i < count($convocatoria->secciones[0]->requisitos); $i++) {
            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'Código estudiante')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->codigo_estudiante;

            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'DNI')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->DNI;

            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'Nombres')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->nombres;

            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'Apellidos')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->apellido_paterno . ' ' . $alumno->apellido_materno;

            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'Sexo')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->sexo;

            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'Facultad')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->facultad;

            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'Escuela profesional')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->escuela_profesional;

            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'Modalidad de ingreso')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->modalidad_ingreso;

            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'Edad')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->edad;

            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'Correo institucional')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->correo_institucional;

            /* if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'Dirección')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->direccion; */

            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'Feha de nacimiento')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->fecha_nacimiento;

            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'Correo personal')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->correo_personal;

            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'celular de estudiante')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->celular_estudiante;

            if ($convocatoria->secciones[0]->requisitos[$i]->nombre == 'Celular padre')
                $convocatoria->secciones[0]->requisitos[$i]->default = $alumno->celular_padre;
        }


        if ($alumno->lugar_nacimiento != null && strlen($alumno->lugar_nacimiento) > 0) {
            $datosNacimiento = explode("/", $alumno->lugar_nacimiento);
            if ($convocatoria->secciones[1]->requisitos[0]->nombre == 'Departamento de nacimiento')
                $convocatoria->secciones[1]->requisitos[0]->default = $datosNacimiento[0];
            if ($convocatoria->secciones[1]->requisitos[1]->nombre == 'Provincia de nacimiento')
                $convocatoria->secciones[1]->requisitos[1]->default = $datosNacimiento[1];
            if ($convocatoria->secciones[1]->requisitos[2]->nombre == 'Distrito de nacimiento')
                $convocatoria->secciones[1]->requisitos[2]->default = $datosNacimiento[2];
        }

        if ($alumno->lugar_procedencia != null && strlen($alumno->lugar_procedencia) > 0) {
            $datosProcedencia = explode("/", $alumno->lugar_procedencia);
            if ($convocatoria->secciones[2]->requisitos[0]->nombre == 'Departamento de procedencia')
                $convocatoria->secciones[2]->requisitos[0]->default = $datosProcedencia[0];
            if ($convocatoria->secciones[2]->requisitos[1]->nombre == 'Provincia de procedencia')
                $convocatoria->secciones[2]->requisitos[1]->default = $datosProcedencia[1];
            if ($convocatoria->secciones[2]->requisitos[2]->nombre == 'Distrito de procedencia')
                $convocatoria->secciones[2]->requisitos[2]->default = $datosProcedencia[2];
        }
        for ($i = 0; $i < count($convocatoria->secciones); $i++) {
            $convocatoria->secciones[$i]->requisitos[1];
        }
        //Quitar los requisitos de quienes solicitan por priemra vez, validarlo tambien al registrar la solicitud
        /* if ($alumno->lugar_procedencia != null && $alumno->lugar_nacimiento != null) {
            $secciones = [
                $convocatoria->secciones[0],
                $convocatoria->secciones[2]
            ];
            $convocatoria->secciones = $secciones;
            dd(json_encode($convocatoria->secciones));
        } */
        return $convocatoria;
    }
}
