<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->decimal('cost_price',11)->default(0);
            $table->decimal('discount_amount',11)->default(0);
            $table->decimal('discount_percent',11)->default(0);
            $table->integer('discount_mode')->default(0);
            $table->decimal('price',11)->default(0);
            $table->string('product_code')->nullable();
            $table->text('barcode')->nullable();
            $table->decimal('availability',11,2)->default(0);
            $table->string('img')->nullable();
            $table->integer('status')->default(1)->comment('0:Invisible, 1:Visible');
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
        Schema::dropIfExists('products');
    }
}