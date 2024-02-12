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
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('id_servicio_solicitado');
            $table->timestamps();
            
            $table->foreign('convocatoria_id')
                ->references('id')
                ->on('convocatorias')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
                
            $table->foreign('alumno_id')
                ->references('id')
                ->on('alumnos')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            
            $table->foreign('id_servicio_solicitado')
                ->references('id')
                ->on('servicio_solicitado')
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
