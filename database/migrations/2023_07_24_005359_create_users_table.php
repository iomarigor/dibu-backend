<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 191)->nullable();
            $table->string('full_name');
            $table->string('email', 191)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('ip_address')->nullable();
            $table->unsignedBigInteger('id_level_user')->nullable();
            $table->foreign('id_level_user')->references('id')->on('level_user');
            $table->unsignedBigInteger('last_user')->nullable();
            $table->foreign('last_user')->references('id')->on('users');
            $table->rememberToken();
            $table->unsignedBigInteger('status_id')->default(3); // Valor predeterminado: Activo
            $table->foreign('status_id')->references('id')->on('status_data');

            $table->timestamps();
        });

        DB::table('users')->insert([
            'username' => 'admin',
            'full_name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'id_level_user' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
