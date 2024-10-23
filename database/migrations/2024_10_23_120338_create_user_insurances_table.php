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
        Schema::create('user_insurances', function (Blueprint $table) {
            $table->id('uin_id');
            $table->string('uin_policy_number');
            $table->unsignedBigInteger('uin_insured_id');
            $table->string('uin_insured_name');
            $table->string('uin_nominee');
            $table->float('uin_sum_assured');
            $table->float('uin_insurance_premium');
            $table->dateTime('uin_paid_till');
            $table->float('uin_balance_amount');
            $table->tinyInteger('uin_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_insurances');
    }
};
