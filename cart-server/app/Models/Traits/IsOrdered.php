<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * If a given model is ordered
 */
trait IsOrdered
{
    public function scopeOrdered(Builder $builder, $direction = 'asc')
    {
        $builder->orderBy('order', $direction);
    }
}
