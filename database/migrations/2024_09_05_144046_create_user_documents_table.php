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
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id('udc_id');
            $table->string('udc_name')->comment('Physical file name');
            $table->bigInteger('udc_user_id')->comment('Foregin Key');
            $table->string('udc_source')->nullable()->comment('To locate where it comes from');
            $table->tinyInteger('udc_status')->default(1)->comment('0 - Deleted, 1 - Not Deleted/Not Verified, 2 - Verified, 9 - Rejected');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_documents');
    }
};
