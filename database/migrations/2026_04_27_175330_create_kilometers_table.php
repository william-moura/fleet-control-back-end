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
        Schema::create('kilometers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles', 'id')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreignId('driver_id')->constrained('drivers', 'id')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->decimal('kilometers_value', 10, 2);
            $table->date('kilometers_date')->nullable();     
            $table->text('kilometers_notes')->nullable();
            $table->tinyInteger('kilometers_status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kilometers');
    }
};
