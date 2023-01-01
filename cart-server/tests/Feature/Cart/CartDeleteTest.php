<?php

namespace Tests\Feature\Cart;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\User;
use Tests\TestCase;

class CartDeleteTest extends TestCase
{
    public function test_it_fails_if_not_auth()
    {
        $this->json('DELETE', '/api/cart/any')->assertStatus(401);
    }

    public function test_it_fails_if_the_product_not_exists()
    {
        $this->jsonAs(factory(User::class)->create(), 'DELETE', 'api/cart/any')->assertStatus(404);
    }

    public function test_it_can_delete_an_item_from_the_cart()
    {
        $user = factory(User::class)->create();

        $productVariation = factory(ProductVariation::class)->create([
            'product_id' => factory(Product::class)->create()->id,
            'product_variation_type_id' => factory(ProductVariationType::class)->create()->id
        ]);

        $user->cart()->attach([$productVariation->id => [
            'quantity' => 2
        ]]);

        $this->jsonAs($user, 'DELETE', 'api/cart/' . $productVariation->id);

        $this->assertDatabaseMissing('cart_user', [
            'product_variation_id' => $productVariation->id
        ]);
    }
}
