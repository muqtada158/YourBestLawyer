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
        Schema::create('attorney_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name_of_applicant')->nullable();
            $table->text('name_of_firm_you_work_for')->nullable();
            $table->text('do_you_own_this_firm')->nullable();
            $table->text('how_long_have_you_been_in_service_to_the_public')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('languages_spoken')->nullable();
            $table->string('law_school_name')->nullable();
            $table->string('year_graduated')->nullable();
            $table->text('admitted_into_law_AZ')->nullable();
            $table->text('AZ_state_bar_name')->nullable();
            $table->text('any_special_certification')->nullable();

            $table->text('area_of_practice')->nullable();
            $table->text('year_started_in_this_area')->nullable();
            $table->text('average_cases_handled_per_month')->nullable();

            $table->text('signature_text')->nullable();
            $table->text('signature_image')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attorney_applications');
    }
};
