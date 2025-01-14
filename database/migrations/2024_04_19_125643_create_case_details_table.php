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
        Schema::create('case_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('client_name')->nullable();
            $table->date('client_dob')->nullable();
            $table->string('preferred_language')->nullable();
            $table->string('court_where_the_case_is_at')->nullable();
            $table->string('case_or_citation_number')->nullable();
            $table->text('charges')->nullable();
            $table->date('next_court_date')->nullable();
            $table->string('type_of_hearing')->nullable();
            $table->string('how_many_hearing_have_you_had')->nullable();
            $table->text('list_all_prior_criminal_convictions')->nullable();

            $table->unsignedBigInteger('case_type')->nullable();
            $table->foreign('case_type')->references('id')->on('law_categories')->onDelete('cascade');
            $table->unsignedBigInteger('case_sub_type')->nullable();
            $table->foreign('case_sub_type')->references('id')->on('law_sub_categories')->onDelete('cascade');
            $table->unsignedBigInteger('package_type')->nullable();
            $table->foreign('package_type')->references('id')->on('lawyers')->onDelete('cascade');

            $table->text('application')->nullable();
            $table->string('application_status')->nullable()->comment('application status: Pending/Accepted/Rejected');
            $table->string('case_status')->nullable()->comment('case status: Pending/Accepted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_details');
    }
};
