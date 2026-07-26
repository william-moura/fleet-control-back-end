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
        Schema::create('prefeituras', function (Blueprint $table) {
            $table->id();
            $table->string('prefeitura_razao_social')->nullable();
            $table->string('prefeitura_nome_fantasia')->nullable();
            $table->string('prefeitura_cnpj')->nullable();
            $table->string('prefeitura_address')->nullable();
            $table->string('prefeitura_city')->nullable();
            $table->string('prefeitura_state')->nullable();
            $table->string('prefeitura_zip_code')->nullable();
            $table->string('prefeitura_phone')->nullable();
            $table->string('prefeitura_email')->nullable();
            $table->string('prefeitura_website')->nullable();
            $table->enum('prefeitura_status', ['active', 'inactive'])->default('active');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prefeituras');
    }
};
