<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->integer('capacidad_maxima');
            $table->timestamps();
        });
        DB::table('servicios')->insert([
            [
                'descripcion' => 'Residencia',
                'capacidad_maxima' => 175,
            ],
            [
                'descripcion' => 'Comedor',
                'capacidad_maxima' => 200,
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
        Schema::dropIfExists('servicios');
    }
}
