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
       Schema::create('evidencia', function (Blueprint $table) {
    $table->id('id_evidencia');

    $table->foreignId('id_ticket')
        ->references('id_ticket')->on('ticket')
        ->cascadeOnDelete();

    $table->string('ruta_archivo')->nullable();
    $table->string('nombre_original')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencia');
    }
};
