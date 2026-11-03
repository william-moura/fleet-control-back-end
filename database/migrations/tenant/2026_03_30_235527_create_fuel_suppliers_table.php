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
        Schema::create('fuel_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers', 'id')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreignId('fuel_type_id')->constrained('fuel_types', 'id')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreignId('driver_id')->constrained('drivers', 'id')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreignId('vehicle_id')->constrained('vehicles', 'id')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->decimal('fuel_supplier_price', 10, 2);
            $table->decimal('fuel_supplier_quantity', 10, 3);
            $table->decimal('fuel_supplier_total', 10, 2);
            $table->date('fuel_supplier_date');
            $table->decimal('fuel_supplier_kilometers', 10, 2);
            $table->text('fuel_supplier_notes')->nullable();
            $table->tinyInteger('fuel_supplier_status')->default(1);
            $table->string('fuel_supplier_invoice_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_suppliers');
    }
};
