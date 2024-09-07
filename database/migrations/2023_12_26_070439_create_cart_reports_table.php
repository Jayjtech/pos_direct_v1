<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('invoice_code')->nullable();
            $table->text('buyer')->nullable();
            $table->string('phone')->nullable();
            $table->longText('address')->nullable();
            $table->integer('payment_method')->default(0)->comment('0:Cash, 1:Credit card, 2:Bank transfer');
            $table->decimal('grand_total',11,1)->default(0);
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
        Schema::dropIfExists('cart_reports');
    }
}