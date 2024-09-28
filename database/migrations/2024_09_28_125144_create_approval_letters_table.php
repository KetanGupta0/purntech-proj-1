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
        Schema::create('approval_letters', function (Blueprint $table) {
            $table->id('apl_id');
            $table->bigInteger('apl_user_id')->nullable(false);
            $table->string('apl_welcome_msg')->nullable(false);
            $table->string('apl_site_address')->nullable(true);
            $table->string('apl_rent')->nullable(true);
            $table->string('apl_advance')->nullable(true);
            $table->string('apl_agreement_no')->nullable(false);
            $table->string('apl_file_no')->nullable(false);
            $table->string('apl_job_id')->nullable(true);
            $table->string('apl_job_title')->nullable(true);
            $table->string('apl_job_type')->nullable(true);
            $table->string('apl_job_description')->nullable(true);
            $table->tinyInteger('apl_status')->default(1)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_letters');
    }
};
