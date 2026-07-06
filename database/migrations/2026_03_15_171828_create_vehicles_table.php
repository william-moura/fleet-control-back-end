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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_plate');
            $table->foreignId('brand_id')->constrained('vehicle_brands', 'id')
            ->onDelete('restrict')
            ->onUpdate('cascade');
            $table->string('vehicle_model');
            $table->string('vehicle_year');
            $table->foreignId('fuel_type_id')->constrained('fuel_types', 'id')
            ->onDelete('restrict')
            ->onUpdate('cascade');
            $table->decimal('vehicle_tank_capacity', 10, 2)->nullable();
            $table->decimal('vehicle_current_mileage', 10, 2)->nullable();
            $table->tinyInteger('vehicle_status')->default(1);
            $table->date('vehicle_purchase_date')->nullable();
            $table->text('vehicle_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
