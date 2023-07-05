<?php

namespace Tests\Feature\App\Http\Controllers\Product;

use App\Enums\Product\Category\CategoryEnum;
use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldGetProducts()
    {
        $this->seed([ProductSeeder::class]);
        $product = Product::latest()->first();
        $response = $this->getJson('api/products');
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseCount('products', 5);
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('status')
                ->has('message')
                ->has('data', 5)
                ->has(
                    'data.0',
                    fn ($json) => $json->where('sku', $product->sku)
                        ->where('name', $product->name)
                        ->where('category', $product->category)
                        ->has(
                            'price',
                            fn ($json) => $json->where('original', $product->price)
                                ->where('final', ((int)($product->price - ($product->price * 0.3))))
                                ->where('discount_percentage', '30%')
                                ->where('currency', 'EUR')
                                ->etc()
                        )
                )
        );
    }

    public function testShouldGetProductsWithCategoryFilter()
    {
        $this->seed([ProductSeeder::class]);
        $productsCount = Product::whereCategory(CategoryEnum::BOOTS())->count();
        $response = $this->json('GET', 'api/products', ['category' => CategoryEnum::BOOTS()]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('status')
                ->has('message')
                ->has('data', $productsCount)
        );
        $this->assertDatabaseCount('products', 5);
    }

    public function testShouldGetProductsWithPriceLessThanFilter()
    {
        $this->seed([ProductSeeder::class]);
        $priceLessThanValue = 65000;
        $productsCount = Product::where('price', '<', $priceLessThanValue)->count();
        $response = $this->json('GET', 'api/products', ['priceLessThan' => $priceLessThanValue]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('status')
                ->has('message')
                ->has('data', $productsCount)
        );
        $this->assertDatabaseCount('products', 5);
    }

    public function testShouldApplyFifteenPercentDiscountOnProductWithSku000003()
    {
        $this->seed([ProductSeeder::class]);
        $product = tap(Product::firstWhere('sku', '000003'))->update(['category' => CategoryEnum::SANDALS()]);

        $response = $this->getJson('api/products');
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseCount('products', 5);
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('status')
                ->has('message')
                ->has('data', 5)
                ->has(
                    'data.2',
                    fn ($json) => $json->where('sku', $product->sku)
                        ->where('name', $product->name)
                        ->where('category', $product->category)
                        ->has(
                            'price',
                            fn ($json) => $json->where('original', $product->price)
                                ->where('final', ((int)($product->price - ($product->price * 0.15))))
                                ->where('discount_percentage', '15%')
                                ->where('currency', 'EUR')
                                ->etc()
                        )
                )
        );
    }

    public function testShouldApplyBiggerDiscount()
    {
        $this->seed([ProductSeeder::class]);
        $product = Product::firstWhere('sku', '000003');

        $response = $this->getJson('api/products');
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseCount('products', 5);
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('status')
                ->has('message')
                ->has('data', 5)
                ->has(
                    'data.2',
                    fn ($json) => $json->where('sku', $product->sku)
                        ->where('name', $product->name)
                        ->where('category', $product->category)
                        ->has(
                            'price',
                            fn ($json) => $json->where('original', $product->price)
                                ->where('final', ((int)($product->price - ($product->price * 0.30))))
                                ->where('discount_percentage', '30%')
                                ->where('currency', 'EUR')
                                ->etc()
                        )
                )
        );
    }

    public function testShouldNotApplyDiscountIfNoConditionsMatch()
    {
        $this->seed([ProductSeeder::class]);
        $product = Product::firstWhere('sku', '000005');

        $response = $this->getJson('api/products');
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseCount('products', 5);
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('status')
                ->has('message')
                ->has('data', 5)
                ->has(
                    'data.4',
                    fn ($json) => $json->where('sku', $product->sku)
                        ->where('name', $product->name)
                        ->where('category', $product->category)
                        ->has(
                            'price',
                            fn ($json) => $json->where('original', $product->price)
                                ->where('final', $product->price)
                                ->where('discount_percentage', null)
                                ->where('currency', 'EUR')
                                ->etc()
                        )
                )
        );
    }
}
