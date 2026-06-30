<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('available_classes', function (Blueprint $table) {
            $table->unique(['teacher_id', 'time_slot_id', 'semester_id'], 'available_classes_teacher_time_slot_unique');
            $table->unique(['classroom_id', 'time_slot_id', 'semester_id'], 'available_classes_classroom_time_slot_unique');
            $table->unique(['group_id', 'time_slot_id', 'semester_id'], 'available_classes_group_time_slot_unique');
        });
    }

    public function down(): void
    {
        Schema::table('available_classes', function (Blueprint $table) {
            $table->dropUnique('available_classes_teacher_time_slot_unique');
            $table->dropUnique('available_classes_classroom_time_slot_unique');
            $table->dropUnique('available_classes_group_time_slot_unique');
        });
    }
};
