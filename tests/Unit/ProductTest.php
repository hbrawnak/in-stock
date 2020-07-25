<?php

namespace Tests\Unit;

use App\Product;
use App\Retailer;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RetailerWithProduct;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_stock_for_products_in_retailers()
    {
        $this->seed(RetailerWithProduct::class);

        tap(Product::first(), function ($product) {
            $this->assertFalse($product->inStock());

            $product->stock()->first()->update(['in_stock' => true]);

            $this->assertTrue($product->inStock());
        });
    }
}
