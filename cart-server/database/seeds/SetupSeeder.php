<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
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
        factory(ProductVariation::class)->create([
            'name' => '250g',
            'product_id' => $product->id,
            'product_variation_type_id' => $productType1->id,
            'order' => 1
        ]);
        factory(ProductVariation::class)->create([
            'name' => '500g',
            'product_id' => $product->id,
            'product_variation_type_id' => $productType1->id,
            'order' => 2
        ]);
        factory(ProductVariation::class)->create([
            'name' => '1kg',
            'product_id' => $product->id,
            'product_variation_type_id' => $productType1->id,
            'order' => 3
        ]);

        // 3 variations for type 2
        factory(ProductVariation::class)->create([
            'name' => '250g',
            'product_id' => $product->id,
            'product_variation_type_id' => $productType2->id,
            'order' => 1
        ]);
        factory(ProductVariation::class)->create([
            'name' => '500g',
            'product_id' => $product->id,
            'product_variation_type_id' => $productType2->id,
            'order' => 2
        ]);
        factory(ProductVariation::class)->create([
            'name' => '1kg',
            'product_id' => $product->id,
            'product_variation_type_id' => $productType2->id,
            'order' => 3
        ]);
    }
}
