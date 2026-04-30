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
        Schema::create('fraccional_engagements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnostic_id')->nullable()
                ->constrained('fraccional_diagnostics')->nullOnDelete();
            $table->foreignId('company_id')->constrained('users');
            $table->foreignId('professional_id')->constrained('users');
            $table->string('role_requested')->nullable();
            $table->text('initial_message')->nullable();
            $table->enum('status', [
                'pending', 'accepted', 'rejected',
                'negotiating', 'proposed', 'confirmed',
                'active', 'completed', 'cancelled',
            ])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            $table->index(['company_id', 'status']);
            $table->index(['professional_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fraccional_engagement');
    }
};
