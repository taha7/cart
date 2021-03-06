<?php

namespace App\Models\Traits;

use App\Cart\Money as CartMoney;

trait HasPrice
{
    public function getPriceAttribute($value)
    {
        return new CartMoney($value);
    }

    public function getFormattedPriceAttribute()
    {
        return $this->price->formatted();
    }
}
