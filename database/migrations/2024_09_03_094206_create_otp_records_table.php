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
        Schema::create('otp_records', function (Blueprint $table) {
            $table->id('otp_id');
            $table->integer('otp_code');
            $table->bigInteger('otp_initiated_by');
            $table->string('otp_user_type',10);
            $table->string('otp_initiated_for');
            $table->string('otp_sent_to',15);
            $table->string('otp_message');
            $table->tinyInteger('otp_status')->default(0)->comment('0 - Unused/active, 1 - Used/Expired, 2 - Unused/Expired');
            $table->dateTime('otp_expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_records');
    }
};
