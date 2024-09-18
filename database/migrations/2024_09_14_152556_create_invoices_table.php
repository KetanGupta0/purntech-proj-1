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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('inv_id');
            $table->string('inv_number')->unique();
            $table->bigInteger('inv_party_id')->comment('This column contains web users id');
            $table->string('inv_party_name');
            $table->string('inv_party_address_1');
            $table->string('inv_party_address_2')->nullable(true);
            $table->string('inv_party_mobile1',15);
            $table->string('inv_party_mobile2',15)->nullable(true);
            $table->longText('inv_message')->nullable(true);
            $table->integer('inv_amount');
            $table->date('inv_date');
            $table->date('inv_due_date');
            $table->tinyInteger('inv_status')->default(1);
            $table->tinyInteger('inv_created_by')->comment('This column contains admin id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
