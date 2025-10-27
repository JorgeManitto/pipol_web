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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('session_id')->nullable()->constrained('pipol_sessions')->onDelete('set null');
            $table->foreignId('payer_id')->nullable()->constrained('users')->onDelete('set null'); // normalmente el mentee
            $table->foreignId('receiver_id')->nullable()->constrained('users')->onDelete('set null'); // mentor o plataforma

            // Información del pago
            $table->string('gateway')->nullable(); // 'stripe', 'mercadopago', 'paypal', 'manual'
            $table->string('gateway_transaction_id')->nullable();
            $table->string('currency', 3)->default('USD');
            $table->decimal('amount', 10, 2); // monto total cobrado
            $table->decimal('platform_fee', 10, 2)->default(0.00); // comisión de Pipol
            $table->decimal('mentor_earnings', 10, 2)->nullable(); // monto neto para el mentor

            // Estado
            $table->enum('status', ['pending', 'paid', 'refunded', 'failed'])->default('pending');
            $table->text('notes')->nullable(); // observaciones o errores del gateway
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
