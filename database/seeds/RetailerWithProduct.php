<?php

use App\Product;
use App\Retailer;
use App\Stock;
use App\User;
use Illuminate\Database\Seeder;

class RetailerWithProduct extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $switch = Product::create(['name' => 'Nintendo Switch']);

        $bestBuy = Retailer::create(['name' => 'Best Buy']);

        $stock = new Stock([
            'price' => 1000,
            'url' => 'http://foo.com',
            'sku' => '12345',
            'in_stock' => false
        ]);

        $bestBuy->addStock($switch, $stock);

        factory(User::class)->create(['email' => 'habib@example.com']);
    }
}
