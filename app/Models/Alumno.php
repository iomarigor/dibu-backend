<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $connection = 'mysql_dbu';
    protected $table = 'alumnos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'codigo_estudiante',
        'DNI',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'sexo',
        'facultad',
        'escuela_profesional',
        'modalidad_ingreso',
        'lugar_procedencia',
        'lugar_nacimiento',
        'edad',
        'correo_institucional',
        'direccion',
        'fecha_nacimiento',
        'correo_personal',
        'celular_estudiante',
        'celular_padre',
    ];
}
