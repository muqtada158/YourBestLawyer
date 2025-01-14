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
        Schema::create('attorney_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attorney_id')->nullable();
            $table->foreign('attorney_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('google_review',8,1)->nullable();
            $table->date('google_date')->nullable()->default(null);
            $table->decimal('yelp_review',8,1)->nullable();
            $table->date('yelp_date')->nullable()->default(null);
            $table->decimal('avvo_review',8,1)->nullable();
            $table->date('avvo_date')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attorney_reviews');
    }
};
