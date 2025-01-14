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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_plan_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('attorney_id')->nullable();
            $table->unsignedBigInteger('case_id');
            $table->integer('installment_cycle_no')->default(0)->comment('0 is downpayment');
            $table->decimal('amount', 10, 2);
            $table->date('date_of_charge')->nullable();
            $table->enum('status', ['Success','Pending', 'Failed'])->comment('Success','Pending', 'Failed');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('payment_plan_id')->references('id')->on('payment_plans')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('attorney_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('case_id')->references('id')->on('case_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
