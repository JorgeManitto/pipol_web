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
        Schema::create('fraccional_time_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('fraccional_contracts')->cascadeOnDelete();
            $table->foreignId('professional_id')->constrained('users');
            $table->date('worked_on');
            $table->decimal('hours', 5, 2);
            $table->text('description');
            $table->timestamps();
            $table->index(['contract_id', 'worked_on']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fraccional_time_entries');
    }
};
