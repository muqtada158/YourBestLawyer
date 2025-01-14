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
            $table->boolean('is_same_person')->default(false);
            $table->string('convictee_name')->nullable();
            $table->date('convictee_dob')->nullable();
            $table->string('convictee_relationship')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('case_details', function (Blueprint $table) {
            $table->dropColumn('is_same_person');
            $table->dropColumn('convictee_name');
            $table->dropColumn('convictee_dob');
            $table->dropColumn('convictee_relationship');
        });
    }
};
