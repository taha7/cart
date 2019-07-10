<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductResource;
use App\Scoping\Scopes\CategoryScope;

class ProductController extends Controller
{

    public function scopes()
    {
        return [
            'category' => new CategoryScope(),
        ];
    }

    public function index()
    {
        return ProductIndexResource::collection(
            Product::withScopes($this->scopes())->paginate(10)
        );
    }

    public function show(Product $product)
    {
        return new ProductResource(
            $product
        );
    }
}
