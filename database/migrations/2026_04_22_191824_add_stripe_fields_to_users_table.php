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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('stripe_charges_enabled')
                  ->default(false)
                  ->after('stripe_connect_status');

            $table->boolean('stripe_payouts_enabled')
                  ->default(false)
                  ->after('stripe_charges_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_charges_enabled',
                'stripe_payouts_enabled'
            ]);
        });
    }
};
