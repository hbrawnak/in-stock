<?php

namespace Tests\Feature;

use App\Product;
use RetailerWithProduct;
use Tests\TestCase;
use App\Clients\StockStatus;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_tracks_product_stock()
    {
        $this->seed(RetailerWithProduct::class);

        $this->assertFalse(Product::first()->inStock());

        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available = true, $price = 1000));

        $this->artisan('track');

        $this->assertTrue(Product::first()->inStock());
    }
}
