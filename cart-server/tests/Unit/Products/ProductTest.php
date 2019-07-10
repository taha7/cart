<?php

namespace Tests\Unit\Products;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

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
}
