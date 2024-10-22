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
            $table->string('ultimo_semestre');
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
            $table->string('estado_matricula');
            $table->string('creditos_matriculados');
            $table->string('num_semestres_cursados');
            $table->string('pps');
            $table->string('ppa');
            $table->string('tca');
            $table->unsignedBigInteger('convocatoria_id');
            $table->foreign('convocatoria_id')->references('id')->on('convocatorias');
            $table->timestamps();
        });
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
