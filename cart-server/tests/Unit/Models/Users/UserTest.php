<?php

namespace Tests\Unit\Models\Users;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_hashes_the_password_when_creating()
    {
        $user = factory(User::class)->create([
            'password' => '123123'
        ]);


        $this->assertNotEquals($user->password, '123123');
    }

    /** @test */
    public function it_has_a_cart_relation()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            factory(ProductVariation::class)->create([
                'product_id' => factory(Product::class)->create()->id,
                'product_variation_type_id' => factory(ProductVariationType::class)->create()->id,
            ])
        );

        $this->assertInstanceOf(ProductVariation::class, $user->cart->first());
    }
}
