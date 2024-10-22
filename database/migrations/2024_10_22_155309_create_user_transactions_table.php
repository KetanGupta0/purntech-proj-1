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
        Schema::create('user_transactions', function (Blueprint $table) {
            $table->id('tid');
            $table->string('tnx_id');
            $table->float('tnx_amt');
            $table->string('tnx_mode',50);
            $table->dateTime('tnx_date');
            $table->longText('tnx_proof');
            $table->tinyInteger('tnx_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_transactions');
    }
};
