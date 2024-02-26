<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('url_guia');
            $table->string('estado');
            $table->date('fecha_registro');
            $table->unsignedBigInteger('tipo_requisito_id');
            $table->foreign('tipo_requisito_id')
                ->references('id')
                ->on('tipo_requisitos')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('convocatoria_id');
            $table->foreign('convocatoria_id')
                ->references('id')
                ->on('convocatorias')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('seccion_id');
            $table->foreign('seccion_id')
                ->references('id')
                ->on('secciones')
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
        Schema::dropIfExists('requisitos');
    }
}
