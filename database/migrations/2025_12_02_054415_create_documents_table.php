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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->string('customer_name')->nullable();
            $table->string('aadhar_card_number', 12)->nullable();
            $table->string('aadhar_card_image')->nullable();
            $table->integer('aadhar_card_otp')->nullable();
            $table->timestamp('aadhar_card_otp_expired')->nullable();
            $table->string('pan_card_number', 10)->nullable();
            $table->string('pan_card_image')->nullable();
            $table->integer('pan_card_otp')->nullable();
            $table->timestamp('pan_card_otp_expired')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
