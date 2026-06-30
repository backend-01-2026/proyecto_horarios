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
        Schema::create('class_selections', function (Blueprint $table) {
            $table->foreignId('saved_schedule_id')->constrained('saved_schedules')->cascadeOnDelete();
            $table->foreignId('available_class_id')->constrained('available_classes')->cascadeOnDelete();
            $table->primary(['saved_schedule_id', 'available_class_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_selections');
    }
};
