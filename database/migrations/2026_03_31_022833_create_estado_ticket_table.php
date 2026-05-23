<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estado_ticket', function (Blueprint $table) {
            $table->id('id_estado');
            $table->string('nombre_estado', 50)->unique();
            $table->string('descripcion', 200)->nullable();
            $table->unsignedTinyInteger('orden');   // para ordenar el flujo visual
            $table->boolean('es_final')->default(false);   // true = CERRADO/CANCELADO
            $table->string('color_hex', 7)->default('#6b7280');
            $table->timestamps();
        });

        // ── Datos iniciales ──────────────────────────────────
        DB::table('estado_ticket')->insert([
            ['nombre_estado' => 'PENDIENTE',   'descripcion' => 'Ticket registrado, esperando asignación', 'orden' => 1, 'es_final' => false, 'color_hex' => '#7c3aed', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_estado' => 'PROGRAMADO',  'descripcion' => 'Asignado a técnico con fecha programada',  'orden' => 2, 'es_final' => false, 'color_hex' => '#3b82f6', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_estado' => 'EN PROCESO',  'descripcion' => 'Técnico trabajando en la incidencia',      'orden' => 3, 'es_final' => false, 'color_hex' => '#f59e0b', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_estado' => 'CERRADO',     'descripcion' => 'Ticket resuelto y cerrado',                'orden' => 4, 'es_final' => true,  'color_hex' => '#22c55e', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_estado' => 'CANCELADO',   'descripcion' => 'Ticket cancelado por el cliente o admin',  'orden' => 5, 'es_final' => true,  'color_hex' => '#ef4444', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('estado_ticket');
    }
};