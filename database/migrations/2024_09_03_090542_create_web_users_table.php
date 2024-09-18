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
        Schema::create('web_users', function (Blueprint $table) {
            $table->id('usr_id');
            $table->string('usr_first_name',50);
            $table->string('usr_last_name',50);
            $table->string('usr_email',100)->unique();
            $table->string('usr_mobile',15)->unique();
            $table->string('usr_gender',30)->nullable();
            $table->date('usr_dob')->nullable();
            $table->string('usr_service');
            $table->date('usr_date');
            $table->longText('usr_aadhar_front')->nullable();
            $table->longText('usr_aadhar_back')->nullable();
            $table->longText('usr_profile_photo')->nullable();
            $table->string('usr_username',50)->unique();
            $table->longText('usr_password')->nullable();
            $table->string('usr_visible_password')->nullable();
            $table->tinyInteger('usr_profile_status')->default(1)->comment('0 - Deleted, 1 - Unblocked/Unrestricted, 2 - Blocked/Restricted');
            $table->tinyInteger('usr_verification_status')->default(0)->comment('0 - Not Verified, 1 - Verified');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_users');
    }
};
