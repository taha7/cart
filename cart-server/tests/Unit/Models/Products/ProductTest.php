<?php

namespace Tests\Unit\Models\Products;

use App\Cart\Money;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\Stock;

class ProductTest extends TestCase
{
    /** @test */
    public function it_uses_a_slug_for_route_key_name()
    {
        $product = new Product();

        $this->assertEquals($product->getRouteKeyName(), 'slug');
    }

    /** @test */
    public function it_has_many_categories()
    {
        $product = factory(Product::class)->create();

        $product->categories()->save(
            factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $product->categories()->first());
        $this->assertInstanceOf(Collection::class, $product->categories);
    }

    /** @test */
    public function it_has_many_variations()
    {
        $product = factory(Product::class)->create();


        factory(ProductVariation::class)->create([
            'product_id' => $product->id,
            'product_variation_type_id' => factory(ProductVariationType::class)->create()->id
        ]);


        $this->assertInstanceOf(ProductVariation::class, $product->variations()->first());
        $this->assertInstanceOf(Collection::class, $product->variations);
    }

    /** @test */
    public function it_returns_money_instance_for_the_price()
    {
        $product = factory(Product::class)->create();

        $this->assertInstanceOf(Money::class, $product->price);
    }

    // @TODO: Do you really need to create or just make
    /** @test */
    public function it_returns_a_formatted_price()
    {
        $product = factory(Product::class)->create(['price' => 1000]);

        $this->assertEquals('£10.00', $product->formatted_price);
    }

    /** @test */
    public function it_can_check_if_its_in_stock()
    {
        $product = factory(Product::class)->create();

        $variation = factory(ProductVariation::class)->create([
            'product_id' => $product->id,
            'product_variation_type_id' => factory(ProductVariationType::class)->create()->id
        ]);

        factory(Stock::class)->create([
            'product_variation_id' => $variation->id
        ]);

        $this->assertTrue($product->inStock());
    }

    /** @test */
    public function it_can_get_the_stock_count()
    {
        $product = factory(Product::class)->create();

        $variation = factory(ProductVariation::class)->create([
            'product_id' => $product->id,
            'product_variation_type_id' => factory(ProductVariationType::class)->create()->id
        ]);

        $variation2 = factory(ProductVariation::class)->create([
            'product_id' => $product->id,
            'product_variation_type_id' => factory(ProductVariationType::class)->create()->id
        ]);

        factory(Stock::class)->create([
            'quantity' => 10,
            'product_variation_id' => $variation->id
        ]);

        factory(Stock::class)->create([
            'quantity' => 10,
            'product_variation_id' => $variation2->id
        ]);

        $this->assertEquals($product->stockCount(), 20);
    }
}
