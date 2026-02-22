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
        Schema::create('pipol_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mentee_id')->constrained('users')->onDelete('cascade');

            // Detalle de sesión
            $table->timestamp('scheduled_at')->nullable(); // fecha/hora
            $table->integer('duration_minutes')->default(60);
            $table->text('details')->nullable(); // descripción de necesidad

            // Estado
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])
                ->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])
                ->default('unpaid');

            // Precios y pagos
            $table->decimal('price', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->string('payment_method')->nullable(); // 'stripe', 'paypal', 'manual'
            $table->string('transaction_id')->nullable(); // id en gateway
            $table->string('calendly_event_id')->nullable();

            // Feedback o cierre
            $table->timestamp('completed_at')->nullable();
            $table->boolean('mentor_confirmed')->default(false);
            $table->boolean('mentee_confirmed')->default(false);

            // $table->boolean('reschedule_pending')->default(false);
            // $table->timestamp('original_scheduled_at')->nullable();
       

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pipol_sessions');
    }
};
