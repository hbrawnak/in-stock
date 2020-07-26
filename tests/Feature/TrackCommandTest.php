<?php

namespace Tests\Feature;

use App\Notifications\ImportantStockUpdate;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Notification;
use RetailerWithProduct;
use Tests\TestCase;
use App\Clients\StockStatus;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();

        $this->seed(RetailerWithProduct::class);
    }

    /** @test */
    function it_tracks_product_stock()
    {
        $this->assertFalse(Product::first()->inStock());

        $this->mockClientRequest();

        $this->artisan('track');

        $this->assertTrue(Product::first()->inStock());
    }

    /** @test */
    function it_does_not_notifies_when_the_stock_is_unavailable()
    {
        $this->mockClientRequest($available = false);

        $this->artisan('track');

        Notification::assertNothingSent();
    }

    /** @test */
    function it_notifies_the_user_when_the_stock_is_available()
    {
        $this->mockClientRequest();

        $this->artisan('track');

        Notification::assertSentTo(User::first(), ImportantStockUpdate::class);
    }
}
