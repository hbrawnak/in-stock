<?php

namespace App\Console\Commands;

use App\Product;
use Illuminate\Console\Command;

class TrackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track all product stock';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Product::all()
            ->tap(fn($products) => $this->output->progressStart($products->count()))
            ->each(function ($product) {
                $product->track();
                $this->output->progressAdvance();
            });

        $this->results();
    }

    protected function results()
    {
        $this->output->progressFinish();
        $data = Product::leftJoin('stock', 'stock.product_id', '=', 'products.id')
            ->get(['name', 'price', 'url', 'in_stock']);

        $this->table(['name', 'price', 'url', 'in_stock'], $data);
    }
}
