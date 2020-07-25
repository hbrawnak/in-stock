<?php

namespace Tests\Feature;

use App\Product;
use App\Retailer;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use RetailerWithProduct;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;


    /**
     * @test
     */
    function it_tracks_product_stock()
    {
        $this->seed(RetailerWithProduct::class);

        $this->assertFalse(Product::first()->inStock());

        Http::fake(fn() => ['available' => true, 'price' => 1000]);

        $this->artisan('track')
            ->expectsOutput('All Done');

        $this->assertTrue(Product::first()->inStock());
    }
}
