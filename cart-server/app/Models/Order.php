<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function variations()
    {
        return $this->belongsToMany(ProductVariation::class, 'product_variation_orders', 'order_id', 'product_variation_id');
    }
}
