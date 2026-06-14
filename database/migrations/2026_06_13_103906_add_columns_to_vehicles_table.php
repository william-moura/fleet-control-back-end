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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('vehicle_chassis_number')->nullable()->after('vehicle_plate');
            $table->string('vehicle_renavam_number')->nullable()->after('vehicle_chassis_number');
            $table->string('vehicle_color')->nullable()->after('vehicle_renavam_number');
            $table->enum('vehicle_transmission_type', ['manual', 'automatico'])->nullable()->after('vehicle_color');
            $table->integer('vehicle_model_year')->nullable()->after('vehicle_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('vehicle_chassis_number');
            $table->dropColumn('vehicle_renavam_number');
            $table->dropColumn('vechicle_color');
            $table->dropColumn('vehicle_transmission_type');
        });
    }
};
