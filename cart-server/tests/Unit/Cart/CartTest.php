<?php

namespace Tests\Unit\Cart;

use App\Cart\Cart;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\User;
use Tests\TestCase;

class CartTest extends TestCase
{
    public function test_it_can_add_products_to_the_cart()
    {
        $cart = new Cart(
            $user = factory(User::class)->create()
        );

        $productVariation = factory(ProductVariation::class)->create([
            'product_id' => factory(Product::class)->create()->id,
            'product_variation_type_id' => factory(ProductVariationType::class)->create()->id
        ]);

        $cart->add([
            ['id' => $productVariation->id, 'quantity' => 3]
        ]);

        $this->assertCount(1, $user->fresh()->cart);
    }

    public function test_it_increments_quantity_when_adding_more_products()
    {
        $productVariation = factory(ProductVariation::class)->create([
            'product_id' => factory(Product::class)->create()->id,
            'product_variation_type_id' => factory(ProductVariationType::class)->create()->id
        ]);

        $user = factory(User::class)->create();

        $cart = new Cart(
            $user
        );


        $cart->add([
            ['id' => $productVariation->id, 'quantity' => 3]
        ]);

        $cart = new Cart(
            $user->fresh()
        );

        $cart->add([
            ['id' => $productVariation->id, 'quantity' => 3]
        ]);

        $this->assertEquals(6, $user->fresh()->cart->first()->pivot->quantity);
    }
}
