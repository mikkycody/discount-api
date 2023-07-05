<?php

namespace App\Services\Product;

use App\Filters\Product\Category;
use App\Filters\Product\PriceLessThan;
use App\Models\Product;

class ProductService
{
    public function __construct(protected Product $productModel)
    {
    }
    public function get_products()
    {
        return $this->productModel->filterWithPipeline([
            Category::class,
            PriceLessThan::class,
        ])->latest()->take(5)->get();
    }
}
