<?php

namespace Database\Seeders;

use App\Enums\Product\Category\CategoryEnum;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                "sku" => "000001",
                "name" => "BV Lean leather ankle boots",
                "category" => CategoryEnum::BOOTS(),
                "price" => 89000
            ],
            [
                "sku" => "000002",
                "name" => "BV Lean leather ankle boots",
                "category" => CategoryEnum::BOOTS(),
                "price" => 99000
            ],
            [
                "sku" => "000003",
                "name" => "Ashlington leather ankle boots",
                "category" => CategoryEnum::BOOTS(),
                "price" => 71000
            ],
            [
                "sku" => "000004",
                "name" => "Naima embellished suede sandals",
                "category" => CategoryEnum::SANDALS(),
                "price" => 79500
            ],
            [
                "sku" => "000005",
                "name" => "Nathane leather sneakers",
                "category" => CategoryEnum::SNEAKERS(),
                "price" => 59000
            ]
        ];

        Product::insert($products);
    }
}
