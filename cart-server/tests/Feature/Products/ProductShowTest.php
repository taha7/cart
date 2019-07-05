<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class ProductShowTest extends TestCase
{
    /** @test */
    public function it_fails_if_product_does_not_exist()
    {
        $this->json('GET', 'api/products/product-slug')
            ->assertStatus(404);
    }

    /** @test */
    public function it_shows_a_product()
    {
        $product = factory(Product::class)->create();

        $this->json('GET', "api/products/{$product->slug}")
            ->assertJsonFragment([
                'slug' => $product->slug
            ]);
    }
}
