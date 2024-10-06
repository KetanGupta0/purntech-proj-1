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
        Schema::create('company_bank_details', function (Blueprint $table) {
            $table->id('cbd_id');
            $table->string('cbd_bank_name')->nullable(false);
            $table->bigInteger('cbd_account_number')->nullable(false);
            $table->string('cbd_ifsc_code')->nullable(false);
            $table->string('cbd_branch')->nullable(true);
            $table->string('cbd_upi_name')->nullable(true);
            $table->string('cbd_upi_id')->nullable(true);
            $table->longText('cbd_qr_code')->nullable(true);
            $table->tinyInteger('cbd_is_hidden')->nullable(false)->default(0);
            $table->tinyInteger('cbd_status')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_bank_details');
    }
};
