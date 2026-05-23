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
    Schema::create('usuario', function (Blueprint $table) {
        $table->id('id_usuario');
        
        // Relación con la tabla cliente
        $table->foreignId('id_cliente')
              ->nullable() // Permite que existan usuarios sin empresa (ej. admins)
              ->constrained('cliente', 'id_cliente') 
              ->onDelete('cascade');

        $table->string('codigo_usuario')->nullable()->unique();
        $table->string('nombre');
        $table->string('apellido_paterno');
        $table->string('apellido_materno');
        $table->string('dni', 15)->unique();
        $table->string('codigo_pais', 6)->default('+51');
        $table->string('telefono', 15)->nullable();
        $table->string('correo')->unique();
        $table->string('contraseña');
        $table->boolean('activo')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
