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
        Schema::create('admins', function (Blueprint $table) {
            $table->id('adm_id');
            $table->string('adm_first_name',50);
            $table->string('adm_last_name',50);
            $table->string('adm_email',100)->unique();
            $table->string('adm_mobile',15)->unique();
            $table->string('adm_username',50)->unique();
            $table->longText('adm_password');
            $table->string('adm_visible_password');
            $table->tinyInteger('adm_status')->default(1)->comment('0 - Inactive, 1 - Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
