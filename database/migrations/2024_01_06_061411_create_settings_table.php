<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->longText('company_address')->nullable();
            $table->json('company_phones')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_signature')->nullable();
            $table->integer('logo_status')->default(0);
            $table->integer('signature_status')->default(0);
            $table->integer('discount_mode')->default(0);
            $table->integer('discount_visibility')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}