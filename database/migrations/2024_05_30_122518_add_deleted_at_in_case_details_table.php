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
        Schema::table('case_details', function (Blueprint $table) {
            $table->unsignedBigInteger('sr_no')->unique()->nullable()->after('user_id');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('case_details', function (Blueprint $table) {
            $table->dropColumn('sr_no');
            $table->dropSoftDeletes();
        });
    }
};
