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
            $table->string('prefijo', 20)->unique();
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // ── Datos iniciales ──────────────────────────────────
        DB::table('tipo_ticket')->insert([
            [
                'nombre' => 'Soporte Técnico General (PC, Laptop, Mac, Móviles)',
                'prefijo' => 'SOP',
                'descripcion' => 'Mantenimiento preventivo/correctivo, optimización drástica de rendimiento, formateo con respaldo, solución de hardware/software y soporte multimarca especializado (incluye Apple e iOS/macOS).',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Instalación de Redes y Wi-Fi',
                'prefijo' => 'RED',
                'descripcion' => 'Diseño e implementación de cableado estructurado, ampliación de cobertura inalámbrica, configuración profesional de routers, switches, repetidores y optimización de conectividad.',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Cámaras de Seguridad',
                'prefijo' => 'CAM',
                'descripcion' => 'Venta, diseño de planos de cobertura, cableado estructurado, montaje de cámaras fijas/PTZ, configuración de grabadores DVR/NVR y puesta en marcha del sistema de videovigilancia local y remoto.',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Recuperación de Datos',
                'prefijo' => 'REC',
                'descripcion' => 'Asistencia técnica de emergencia para el rescate, diagnóstico y recuperación de archivos, fotos, documentos o bases de datos dañadas o eliminadas.',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tipo_ticket');
    }
};