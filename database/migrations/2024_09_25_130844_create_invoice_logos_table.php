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
        Schema::create('invoice_logos', function (Blueprint $table) {
            $table->id('img_id');
            $table->string('img_inv_id');
            $table->string('img_inv_no');
            $table->string('img_name');
            $table->tinyInteger('img_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_logos');
    }
};
