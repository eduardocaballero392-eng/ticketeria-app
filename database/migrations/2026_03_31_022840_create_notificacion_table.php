<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificacion', function (Blueprint $table) {
            $table->id('id_notificacion');

            // 👇 AHORA ES PARA CLIENTE
            $table->foreignId('id_cliente')
                  ->references('id_cliente')
                  ->on('cliente')
                  ->cascadeOnDelete();

            // Relación con ticket (obligatoria en tu caso)
            $table->foreignId('id_ticket')
                  ->references('id_ticket')
                  ->on('ticket')
                  ->cascadeOnDelete();

            // (Opcional pero PRO 🔥)
            $table->foreignId('id_estado')
                  ->nullable()
                  ->references('id_estado')
                  ->on('estado_ticket')
                  ->nullOnDelete();

            $table->string('mensaje');
            $table->boolean('leido')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacion');
    }
};