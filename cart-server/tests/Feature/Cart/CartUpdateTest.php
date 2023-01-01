<?php


namespace Tests\Feature\Cart;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\User;
use Tests\TestCase;

class CartUpdateTest extends TestCase
{
    public function test_it_fails_if_not_auth()
    {
        $this->json('PATCH', 'api/cart/1', [])->assertStatus(401);
    }

    public function test_it_fails_if_the_product_not_exists()
    {
        $this->jsonAs(factory(User::class)->create(), 'PATCH', '/api/cart/not_found')->assertStatus(404);
    }

    public function test_it_requires_a_quantity()
    {
        $productVariation = factory(ProductVariation::class)->create([
            'product_id' => factory(Product::class)->create(),
            'product_variation_type_id' => factory(ProductVariationType::class)->create()
        ]);

        $this->jsonAs(factory(User::class)->create(), 'PATCH', "api/cart/{$productVariation->id}", [])->assertJsonValidationErrors([
            'quantity'
        ]);
    }
    //@TODO: if you need to add validation for the numeric value and the more than 0 value

    public function test_it_can_update_one_product_from_cart()
    {
        $user = factory(User::class)->create();

        $productVariation = factory(ProductVariation::class)->create([
            'product_id' => factory(Product::class)->create()->id,
            'product_variation_type_id' => factory(ProductVariationType::class)->create()->id
        ]);

        $user->cart()->attach([$productVariation->id => [
            'quantity' => 2
        ]]);

        $this->jsonAs(
            $user,
            'PATCH',
            "api/cart/{$productVariation->id}",
            [
                'quantity' => 4
            ]
        );

        $this->assertDatabaseHas('cart_user', [
            'product_variation_id' => $productVariation->id,
            'user_id' => $user->id,
            'quantity' => 4
        ]);
    }
}
