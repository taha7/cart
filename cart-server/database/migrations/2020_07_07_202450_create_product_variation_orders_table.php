<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariationOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variation_orders', function (Blueprint $table) {
            // $table->increments('id');
            $table->integer('order_id')->unsigend()->index();
            $table->integer('product_variation_id')->unsigend()->index();
            $table->integer('quantity')->unsigend();
            $table->timestamps();

            // $table->foreign('order_id')->references('id')->on('orders');
            // $table->foreign('product_variation_id')->references('id')->on('product_variations');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variation_orders');
    }
}
