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
        Schema::create('price_guidelines', function (Blueprint $table) {
            $table->id();

            // Categoría o nivel de experiencia
            $table->string('level'); // ej: 'Junior', 'Semi Senior', 'Senior', 'Executive'
            $table->string('industry')->nullable(); // ej: 'Marketing', 'Tecnología', etc.

            // Rangos
            $table->decimal('min_price', 10, 2)->nullable();
            $table->decimal('max_price', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');

            // Notas
            $table->text('description')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_guidelines');
    }
};
