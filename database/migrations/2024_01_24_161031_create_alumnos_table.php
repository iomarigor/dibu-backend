<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_estudiante');
            $table->string('DNI');
            $table->string('nombres');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('sexo');
            $table->string('facultad');
            $table->string('escuela_profesional');
            $table->string('modalidad_ingreso');
            $table->string('lugar_procedencia')->nullable();
            $table->string('lugar_nacimiento')->nullable();
            $table->integer('edad');
            $table->string('correo_institucional');
            $table->string('direccion');
            $table->date('fecha_nacimiento');
            $table->string('correo_personal');
            $table->string('celular_estudiante');
            $table->string('celular_padre');
            $table->unsignedBigInteger('convocatoria_id')->nullable();
            $table->foreign('convocatoria_id')->references('id')->on('convocatorias');
            $table->timestamps();
        });
        DB::table('alumnos')->insert([
            [
                'codigo_estudiante' => '20170890',
                'DNI' => '10439823',
                'nombres' => 'Ruth',
                'apellido_paterno' => 'Jara',
                'apellido_materno' => 'Montenegro',
                'sexo' => 'Femenino',
                'facultad' => 'Industrias Alimentarias',
                'escuela_profesional' => 'Industrias Alimentarias',
                'modalidad_ingreso' => 'CEPRE',
                'lugar_procedencia' => 'Lima',
                'lugar_nacimiento' => 'La Perla',
                'edad' => 23,
                'correo_institucional' => 'ruth.jara@unas.edu.pe',
                'direccion' => 'av. juanjaime',
                'fecha_nacimiento' => '2001-03-21',
                'correo_personal' => 'ruth@ruth.com',
                'celular_estudiante' => '987654321',
                'celular_padre' => '987456321',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumnos');
    }
}
