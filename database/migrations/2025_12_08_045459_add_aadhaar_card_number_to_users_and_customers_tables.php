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
        Schema::table('users', function (Blueprint $table) {
            $table->string('aadhaar_card_number', 12)->nullable()->after('pan_card_number');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->string('aadhaar_card_number', 12)->nullable()->after('pan_card_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('aadhaar_card_number');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('aadhaar_card_number');
        });
    }
};
