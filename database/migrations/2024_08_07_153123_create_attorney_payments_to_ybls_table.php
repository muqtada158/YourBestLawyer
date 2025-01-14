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
        Schema::create('attorney_payments_to_ybls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attorney_id')->nullable();
            $table->unsignedBigInteger('case_id')->nullable();
            $table->bigInteger('invoice_no')->unique()->nullable();
            $table->text('intent_id')->nullable();
            $table->decimal('amount',8,2)->nullable();
            $table->text('stripe_invoice_url')->nullable();
            $table->enum('status',['Paid','Unpaid'])->default('Unpaid')->comment('Paid, Unpaid');
            $table->timestamps();

            $table->foreign('attorney_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('case_id')->references('id')->on('case_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attorney_payments_to_ybls');
    }
};
