<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('viagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->foreignId('driver_id')->constrained('drivers');
            $table->dateTime('viagem_data_hora_saida');
            $table->dateTime('viagem_data_hora_chegada')->nullable();
            $table->unsignedInteger('viagem_odometro_saida');
            $table->unsignedInteger('viagem_odometro_chegada')->nullable();
            $table->string('viagem_endereco_origem');
            $table->string('viagem_endereco_destino');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('viagens');
    }
};
