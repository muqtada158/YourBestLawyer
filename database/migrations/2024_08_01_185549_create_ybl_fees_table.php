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
        Schema::create('ybl_fees', function (Blueprint $table) {
            $table->id();
            $table->decimal('ybl_fee',8,2)->default(0.1)->comment('0.1 * 100 = 10%');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ybl_fees');
    }
};
