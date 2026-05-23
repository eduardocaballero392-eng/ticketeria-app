<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cargo', function (Blueprint $table) {
            $table->id('id_cargo');
            $table->string('nombre_cargo')->unique();
            $table->boolean('puede_asignar_tecnico')->default(false);
            $table->boolean('puede_cerrar_ticket')->default(false);
            $table->boolean('puede_crear_ticket')->default(true);   // nuevo
            $table->boolean('puede_ver_todos_tickets')->default(false);
            $table->timestamps();
        });

        DB::table('cargo')->insert([
            [
                'nombre_cargo' => 'Administrador',
                'puede_asignar_tecnico' => true,
                'puede_cerrar_ticket' => true,
                'puede_crear_ticket' => true,
                'puede_ver_todos_tickets' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre_cargo' => 'Técnico',
                'puede_asignar_tecnico' => false,
                'puede_cerrar_ticket' => true,
                'puede_crear_ticket' => false,
                'puede_ver_todos_tickets' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('cargo');
    }
};