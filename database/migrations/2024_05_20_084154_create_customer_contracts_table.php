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
        Schema::create('customer_contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('attorney_id')->nullable();
            $table->foreign('attorney_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('case_id')->nullable();
            $table->foreign('case_id')->references('id')->on('case_details')->onDelete('cascade');
            $table->string('convictee_full_name')->nullable();
            $table->date('convictee_date')->nullable();
            $table->string('convictee_relationship')->nullable();
            $table->integer('contract_id')->nullable();
            $table->date('contract_date')->nullable();
            $table->text('signature_image')->nullable();
            $table->text('attorney_signature_image')->nullable();
            $table->string('status')->nullable()->default('Pending')->comment('Pending | Accepted | Ended');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_contracts');
    }
};
