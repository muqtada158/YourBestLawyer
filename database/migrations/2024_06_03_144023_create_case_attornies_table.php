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
        Schema::create('case_attornies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('case_id');
            $table->foreign('case_id')->references('id')->on('case_details')->onDelete('cascade');
            $table->unsignedBigInteger('attorney_id');
            $table->foreign('attorney_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('attorney_bid')->nullable();
            $table->string('status')->nullable()->comment('Interested | NotInterested');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_attornies');
    }
};
