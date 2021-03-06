<?php

namespace App\Scoping;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contract\Scope;

class Scoper
{
   protected $request;

   public function __construct(Request $request)
   {
      $this->request = $request;
   }

   public function apply(Builder $builder, array $scopes)
   {
      foreach ($scopes as $key => $scope) {

         if (in_array($key, $this->request->keys())) {

            if ($scope instanceof Scope) {

               $scope->apply($builder, $this->request->get($key));
            }
         }
      }

      return $builder;
   }
}
