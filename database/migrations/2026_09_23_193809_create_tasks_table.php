<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Información de la tarea
            $table->string('title');
            $table->text('description')->nullable();

            // Estado de la tarea
            $table->string('status')->default('por hacer');

            // Equipo al que pertenece la tarea
            $table->foreignId('team_id')
                ->constrained()
                ->cascadeOnDelete();

            // Usuario que creó la tarea
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            // Usuario al que se asignó la tarea (opcional)
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Fecha en la que se asignó
            $table->timestamp('assigned_at')->nullable();

            // Fecha límite de entrega
            $table->date('due_date')->nullable();

            // Tiempo estimado de desarrollo
            $table->unsignedInteger('estimated_time')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};