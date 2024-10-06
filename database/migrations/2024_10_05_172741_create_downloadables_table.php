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
        Schema::create('downloadables', function (Blueprint $table) {
            $table->id('dwn_id');
            $table->string('dwn_title')->nullable(false);
            $table->string('dwn_subtitle')->nullable(true);
            $table->longText('dwn_file')->nullable(false);
            $table->tinyInteger('dwn_is_hidden')->default(0)->nullable(false);
            $table->tinyInteger('dwn_status')->default(1)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('downloadables');
    }
};
