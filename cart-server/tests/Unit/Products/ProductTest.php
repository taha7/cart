<?php

namespace Tests\Unit\Products;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class ProductTest extends TestCase
{
    /** @test */
    public function it_uses_a_slug_for_route_key_name()
    {
        $product = new Product();

        $this->assertEquals($product->getRouteKeyName(), 'slug');
    }
}
