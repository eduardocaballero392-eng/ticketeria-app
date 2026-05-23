<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prioridad', function (Blueprint $table) {
            $table->id('id_prioridad');
            $table->string('nombre', 50)->unique();
            $table->string('descripcion', 200)->nullable();
            $table->unsignedTinyInteger('nivel')->unique(); // 1=más urgente
            $table->string('color_hex', 7)->default('#6b7280'); // para UI
            $table->timestamps();
        });

        // ── Datos iniciales ──────────────────────────────────
        DB::table('prioridad')->insert([
            ['nombre' => 'ALTA',  'descripcion' => 'No puedo trabajar, equipo no prende',  'nivel' => 1, 'color_hex' => '#ef4444', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'MEDIA', 'descripcion' => 'Afecta parcialmente mi trabajo',        'nivel' => 2, 'color_hex' => '#f59e0b', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'BAJA',  'descripcion' => 'Consulta o mejora menor',               'nivel' => 3, 'color_hex' => '#22c55e', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('prioridad');
    }
};