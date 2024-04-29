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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email')->unique();
            $table->string('phoneNumber')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('streetAdressOne')->nullable();
            $table->string('streetAddressTwo')->nullable();
            $table->string('city')->nullable();
            $table->string('town')->nullable();
            $table->string('zipCode');
            $table->string('dateOfBirth')->nullable();
            $table->string('placeOfBirth')->nullable();
            $table->string('gender');
            $table->longText('losing_weight_challenge')->nullable();
            $table->string('gp_practice_email')->nullable();
            $table->string('GPS_name_and_address')->nullable();
            $table->string('idCardPhoto')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
