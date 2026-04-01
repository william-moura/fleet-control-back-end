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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_fantasy_name');
            $table->string('supplier_corporate_name');
            $table->string('supplier_cnpj');
            $table->string('supplier_ie')->nullable();
            $table->string('supplier_address')->nullable();
            $table->string('supplier_number')->nullable();
            $table->string('supplier_complement')->nullable();
            $table->string('supplier_neighborhood')->nullable();
            $table->string('supplier_city')->nullable();
            $table->string('supplier_state')->nullable();
            $table->string('supplier_zip_code')->length(9);
            $table->string('supplier_phone')->length(15)->nullable();
            $table->string('supplier_email')->nullable();
            $table->tinyInteger('supplier_status')->default(1);
            $table->text('supplier_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier');
    }
};
