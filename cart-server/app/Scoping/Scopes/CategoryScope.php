<?php

namespace App\Scoping\Scopes;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contract\Scope;

class CategoryScope implements Scope
{
   public function apply(Builder $builder, $value)
   {
      $builder->whereHas('categories', function ($builder) use ($value) {
         $builder->where('slug', $value);
      });
   }
}
