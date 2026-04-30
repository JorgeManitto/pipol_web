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
       Schema::table('fraccional_time_entries', function (Blueprint $table) {
            $table->enum('status', [
                'pending',         // recién cargada, esperando review
                'approved',        // aprobada por la empresa
                'auto_approved',   // pasaron 72hs sin respuesta
                'disputed',        // empresa abrió reclamo
            ])->default('pending')->after('description');

            $table->timestamp('review_deadline_at')->nullable()->after('status');
            $table->timestamp('reviewed_at')->nullable()->after('review_deadline_at');
            $table->foreignId('reviewed_by')->nullable()->after('reviewed_at')->constrained('users')->nullOnDelete();

            $table->text('dispute_reason')->nullable()->after('reviewed_by');
            $table->timestamp('disputed_at')->nullable()->after('dispute_reason');

            $table->index(['status', 'review_deadline_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
