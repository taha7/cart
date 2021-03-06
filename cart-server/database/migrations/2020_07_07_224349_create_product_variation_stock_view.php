<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariationStockView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE VIEW product_variation_stock_view AS
            SELECT product_variations.product_id as product_id,
            product_variations.id as product_variation_id,
            COALESCE(COALESCE(stocks.quantity, 0) - COALESCE(product_variation_orders.quantity, 0), 0) as quantity,
            CASE WHEN COALESCE(COALESCE(stocks.quantity, 0) - COALESCE(product_variation_orders.quantity, 0), 0) > 0 THEN true ELSE false END in_stock
            from product_variations
            LEFT JOIN (
                SELECT stocks.product_variation_id as id,
                SUM(stocks.quantity) as quantity
                From stocks
                GROUP BY stocks.product_variation_id
            ) as stocks USING(id)
            LEFT JOIN (
                SELECT product_variation_orders.product_variation_id as id,
                SUM(product_variation_orders.quantity) as quantity
                FROM product_variation_orders
                GROUP BY product_variation_orders.product_variation_id
            ) as product_variation_orders USING (id)
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS product_variation_stock_view');
    }
}
