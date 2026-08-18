<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('viagens', function (Blueprint $table) {
            $table->string('distancia_Km')->nullable()->after('viagem_odometro_chegada');
            $table->string('tempo_viagem')->nullable()->after('distancia_Km');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('viagens', function (Blueprint $table) {
            $table->dropColumn('distancia_Km');
            $table->dropColumn('tempo_viagem');
        });
    }
};
