<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;


class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->resource instanceof Collection) {
            return ProductVariationResource::collection($this->resource);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->formatted_price,
            'price_varies' => $this->priceVaries(),
            'in_stock' => $this->inStock(),
            'stock_count' => $this->stockCount()
        ];
    }
}
