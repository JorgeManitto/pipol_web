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
        Schema::create('fraccional_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('fraccional_contracts');
            $table->foreignId('engagement_id')->constrained('fraccional_engagements');
            $table->foreignId('company_id')->constrained('users');
            $table->foreignId('professional_id')->constrained('users');
            $table->decimal('amount', 10, 2);
            $table->decimal('platform_fee', 10, 2);
            $table->decimal('professional_amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('stripe_payment_intent_id')->nullable()->index();
            $table->string('stripe_charge_id')->nullable();
            $table->string('stripe_transfer_id')->nullable();
            $table->enum('status', [
                'pending', 'paid', 'held', 'released', 'refunded', 'failed'
            ])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fraccional_transaction');
    }
};
