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
        Schema::create('attorney_agreements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('attorney_name_1')->nullable();
            $table->string('area_of_law')->nullable();
            $table->string('attorney_name_2')->nullable();
            $table->string('name_of_law_firm')->nullable();
            $table->string('in_service_since')->nullable();
            $table->string('name_of_attorney')->nullable();
            $table->string('state_bar')->nullable();
            $table->date('dob')->nullable();
            $table->string('law_school')->nullable();
            $table->string('year_graduated')->nullable();
            $table->string('office_address')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('spoken_languages')->nullable();
            $table->string('admitted_in_arizona')->nullable();
            $table->text('area_of_practice')->nullable();
            $table->text('year_started')->nullable();
            $table->text('cases_handled_per_year')->nullable();
            $table->string('malpractice')->nullable();
            $table->date('date')->nullable();
            $table->text('signature')->nullable();





            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attorney_agreements');
    }
};
