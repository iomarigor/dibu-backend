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

        //dd(json_encode($convocatoria->secciones[0]->requisitos));
        //Cargando datos obtenidos del alumno en la solicitud
        //Nombre
        if ($convocatoria->secciones[0]->requisitos[0]->nombre == 'Código estudiante')
            $convocatoria->secciones[0]->requisitos[0]->default = $alumno->codigo_estudiante;

        if ($convocatoria->secciones[0]->requisitos[1]->nombre == 'DNI')
            $convocatoria->secciones[0]->requisitos[1]->default = $alumno->DNI;

        if ($convocatoria->secciones[0]->requisitos[2]->nombre == 'Nombres')
            $convocatoria->secciones[0]->requisitos[2]->default = $alumno->nombres;

        if ($convocatoria->secciones[0]->requisitos[3]->nombre == 'Apellidos')
            $convocatoria->secciones[0]->requisitos[3]->default = $alumno->apellido_paterno . ' ' . $alumno->apellido_materno;

        if ($convocatoria->secciones[0]->requisitos[4]->nombre == 'Sexo')
            $convocatoria->secciones[0]->requisitos[4]->default = $alumno->sexo;

        if ($convocatoria->secciones[0]->requisitos[5]->nombre == 'Facultad')
            $convocatoria->secciones[0]->requisitos[5]->default = $alumno->facultad;

        if ($convocatoria->secciones[0]->requisitos[6]->nombre == 'Escuela profesional')
            $convocatoria->secciones[0]->requisitos[6]->default = $alumno->escuela_profesional;

        if ($convocatoria->secciones[0]->requisitos[7]->nombre == 'Modalidad de ingreso')
            $convocatoria->secciones[0]->requisitos[7]->default = $alumno->modalidad_ingreso;

        $convocatoria->secciones[0]->requisitos[7];
        /* if ($convocatoria->secciones[0]->requisitos[8]->nombre == 'Lugar de procedencia')
            $convocatoria->secciones[0]->requisitos[8]->default = $alumno->lugar_procedencia;

        if ($convocatoria->secciones[0]->requisitos[9]->nombre == 'Lugar de nacimiento')
            $convocatoria->secciones[0]->requisitos[9]->default = $alumno->lugar_nacimiento; */

        if ($convocatoria->secciones[0]->requisitos[8]->nombre == 'Edad')
            $convocatoria->secciones[0]->requisitos[8]->default = $alumno->edad;

        if ($convocatoria->secciones[0]->requisitos[9]->nombre == 'Correo institucional')
            $convocatoria->secciones[0]->requisitos[9]->default = $alumno->correo_institucional;

        if ($convocatoria->secciones[0]->requisitos[10]->nombre == 'Dirección')
            $convocatoria->secciones[0]->requisitos[10]->default = $alumno->direccion;

        if ($convocatoria->secciones[0]->requisitos[11]->nombre == 'Feha de nacimiento')
            $convocatoria->secciones[0]->requisitos[11]->default = $alumno->fecha_nacimiento;

        if ($convocatoria->secciones[0]->requisitos[12]->nombre == 'Correo personal')
            $convocatoria->secciones[0]->requisitos[12]->default = $alumno->correo_personal;

        if ($convocatoria->secciones[0]->requisitos[13]->nombre == 'celular de estudiante')
            $convocatoria->secciones[0]->requisitos[13]->default = $alumno->celular_estudiante;

        if ($convocatoria->secciones[0]->requisitos[14]->nombre == 'Celular padre')
            $convocatoria->secciones[0]->requisitos[14]->default = $alumno->celular_padre;

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

        $convocatoria->secciones[3]->requisitos[1];
        $convocatoria->secciones[4]->requisitos[1];
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
