<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStatusData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_data', function (Blueprint $table) {
            $table->id();
            $table->string('description', 50);
            $table->timestamps();
        });
        DB::table('status_data')->insert([
            [
                'description' => 'Eliminado',
            ],
            [
                'description' => 'Desactivado',
            ],
            [
                'description' => 'Activo',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_data');
    }
}
