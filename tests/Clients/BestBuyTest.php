<?php

namespace Tests\Clients;

use App\Clients\BestBuy;
use App\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RetailerWithProduct;
use Tests\TestCase;

/**
 * @group api
 * */
class BestBuyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_tracks_a_product()
    {
        $this->seed(RetailerWithProduct::class);

        $stock = tap(Stock::first())->update([
            'sku' => '6364253', // Nintendo Switch sku
            'url' => 'https://www.bestbuy.com/site/nintendo-switch-32gb-console-gray-joy-con/6364253.p?skuId=6364253'
        ]);

        try {
            (new BestBuy())->checkAvailability($stock);
        } catch (\Exception $e) {
            $this->fail('Failed to track the BestBuy API properly.');
        }

        $this->assertTrue(true);
    }
}
