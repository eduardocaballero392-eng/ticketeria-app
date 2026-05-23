<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reporte_tecnico', function (Blueprint $table) {
            $table->id('id_reporte');

            $table->foreignId('id_ticket')
                ->unique()
                ->constrained('ticket', 'id_ticket')
                ->cascadeOnDelete();

            $table->foreignId('id_tecnico')
                ->constrained('tecnico', 'id_tecnico')
                ->restrictOnDelete();

            // Archivo PDF, imagen o documento
            $table->string('archivo_reporte');

            // Nombre original del archivo
            $table->string('nombre_original')->nullable();

            // Fecha de cierre
            $table->timestamp('fecha_cierre')->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reporte_tecnico');
    }
};