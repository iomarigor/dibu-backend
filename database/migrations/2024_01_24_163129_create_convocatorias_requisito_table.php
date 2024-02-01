<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvocatoriasRequisitoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convocatoria_requisitos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('convocatoria_id');
            $table->unsignedBigInteger('requisito_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('convocatoria_id')
                ->references('id')
                ->on('convocatorias')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
                
            $table->foreign('requisito_id')
                ->references('id')
                ->on('requisitos')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            
            $table->foreign('status_id')
                ->references('id')
                ->on('status_data')
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
        Schema::dropIfExists('convocatoria_requisito');
    }
}
