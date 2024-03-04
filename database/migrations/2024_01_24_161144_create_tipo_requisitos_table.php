<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTipoRequisitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_requisitos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion_tipo');
            $table->timestamps();
        });
        DB::table('tipo_requisitos')->insert([
            [
                'id' => 1,
                'descripcion_tipo' => 'Documento'
            ],
            [
                'id' => 2,
                'descripcion_tipo' => 'Imagen'
            ],
            [
                'id' => 3,
                'descripcion_tipo' => 'Formulario'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_requisitos');
    }
}
