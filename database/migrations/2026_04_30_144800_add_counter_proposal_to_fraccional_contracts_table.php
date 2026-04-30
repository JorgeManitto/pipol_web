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
        Schema::table('fraccional_contracts', function (Blueprint $table) {
            $table->unsignedSmallInteger('version')->default(1)->after('terms_version');
            $table->foreignId('last_proposed_by')->nullable()->after('version')->constrained('users')->nullOnDelete();
            $table->timestamp('last_proposed_at')->nullable()->after('last_proposed_by');
            $table->text('counter_proposal_note')->nullable()->after('last_proposed_at');

            // Histórico de versiones (para que ambos puedan ver la evolución)
            $table->json('proposal_history')->nullable()->after('counter_proposal_note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fraccional_contracts', function (Blueprint $table) {
            //
        });
    }
};
