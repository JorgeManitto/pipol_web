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
        Schema::table('fraccional_messages', function (Blueprint $table) {
            $table->enum('type', ['text', 'system'])->default('text')->after('sender_id');
            $table->json('meta')->nullable()->after('body');
            $table->foreignId('sender_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fraccional_messages', function (Blueprint $table) {
            //
        });
    }
};
