<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('respuesta_formulario')->nullable();
            $table->string('url_documento')->nullable();
            $table->string('opcion_seleccion')->nullable();
            $table->unsignedBigInteger('solicitud_id');
            $table->foreign('solicitud_id')
                ->references('id')
                ->on('solicitudes')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('requisito_id');
            $table->foreign('requisito_id')
                ->references('id')
                ->on('requisitos')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

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
        Schema::dropIfExists('detalle_solicitudes');
    }
}
