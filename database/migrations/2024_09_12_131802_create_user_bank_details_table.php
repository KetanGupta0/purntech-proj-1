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
        Schema::create('user_bank_details', function (Blueprint $table) {
            $table->id('ubd_id');
            $table->string('ubd_user_name','100');
            $table->string('ubd_user_pan','10');
            $table->string('ubd_user_name_in_bank','100');
            $table->string('ubd_user_bank_name','100');
            $table->string('ubd_user_bank_acc','20');
            $table->string('ubd_user_ifsc','11');
            $table->longText('ubd_user_bank_proof');
            $table->tinyInteger('ubd_user_kyc_status')->default(1)->comment('1 - Pending, 2 - Verified, 3 - Rejected, 0 - Deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_bank_details');
    }
};
