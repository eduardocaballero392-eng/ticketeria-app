<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoTicketSeeder extends Seeder
{
    public function run()
    {
        $tickets = [
            [
                'nombre'      => 'Soporte Técnico General (PC, Laptop, Mac, Móviles)',
                'descripcion' => 'Mantenimiento preventivo/correctivo, optimización drástica de rendimiento, formateo con respaldo, solución de hardware/software y soporte multimarca especializado (incluye Apple e iOS/macOS).',
                'prefijo'     => 'SOP',
                'activo'      => 1
            ],
            [
                'nombre'      => 'Instalación de Redes y Wi-Fi',
                'descripcion' => 'Diseño e implementación de cableado estructurado, ampliación de cobertura inalámbrica, configuración profesional de routers, switches, repetidores y optimización de conectividad.',
                'prefijo'     => 'RED',
                'activo'      => 1
            ],
            [
                'nombre'      => 'Cámaras de Seguridad',
                'descripcion' => 'Venta, diseño de planos de cobertura, cableado estructurado, montaje de cámaras fijas/PTZ, configuración de grabadores DVR/NVR y puesta en marcha del sistema de videovigilancia local y remoto.',
                'prefijo'     => 'CAM',
                'activo'      => 1
            ],
            [
                'nombre'      => 'Recuperación de Datos',
                'descripcion' => 'Asistencia técnica de emergencia para el rescate, diagnóstico y recuperación de archivos, fotos, documentos o bases de datos dañadas o eliminadas.', // 👈 Completé el texto cortado
                'prefijo'     => 'REC',
                'activo'      => 1
            ],
        ];

        // Inserta solo si no existe (evita duplicados al correrlo varias veces)
        foreach ($tickets as $ticket) {
            DB::table('tipo_ticket')->updateOrInsert(
                ['prefijo' => $ticket['prefijo']], // Clave para buscar
                $ticket                          // Datos a insertar/actualizar
            );
        }
    }
}