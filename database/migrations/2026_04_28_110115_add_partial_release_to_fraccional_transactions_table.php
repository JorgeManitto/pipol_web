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
        Schema::table('fraccional_transactions', function (Blueprint $table) {
            $table->decimal('released_amount', 10, 2)->nullable()->after('professional_amount');
            $table->decimal('retained_amount', 10, 2)->nullable()->after('released_amount');
            $table->text('release_notes')->nullable()->after('stripe_transfer_id');
        });
        DB::statement("ALTER TABLE fraccional_transactions MODIFY COLUMN status ENUM(
            'pending','paid','held','released','partially_released','refunded','failed'
        ) DEFAULT 'pending'");

   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fraccional_transactions', function (Blueprint $table) {
            //
        });
    }
};
