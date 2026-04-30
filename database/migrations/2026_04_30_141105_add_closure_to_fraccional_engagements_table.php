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
        Schema::table('fraccional_engagements', function (Blueprint $table) {
            $table->enum('closure_choice', [
                'continue',         // Quiere seguir con este profesional
                'find_similar',     // Busca otro perfil similar
                'refund',           // Quiere devolución del dinero
                'finished',         // Cerró sin más acción
            ])->nullable()->after('cancelled_at');
            $table->json('closure_input')->nullable()->after('closure_choice');
            $table->timestamp('closed_at')->nullable()->after('closure_input');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fraccional_engagements', function (Blueprint $table) {
            //
        });
    }
};
