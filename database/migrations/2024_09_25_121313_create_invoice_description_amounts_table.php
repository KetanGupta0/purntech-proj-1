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
        Schema::create('invoice_description_amounts', function (Blueprint $table) {
            $table->id('ida_id');
            $table->string('ida_inv_id');
            $table->string('ida_inv_no');
            $table->string('ida_description');
            $table->string('ida_amount');
            $table->tinyInteger('ida_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_description_amounts');
    }
};
