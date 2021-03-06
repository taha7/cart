<?php

namespace Tests\Unit\Products;

use App\Cart\Money;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;

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

    /** @test */
    public function it_returns_a_formatted_price()
    {
        $product = factory(Product::class)->create(['price' => 1000]);

        $this->assertEquals('£10.00', $product->formatted_price);
    }
}
