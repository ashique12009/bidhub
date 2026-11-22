<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;

class ProductController extends Controller {
  public function index() {
    $products = Product::latest()->paginate(10);

    return ProductResource::collection($products);
  }

  public function show(Product $product) {
    return new ProductResource($product);
  }
}