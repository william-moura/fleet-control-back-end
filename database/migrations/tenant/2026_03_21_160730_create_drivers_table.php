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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('driver_name');
            $table->string('driver_registered_number');
            $table->string('driver_address');
            $table->string('driver_city');
            $table->string('driver_state', 2);
            $table->string('driver_zip_code')->length(9);
            $table->string('driver_blood_type', 4);
            $table->string('driver_rg')->length(11);
            $table->string('driver_cpf')->length(11);
            $table->string('driver_license_number');
            $table->date('driver_license_expiration_date');
            $table->string('driver_license_category', 3);
            $table->date('driver_birth_date');
            $table->string('driver_phone')->length(15);
            $table->tinyInteger('driver_status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
