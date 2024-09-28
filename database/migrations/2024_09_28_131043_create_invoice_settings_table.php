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
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->id('ins_id');
            $table->bigInteger('ins_inv_id')->nullable(true);
            $table->longText('ins_header_img')->nullable(false);
            $table->longText('ins_footer_img')->nullable(false);
            $table->longText('ins_body_img_1')->nullable(false);
            $table->longText('ins_body_img_2')->nullable(false);
            $table->longText('ins_stamp')->nullable(false);
            $table->string('ins_website')->nullable(false);
            $table->bigInteger('ins_updated_by')->nullable(false);
            $table->tinyInteger('ins_status')->default(1)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_settings');
    }
};
