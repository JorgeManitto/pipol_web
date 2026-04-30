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
        Schema::create('fraccional_diagnostics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('users')->cascadeOnDelete();
            $table->text('problem');
            $table->string('size');
            $table->string('industry');
            $table->string('urgency');
            $table->string('stage');
            $table->string('ai_role')->nullable();
            $table->string('ai_problem')->nullable();
            $table->string('ai_impact')->nullable();
            $table->string('ai_hours')->nullable();
            $table->json('ai_insights')->nullable();
            $table->string('ai_match_count')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fraccional_diagnostic');
    }
};
