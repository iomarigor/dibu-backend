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
            $table->date('fecha_solicitud');
            $table->unsignedBigInteger('convocatoria_id');
            $table->foreign('convocatoria_id')
                ->references('id')
                ->on('convocatorias');

            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')
                ->references('id')
                ->on('alumnos');

            $table->unsignedBigInteger('servicio_solicitado_id');
            $table->foreign('servicio_solicitado_id')
                ->references('id')
                ->on('servicio_solicitado');

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
        Schema::dropIfExists('solicitudes');
    }
}
