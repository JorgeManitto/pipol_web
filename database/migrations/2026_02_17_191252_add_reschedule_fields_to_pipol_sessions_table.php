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
         Schema::table('pipol_sessions', function (Blueprint $table) {
            $table->boolean('reschedule_pending')->default(false);
            $table->timestamp('original_scheduled_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pipol_sessions', function (Blueprint $table) {
            $table->dropColumn(['reschedule_pending', 'original_scheduled_at']);
        });
    }
};
