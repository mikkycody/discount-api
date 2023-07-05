<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Services\Product\ProductService;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }
    public function index()
    {
        $products = $this->productService->get_products();
        // return $products;
        return ProductResource::collection($products)->additional(['status' => true, 'message' => 'Products retrieved.']);
    }
}
