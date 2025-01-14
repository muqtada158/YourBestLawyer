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
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('attorney_id')->nullable();
            $table->unsignedBigInteger('case_id');
            $table->unsignedBigInteger('sub_cat_id');
            $table->unsignedBigInteger('package_id');
            $table->string('invoice_no')->unique()->nullable();
            $table->enum('installments', ['yes', 'no'])->default('no')->comment('yes', 'no');
            $table->decimal('total_amount', 10, 2);
            $table->integer('installment_cycle')->nullable();
            $table->enum('status', ['Enabled', 'Disabled'])->default('Enabled')->comment('Enabled', 'Disabled');
            $table->enum('payment_status', ['Unpaid', 'PartiallyPaid', 'Paid'])->default('Unpaid')->comment('Unpaid', 'PartiallyPaid', 'Paid');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('attorney_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('case_id')->references('id')->on('case_details')->onDelete('cascade');
            $table->foreign('sub_cat_id')->references('id')->on('law_sub_categories')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('lawyers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_plans');
    }
};
