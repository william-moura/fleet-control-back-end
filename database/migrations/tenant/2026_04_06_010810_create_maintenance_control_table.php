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
        Schema::create('maintenance_control', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles', 'id')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            // $table->foreignId('maintenance_control_type_id')->constrained('maintenance_control_types', 'id')
            //     ->onDelete('restrict')
            //     ->onUpdate('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers', 'id')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->date('maintenance_control_date');
            $table->decimal('maintenance_control_kilometers', 10, 2);
            $table->text('maintenance_control_description')->nullable();
            $table->decimal('maintenance_control_total_cost', 10, 2);
            $table->text('maintenance_control_notes')->nullable();
            $table->date('maintenance_control_next_date')->nullable();
            $table->decimal('maintenance_control_next_kilometers', 10, 2)->nullable();
            $table->tinyInteger('maintenance_control_status')->default(1);
            $table->date('maintenance_control_previous_date_finished')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_control');
    }
};
