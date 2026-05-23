<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->id('id_ticket');
            $table->string('codigo_ticket', 40)->unique();

            /* ── RELACIONES PRINCIPALES ── */
            
            // 1. La Empresa (Para saber a quién facturar/reportar)
            $table->foreignId('id_cliente')
                  ->constrained('cliente', 'id_cliente')
                  ->restrictOnDelete();

            // 2. El Usuario (La persona específica de esa empresa que reporta)
            $table->foreignId('id_usuario')
                  ->constrained('usuario', 'id_usuario')
                  ->restrictOnDelete();

            // 3. El Técnico (Personal interno que resuelve)
            $table->foreignId('id_tecnico_asignado')
                  ->nullable()
                  ->constrained('tecnico', 'id_tecnico')
                  ->nullOnDelete();

            /* ── CATÁLOGOS ── */
            $table->foreignId('id_tipo_ticket')
                  ->constrained('tipo_ticket', 'id_tipo_ticket')
                  ->restrictOnDelete();

            $table->foreignId('id_prioridad')
                  ->constrained('prioridad', 'id_prioridad')
                  ->restrictOnDelete();

            $table->foreignId('id_estado')
                  ->default(1) // PENDIENTE
                  ->constrained('estado_ticket', 'id_estado')
                  ->restrictOnDelete();

            /* ── DETALLES ── */
            $table->string('tipo_equipo', 50)->nullable();
            $table->string('marca', 60)->nullable();
            $table->string('modelo', 100)->nullable();
            $table->string('serie_serial', 100)->nullable();
            $table->string('asunto', 200);
            $table->text('problema');

            /* ── TIEMPOS ── */
            $table->timestamp('fecha_programado')->nullable();
            $table->timestamp('fecha_en_proceso')->nullable();
            $table->timestamp('fecha_resuelto')->nullable();
            $table->timestamps();

            /* ── ÍNDICES ── */
            $table->index('id_cliente');
            $table->index('id_usuario'); 
            $table->index('id_tecnico_asignado');
            $table->index('id_estado');
            $table->index('id_prioridad');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket');
    }
};