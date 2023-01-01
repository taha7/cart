<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends ProductIndexResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return
            array_merge(
                parent::toArray($request),
                // I think it will be better if we have a relation between the product and the type of the product
                // So instead of doing group by 
                // You will just load the type and from type load variations
                // Product::with(['types' => function ($query) {
                //      $query->with(['variations']);
                // }])
                [
                    'variations' => ProductVariationResource::collection(
                        $this->variations->groupBy('type.name')
                    )
                ]
            );
    }
}
