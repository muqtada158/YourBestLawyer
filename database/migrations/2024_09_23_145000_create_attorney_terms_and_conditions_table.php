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
        Schema::create('attorney_terms_and_conditions', function (Blueprint $table) {
            $table->id();
            $table->text('terms_and_conditions')->nullable();
            $table->enum('status',['Enabled','Disabled'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attorney_terms_and_conditions');
    }
};
