<?php

namespace Tests\Feature\Cart;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\User;
use Tests\TestCase;

class CartStoreTest extends TestCase
{
    public function testItFailsIfNotAuthenticated()
    {
        $this->json('POST', 'api/cart', [])->assertStatus(401);
    }

    public function testItRequiresProducts()
    {
        $this->jsonAs(factory(User::class)->create(), 'POST', 'api/cart')
            ->assertJsonValidationErrors(['products']);
    }

    public function testItAcceptsArraysOnlyForProducts()
    {
        $this->jsonAs(factory(User::class)->create(), 'POST', 'api/cart', ['products' => 'nope'])
            ->assertJsonValidationErrors(['products']);
    }

    public function testItRequiresProductVariationIdsAndQuantities()
    {
        $this->jsonAs(
            factory(User::class)->create(),
            'POST',
            'api/cart',
            [
                'products' => [
                    []
                ]
            ]
        )
            ->assertJsonValidationErrors(['products.0.id', 'products.0.quantity']);
    }

    public function testItAcceptsValidProductVariationIds()
    {
        $this->jsonAs(
            factory(User::class)->create(),
            'POST',
            'api/cart',
            [
                'products' => [
                    ['id' => -111]
                ]
            ]
        )
            ->assertJsonValidationErrors(['products.0.id']);
    }

    public function testItAcceptsValidQuantities()
    {
        $this->jsonAs(
            factory(User::class)->create(),
            'POST',
            'api/cart',
            [
                'products' => [
                    ['quantity' => -111]
                ]
            ]
        )
            ->assertJsonValidationErrors(['products.0.quantity']);
    }

    public function testItCanAddProductsToTheUserCart()
    {
        $productVariation = factory(ProductVariation::class)->create([
            'product_id' => factory(Product::class)->create(),
            'product_variation_type_id' => factory(ProductVariationType::class)->create()
        ]);

        $this->jsonAs(
            factory(User::class)->create(),
            'POST',
            'api/cart',
            [
                'products' => [
                    [
                        'id' => $productVariation->id,
                        'quantity' => $quantity = 4
                    ]
                ]
            ]
        );

        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $productVariation->id,
            'quantity' => $quantity
        ]);
    }
}
