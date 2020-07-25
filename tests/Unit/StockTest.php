<?php

namespace Tests\Unit;

use App\Clients\Client;
use App\Clients\ClientException;
use App\Clients\StockStatus;
use Facades\App\Clients\ClientFactory;
use App\Retailer;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use RetailerWithProduct;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_throws_an_exception_if_a_client_is_not_found_when_tracking()
    {
        $this->seed(RetailerWithProduct::class);

        Retailer::first()->update(['name' => 'Foo Retailer']);

        $this->expectException(ClientException::class);

        Stock::first()->track();
    }

    /**
     * @test
     */
    public function it_updates_local_stock_status_after_being_tracked()
    {
        $this->seed(RetailerWithProduct::class);

//        $clientMock = Mockery::mock(Client::class);
//        $clientMock->shouldReceive('checkAvailability')
//            ->andReturn(new StockStatus($available = true, $price = 1000));

        ClientFactory::shouldReceive('make->checkAvailability')->andReturn(
            new StockStatus($available = true, $price = 1000)
        );

        $stock = tap(Stock::first())->track();
        $this->assertTrue($stock->in_stock);
        $this->assertEquals(1000, $stock->price);
    }
}
