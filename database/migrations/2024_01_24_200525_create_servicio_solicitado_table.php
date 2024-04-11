<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioSolicitadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_solicitado', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->date('fecha_revision')->nullable();
            $table->unsignedBigInteger('servicio_id');
            $table->foreign('servicio_id')
                ->references('id')
                ->on('servicios');
            $table->unsignedBigInteger('solicitud_id');
            $table->foreign('solicitud_id')
                ->references('id')
                ->on('solicitudes');
            $table->string('detalle_rechazo')->nullable();
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
        Schema::dropIfExists('servicio_solicitado');
    }
}
