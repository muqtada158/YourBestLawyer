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
        Schema::table('transactions', function (Blueprint $table) {
            $table->text('stripe_charge_id')->nullable()->after('date_of_charge');
            $table->integer('stripe_charge_ybl_fee')->nullable()->after('stripe_charge_id');
            $table->text('stripe_charge_json')->nullable()->after('stripe_charge_ybl_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('stripe_charge_id');
            $table->dropColumn('stripe_charge_ybl_fee');
            $table->dropColumn('stripe_charge_json');
        });
    }
};
