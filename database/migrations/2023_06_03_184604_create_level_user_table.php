<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLevelUserTable extends Migration
{
    public function up()
    {
        Schema::create('level_user', function (Blueprint $table) {
            $table->id();
            $table->string('description', 50);
            $table->timestamps();
        });
        DB::table('level_user')->insert([
            ['description' => 'ADMINISTRADOR'],
            ['description' => 'USUARIO'],
            ['description' => 'COLABORADOR'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('level_user');
    }
}
