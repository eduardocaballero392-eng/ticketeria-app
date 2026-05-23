<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipo_ticket', function (Blueprint $table) {
            $table->id('id_tipo_ticket');
            $table->string('nombre', 100);
            $table->string('prefijo', 20)->unique();   // Ej: IMAC, VIVO, SERV, TICK
            $table->string('descripcion', 200)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // ── Datos iniciales ──────────────────────────────────
        DB::table('tipo_ticket')->insert([
            ['nombre' => 'IMAC - Requerimiento', 'prefijo' => 'IMAC', 'descripcion' => 'Instalación, Movimiento, Adición o Cambio de equipo', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'VIVO - Mantenimiento', 'prefijo' => 'VIVO', 'descripcion' => 'Mantenimiento preventivo o correctivo', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'SERVICIO - Solicitud',  'prefijo' => 'SERV', 'descripcion' => 'Solicitud de servicio o recurso TI', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'TICKET - Incidencia',   'prefijo' => 'TICK', 'descripcion' => 'Incidencia que interrumpe el servicio normal', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tipo_ticket');
    }
};  