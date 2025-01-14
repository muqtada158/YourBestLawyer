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
        Schema::table('law_categories', function (Blueprint $table) {
            $table->string('count_as')->after('image')->nullable()->default('$')->comment('$ or %');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('law_categories', function (Blueprint $table) {
            $table->dropColumn('count_as');
        });
    }
};
