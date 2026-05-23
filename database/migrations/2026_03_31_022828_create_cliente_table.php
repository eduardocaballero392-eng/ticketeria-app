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
    Schema::create('cliente', function (Blueprint $table) {
    $table->id('id_cliente');
        $table->string('razon_social');
        $table->string('ruc', 11)->unique();
        $table->string('sedes');
        $table->string('rubro');
        $table->string('correo')->unique();
        $table->string('contraseña');
        $table->boolean('activo')->default(1);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
