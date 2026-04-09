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
        Schema::create('maintenance_relation_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_control_id')->constrained('maintenance_control', 'id')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreignId('maintenance_service_id')->constrained('maintenance_control_services', 'id')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->decimal('maintenance_control_relation_service_price', 10, 2)->nullable();
            $table->decimal('maintenance_control_relation_service_quantity', 10, 3)->nullable();
            $table->decimal('maintenance_control_relation_service_total', 10, 2)->nullable();
            $table->text('maintenance_control_relation_service_notes')->nullable();
            $table->tinyInteger('maintenance_control_relation_service_status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_control_relation_services');
    }
};
