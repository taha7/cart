<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use App\Models\Product;

class ProductIndexTest extends TestCase
{
    /** @test */
    public function test_it_shows_a_collection_of_products()
    {
        $products = factory(Product::class, 2)->create();

        $response = $this->json('Get', 'api/products');

        $products->each(function ($product) use ($response) {
            $response->assertJsonFragment([
                'slug' => $product->slug
            ]);
        });
    }

    /** @test */
    public function it_returns_paginated_data()
    {
        $this->json('GET', 'api/products')
            ->assertJsonStructure([
                'meta',
                'links',
                'data'
            ]);
    }
}
