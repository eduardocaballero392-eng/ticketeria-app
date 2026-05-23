<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('tecnico', function (Blueprint $table) {
        $table->id('id_tecnico'); // Cambiado de id_usuario
        $table->string('codigo_tecnico', 10)->nullable()->unique();
        $table->string('nombre');
        $table->string('apellido_paterno');
        $table->string('apellido_materno')->nullable();
        $table->string('dni', 8)->unique();
        $table->string('correo')->unique();
        $table->string('contraseña');
        $table->foreignId('id_cargo')
            ->constrained('cargo', 'id_cargo')
            ->onDelete('restrict');
        $table->boolean('activo')->default(true);
        $table->rememberToken();
        $table->timestamps();
    });

    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS generar_codigo_tecnico');
        Schema::dropIfExists('tecnico');
    }
};
    
