<?php

namespace App\Http\Resources\Alumno;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlumnoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'codigo_estudiante' => $this->codigo_estudiante,
            'DNI' => $this->DNI,
            'nombres' => $this->nombres,
            'apellido_paterno' => $this->apellido_paterno,
            'apellido_materno' => $this->apellido_materno,
            'sexo' => $this->sexo,
            'facultad' => $this->facultad,
            'escuela_profesional' => $this->escuela_profesional,
            'modalidad_ingreso' => $this->modalidad_ingreso,
            'lugar_procedencia' => $this->lugar_procedencia,
            'lugar_nacimiento' => $this->lugar_nacimiento,
            'edad' => $this->edad,
            'correo_institucional' => $this->correo_institucional,
            'direccion' => $this->direccion,
            'fecha_nacimiento' =>$this->fecha_nacimiento,
            'correo_personal' => $this->correo_personal,
            'celular_estudiante' => $this->celular_estudiante,
            'celular_padre' => $this->celular_padre,
        ];
    }
}