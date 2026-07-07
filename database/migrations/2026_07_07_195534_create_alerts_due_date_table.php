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
        Schema::create('alerts_due_date', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->date('due_date');
            $table->string('status')->default('pending');
            $table->morphs('alertable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts_due_date');
    }
};
