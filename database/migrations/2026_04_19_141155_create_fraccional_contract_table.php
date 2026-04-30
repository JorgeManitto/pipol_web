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
        Schema::create('fraccional_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('engagement_id')
                ->constrained('fraccional_engagements')->cascadeOnDelete();
            $table->text('objectives');
            $table->text('responsibilities');
            $table->text('scope')->nullable();
            $table->unsignedSmallInteger('hours_per_week');
            $table->unsignedSmallInteger('duration_months');
            $table->decimal('monthly_rate', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->decimal('platform_fee_percentage', 5, 2)->default(10.00);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('terms_version')->nullable();
            $table->enum('status', [
                'draft', 'proposed',
                'signed_by_professional', 'signed_by_company',
                'active', 'terminated'
            ])->default('draft');
            $table->timestamp('professional_signed_at')->nullable();
            $table->timestamp('company_signed_at')->nullable();
            $table->timestamp('terms_accepted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fraccional_contract');
    }
};
