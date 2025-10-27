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
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');

            // Día y horario
            $table->enum('day_of_week', [
                'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
            ]);
            $table->time('start_time'); // hora inicio (ej: 09:00)
            $table->time('end_time');   // hora fin (ej: 17:00)

            // Opcional: rango de fechas (si el mentor quiere definir una semana específica)
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->boolean('is_recurring')->default(true);
            $table->boolean('active')->default(true);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};
