<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentario', function (Blueprint $table) {
            $table->id('id_comentario');

            $table->foreignId('id_ticket')
                ->constrained('ticket', 'id_ticket')
                ->cascadeOnDelete();

            $table->foreignId('id_tecnico')
                ->constrained('tecnico', 'id_tecnico')
                ->restrictOnDelete();

            $table->text('comentario');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentario');
    }
};