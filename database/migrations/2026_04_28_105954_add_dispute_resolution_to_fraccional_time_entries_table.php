<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fraccional_time_entries', function (Blueprint $table) {
            // Evidencia subida por la empresa
            $table->json('evidence_files')->nullable()->after('disputed_at');

            // Respuesta del profesional a la evidencia
            $table->text('professional_response')->nullable()->after('evidence_files');
            $table->boolean('professional_accepted_evidence')->nullable()->after('professional_response');
            $table->timestamp('professional_responded_at')->nullable()->after('professional_accepted_evidence');

            // Mediación admin
            $table->foreignId('mediator_id')->nullable()->after('professional_responded_at')->constrained('users')->nullOnDelete();
            $table->text('mediation_notes')->nullable()->after('mediator_id');
            $table->enum('mediation_outcome', ['company','professional','partial'])->nullable()->after('mediation_notes');
            $table->decimal('approved_hours_after_mediation', 5, 2)->nullable()->after('mediation_outcome');
            $table->timestamp('mediated_at')->nullable()->after('approved_hours_after_mediation');
        });
        // Nota sobre el enum status: en MySQL cambialo así
        DB::statement("ALTER TABLE fraccional_time_entries MODIFY COLUMN status ENUM(
            'pending', 'approved', 'auto_approved', 'disputed',
            'evidence_submitted', 'in_mediation',
            'resolved_company', 'resolved_professional', 'resolved_partial'
        ) DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fraccional_time_entries', function (Blueprint $table) {
            //
        });
    }
};
