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
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id('cmp_id');
            $table->string('cmp_name');
            $table->string('cmp_short_name');
            $table->longText('cmp_logo')->nullable(true);
            $table->string('cmp_mobile1',15);
            $table->string('cmp_mobile2',15)->nullable(true);
            $table->string('cmp_mobile3',15)->nullable(true);
            $table->string('cmp_primary_email',100);
            $table->string('cmp_support_email',100)->nullable(true);
            $table->string('cmp_contact_email',100)->nullable(true);
            $table->string('cmp_website',100)->nullable(true);
            $table->string('cmp_gst_no',50)->nullable(true);
            $table->string('cmp_landmark')->nullable(true);
            $table->string('cmp_city',50)->nullable(true);
            $table->string('cmp_state',50)->nullable(true);
            $table->string('cmp_country',50)->nullable(true);
            $table->integer('cmp_zip')->nullable(true);
            $table->string('cmp_address1')->nullable(true);
            $table->string('cmp_address2')->nullable(true);
            $table->string('cmp_address3')->nullable(true);
            $table->longText('cmp_doc1')->nullable(true);
            $table->longText('cmp_doc2')->nullable(true);
            $table->longText('cmp_doc3')->nullable(true);
            $table->longText('cmp_doc4')->nullable(true);
            $table->longText('cmp_doc5')->nullable(true);
            $table->longText('cmp_doc6')->nullable(true);
            $table->longText('cmp_doc7')->nullable(true);
            $table->tinyInteger('cmp_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_infos');
    }
};
