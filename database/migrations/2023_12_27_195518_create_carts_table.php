<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('cart_report_id');
            $table->foreign('cart_report_id')->references('id')->on('cart_reports')->onDelete('cascade');
            $table->integer('tab_no')->default(0);
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->decimal('qty',11,1)->default(1);
            $table->decimal('price',11,1)->default(0);
            $table->decimal('sub_total',11,1)->default(0);
            $table->decimal('discount',11,1)->default(0);
            $table->decimal('pdt_discount',11,1)->default(0);
            $table->string('checkbox_status')->nullable();
            $table->integer('status')->default(0)->comment('0: active, 1: saved');
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
        Schema::dropIfExists('carts');
    }
}