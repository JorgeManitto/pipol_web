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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('origin', ['mentoria', 'fraccional'])
                  ->default('mentoria')
                  ->after('role');
            $table->index('origin');
        });

        // Backfill: todos los usuarios existentes vienen de mentoría
        DB::table('users')->update(['origin' => 'mentoria']);
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('origin');
        });
    }
};
