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
        Schema::table('law_sub_categories', function (Blueprint $table) {
            $table->string('installments_available')->after('title')->comment('Yes | No')->nullable();
            $table->integer('installments')->after('installments_available')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('law_sub_categories', function (Blueprint $table) {
            $table->dropColumn('installments_available');
            $table->dropColumn('installments');
        });
    }
};
