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
        Schema::create('vehicle_fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles', 'id')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreignId('driver_id')->constrained('drivers', 'id')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->decimal('vehicle_fine_amount', 10, 2);
            $table->date('vehicle_fine_date');
            $table->enum('vehicle_fine_level', ['leve', 'media', 'grave', 'gravissima']);
            $table->decimal('vehicle_fine_points', 10, 2);
            $table->text('vehicle_fine_notes')->nullable();
            $table->tinyInteger('vehicle_fine_status')->default(1);
            $table->date('vehicle_fine_paid_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_fines');
    }
};
