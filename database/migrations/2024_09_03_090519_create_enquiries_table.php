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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id('enq_id');
            $table->string('enq_user_first_name',50);
            $table->string('enq_user_last_name',50);
            $table->string('enq_user_email',100);
            $table->string('enq_user_mobile',15);
            $table->string('enq_user_service');
            $table->date('enq_user_date');
            $table->longText('enq_user_aadhar_front')->nullable();
            $table->longText('enq_user_aadhar_back')->nullable();
            $table->longText('enq_user_profile_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
