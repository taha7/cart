<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        return ProductIndexResource::collection(
            Product::paginate(10)
        );
    }

    public function show(Product $product)
    {
        return new ProductResource(
            $product
        );
    }
}
