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
            $table->string('vechicle_color')->nullable()->after('vehicle_renavam_number');
            $table->enum('vehicle_transmission_type', ['manual', 'automatica'])->nullable()->after('vechicle_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle', function (Blueprint $table) {
            $table->dropColumn('vehicle_chassis_number');
            $table->dropColumn('vehicle_renavam_number');
            $table->dropColumn('vechicle_color');
            $table->dropColumn('vehicle_transmission_type');
        });
    }
};
