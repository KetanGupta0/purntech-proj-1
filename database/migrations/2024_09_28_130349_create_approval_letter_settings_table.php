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
        Schema::create('approval_letter_settings', function (Blueprint $table) {
            $table->id('als_id');
            $table->bigInteger('als_letter_id')->nullable(true);
            $table->longText('als_default_welcome_msg')->nullable(false);
            $table->longText('als_header_img')->nullable(false);
            $table->longText('als_footer_img')->nullable(false);
            $table->longText('als_body_img_1')->nullable(false);
            $table->longText('als_body_img_2')->nullable(false);
            $table->bigInteger('als_updated_by')->nullable(false);
            $table->tinyInteger('als_status')->default(1)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_letter_settings');
    }
};
