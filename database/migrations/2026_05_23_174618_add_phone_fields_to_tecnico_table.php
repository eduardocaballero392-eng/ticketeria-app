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
        Schema::table('tecnico', function (Blueprint $table) {
            // Agregar columna 'telefono' si no existe
            if (!Schema::hasColumn('tecnico', 'telefono')) {
                $table->string('telefono', 20)->nullable()->after('correo');
            }
            
            // Agregar columna 'codigo_pais' si no existe
            if (!Schema::hasColumn('tecnico', 'codigo_pais')) {
                $table->string('codigo_pais', 10)->default('+51')->after('telefono');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tecnico', function (Blueprint $table) {
            // Eliminar las columnas si se revierte la migración
            $table->dropColumn(['telefono', 'codigo_pais']);
        });
    }
};