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
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 15)->unique(); // Phone as string (handles +, 0s)
            $table->string('pan_card_number')->nullable();
            $table->string('reference_code', 10)->nullable();
            $table->integer('m_pin')->nullable(); // no auto_increment
            $table->integer('otp')->nullable();   // no auto_increment
            $table->timestamp('otp_expired')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->enum('marital_status', ['Single', 'Married', 'UnMarried', 'Other'])->nullable();
            $table->text('address')->nullable();
            $table->string('address_type')->nullable();
            $table->enum('user_type', ['Salaried', 'Self-Employed', 'Freelancer'])->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
