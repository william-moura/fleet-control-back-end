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
        Schema::create('secretarias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orgao_id')->constrained('orgaos');
            $table->string('secretaria_name')->nullable();
            $table->string('secretaria_email')->nullable();
            $table->string('secretaria_responsible_name')->nullable();
            $table->string('secretaria_description')->nullable();
            $table->string('secretaria_sigla')->nullable();
            $table->enum('secretaria_status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secretarias');
    }
};
