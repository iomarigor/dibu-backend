<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('servicio_solicitado');
            $table->string('codigo_estudiante');
            $table->string('DNI');
            $table->string('nombre_solicitante');
            $table->string('apellido_solicitante');
            $table->string('sexo');
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
            $table->unsignedBigInteger('convocatoria_id');
            $table->timestamps();
            
            $table->foreign('convocatoria_id')
                ->references('id')
                ->on('convocatorias')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitud');
    }
}
