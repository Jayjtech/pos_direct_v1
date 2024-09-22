<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('combined_order_id');
            $table->foreign('combined_order_id')->references('id')->on('combined_orders')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('product')->nullable();
            $table->string('product_code')->nullable();
            $table->text('barcode')->nullable();
            $table->integer('status')->default(0)->comment('0:pending, 1:completed, 2:refunded');
            $table->decimal('qty',11,1)->default(0);
            $table->decimal('unit_price',11,1)->default(0);
            $table->decimal('sub_cost_price',11,1)->default(0);
            $table->decimal('sub_selling_price',11,1)->default(0);
            $table->decimal('sub_total',11,1)->default(0);
            $table->decimal('discount',11,1)->default(0);
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
        Schema::dropIfExists('orders');
    }
}