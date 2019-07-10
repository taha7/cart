<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scoping\Scoper;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeWithScopes(Builder $builder, $scopes = [])
    {
        return (new Scoper(request()))->apply($builder, $scopes);
    }
}
