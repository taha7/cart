<?php

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = factory(Category::class)->create(['name' => 'Drinks', 'slug' => 'drinks']);
        $product = factory(Product::class)->create(['name' => 'coffee', 'slug' => 'coffee']);

        $product->categories()->attach($category->id);

        $productType1 = factory(ProductVariationType::class)->create(['name' => 'Whole Bean']);
        $productType2 = factory(ProductVariationType::class)->create(['name' => 'Ground']);

        // 3 variations for type 1
        $variation1 = factory(ProductVariation::class)->create([
            'name' => '250g',
            'product_id' => $product->id,
            'product_variation_type_id' => $productType1->id,
            'order' => 1
        ]);
        $variation2 = factory(ProductVariation::class)->create([
            'name' => '500g',
            'product_id' => $product->id,
            'product_variation_type_id' => $productType1->id,
            'order' => 2
        ]);
        $variation3 = factory(ProductVariation::class)->create([
            'name' => '1kg',
            'product_id' => $product->id,
            'product_variation_type_id' => $productType1->id,
            'order' => 3
        ]);

        // 3 variations for type 2
        $variation4 = factory(ProductVariation::class)->create([
            'name' => '250g',
            'product_id' => $product->id,
            'product_variation_type_id' => $productType2->id,
            'order' => 1
        ]);
        $variation5 = factory(ProductVariation::class)->create([
            'name' => '500g',
            'product_id' => $product->id,
            'product_variation_type_id' => $productType2->id,
            'order' => 2
        ]);
        $variation6 = factory(ProductVariation::class)->create([
            'name' => '1kg',
            'product_id' => $product->id,
            'product_variation_type_id' => $productType2->id,
            'order' => 3
        ]);

        $variationIds = [$variation1->id, $variation2->id, $variation3->id, $variation4->id, $variation5->id, $variation6->id];

        // Create some stocks for each variation
        array_walk($variationIds, function ($variationId, $index) {
            // leave the first $variation out of stock
            if($index !== 0) {
                factory(Stock::class)->create(['product_variation_id' => $variationId]);
            }
        });

        $users = factory(User::class, 3)->create();

        $users->each(function ($user) use ($variationIds) {
            $orders = factory(Order::class, 3)->create(['user_id' => $user->id]);
            $orders->each(function ($order) use ($variationIds) {
                $randomVariationsCount = rand(1, 3);
                for ($i = 1; $i <= $randomVariationsCount; $i++) {
                    $order->variations()->attach($variationIds[rand(1, 5)], ['quantity' => rand(1, 3)]);
                }
            });
        });
    }
}
