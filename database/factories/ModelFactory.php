<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Alumno;
use App\Models\Convocatoria;
use App\Models\ConvocatoriaServicio;
use App\Models\DatosAlumnoAcademico;
use App\Models\LevelUser;
use App\Models\Requisito;
use App\Models\Seccion;
use App\Models\Servicio;
use App\Models\ServicioSolicitado;
use App\Models\Solicitud;
use App\Models\DetalleSolicitud;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'username' => $faker->username,
        'email' => $faker->email,
    ];
});

$factory->define(ServicioSolicitado::class, function (Faker $faker) {
    return [
        'estado' => 'Estado',
        //'fecha _revision' => '2024-03-19',
        'servicio_id' => 1,
        'solicitud_id' => 1,
    ];
});

$factory->define(DetalleSolicitud::class, function (Faker $faker) {
    return [
        'respuesta_formulario' => 'si',
        'url_documento' => 'xD',
        'opcion_seleccion' => '1',
        'solicitud_id' => 1,
        'requisito_id' => 1,
    ];
});

$factory->define(Alumno::class, function (Faker $faker) {
    return [
        'codigo_estudiante' => '0020160158',
        'DNI' => '71658095',
        'nombres' => $faker->name,
        'apellido_paterno' => $faker->name,
        'apellido_materno' => $faker->name,
        'sexo' => 'varon',
        'facultad' => 'Informatica',
        'escuela_profesional' => 'Informatica y sistemas',
        'modalidad_ingreso' => 'Examen admision',
        'lugar_procedencia' => 'Tocache',
        'lugar_nacimiento' => 'Lima',
        'edad' => 20,
        'correo_institucional' => 'correo@unas.edu.pe',
        'direccion' => 'direccionfake',
        'correo_personal' => 'correofake@gmail.com',
        'celular_estudiante' => '45987562',
        'celular_padre' =>'85213225',
        'convocatoria_id' => 1,
        'fecha_nacimiento' => $faker->date,
        'ultimo_semestre' => '2023-II',
        'estado_matricula' => 'Matriculado',
        'creditos_matriculados' => 12,
        'num_semestres_cursados' => 6,
        'pps' => 11,
        'ppa' => 11,
        'tca' => 50,
    ];
});

$factory->define(ConvocatoriaServicio::class, function (Faker $faker) {
    return [
        'cantidad' => 240,
    ];
});

$factory->define(Convocatoria::class, function (Faker $faker) {
    return [
        'nombre' => $faker->username,
        'user_id' => 1,
    ];
});

$factory->define(DatosAlumnoAcademico::class, function (Faker $faker) {
    return [
        'username' => $faker->username,
        'email' => $faker->email,
    ];
});

$factory->define(LevelUser::class, function (Faker $faker) {
    return [
        'username' => $faker->username,
        'email' => $faker->email,
    ];
});

$factory->define(Requisito::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'descripcion' => 'descripción',
        'tipo_requisito_id' => 2,
        'seccion_id' => 1,
        'user_id' => 1,
    ];
});

$factory->define(Seccion::class, function (Faker $faker) {
    return [
        'descripcion' => 'descripción',
        'convocatoria_id' => 1,
    ];
});

$factory->define(Solicitud::class, function (Faker $faker) {
    return [
        'convocatoria_id' => 1,
        'alumno_id' => 1,
    ];
});