<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class ProductScopingTest extends TestCase
{
    /** @test */
    public function it_can_scope_by_category()
    {
        $product = factory(Product::class)->create();

        $product->categories()->save(
            $category = factory(Category::class)->create()
        );

        $anotherProduct = factory(Product::class)->create();

        $this->json('Get', "api/products?category={$category->slug}")
            ->assertJsonFragment([
                'slug' => $product->slug
            ])->assertJsonMissing([
                'slug' => $anotherProduct->slug
            ]);
    }
}
