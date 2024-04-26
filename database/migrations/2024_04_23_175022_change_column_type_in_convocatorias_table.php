<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTypeInConvocatoriasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('convocatorias', function (Blueprint $table) {
            DB::statement("ALTER TABLE convocatorias MODIFY fecha_inicio DATETIME;");
            DB::statement("ALTER TABLE convocatorias MODIFY fecha_fin DATETIME;");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('convocatorias', function (Blueprint $table) {
            DB::statement("ALTER TABLE convocatorias MODIFY fecha_inicio VARCHAR(255);");
            DB::statement("ALTER TABLE convocatorias MODIFY fecha_fin VARCHAR(255);");
        });
    }
}
