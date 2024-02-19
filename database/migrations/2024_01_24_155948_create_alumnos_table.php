<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->string('nombre');
            $table->string('apellido');
            $table->string('sexo');
            $table->string('facultad');
            $table->string('escuela_profesional');
            $table->string('modalidad_ingreso');
            $table->string('lugar_procedencia');
            $table->string('lugar_nacimiento');
            $table->integer('edad');
            $table->string('correo_institucional');
            $table->string('direccion');
            $table->date('fecha_nacimiento');
            $table->string('correo_personal');
            $table->string('celular_estudiante');
            $table->string('celular_padre');
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
