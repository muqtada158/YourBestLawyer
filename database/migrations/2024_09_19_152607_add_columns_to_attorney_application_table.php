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
        Schema::table('attorney_applications', function (Blueprint $table) {
            $table->string('dob')->after('any_special_certification')->nullable();
            $table->text('office_address')->after('dob')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attorney_application', function (Blueprint $table) {
            $table->dropColumn('dob');
            $table->dropColumn('office_address');
        });
    }
};
