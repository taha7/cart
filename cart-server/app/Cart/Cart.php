<?php

namespace App\Cart;

use App\Models\User;

class Cart
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function add(array $products)
    {
        // @TODO: Use custom collection here
        $products = collect($products)->keyBy('id')->map(function ($product) {
            return [
                'quantity' => $product['quantity'] + $this->getCurrentQuantity($product['id'])
            ];
        });

        $this->user->cart()->syncWithoutDetaching($products);
    }

    public function update(int $productId, int $quantity)
    {
        $this->user->cart()->updateExistingPivot($productId, [
            'quantity' => $quantity
        ]);
    }

    public function delete(int $productId)
    {
        $this->user->cart()->detach($productId);
    }

    protected function getCurrentQuantity($productId)
    {
        if ($product = $this->user->cart->where('id', $productId)->first()) {
            return $product->pivot->quantity;
        }

        return 0;
    }
}
