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
            $table->integer('lawyer_type')->after('package_type')->nullable()->comment('1,2,3 | For filter of leads')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('case_details', function (Blueprint $table) {
            $table->dropColumn('lawyer_type');
        });
    }
};
