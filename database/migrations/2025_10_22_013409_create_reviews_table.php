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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('session_id')->constrained('pipol_sessions')->onDelete('cascade');
            $table->foreignId('mentee_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');

            // Contenido
            $table->tinyInteger('rating')->comment('1–5');
            $table->text('comment')->nullable();

            // Estado
            $table->boolean('visible')->default(true); // permitir ocultar si hay disputa

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
