<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('accion', ['created', 'deleted']);
            $table->string('modelo')->default('ClassSelection');
            $table->unsignedBigInteger('saved_schedule_id');
            $table->unsignedBigInteger('available_class_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_nombre')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_rol')->nullable();
            $table->json('datos_clase')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('saved_schedule_id',  'idx_audit_schedule');
            $table->index('available_class_id', 'idx_audit_class');
            $table->index('user_id',            'idx_audit_user');
            $table->index('accion',             'idx_audit_accion');
            $table->index('created_at',         'idx_audit_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};